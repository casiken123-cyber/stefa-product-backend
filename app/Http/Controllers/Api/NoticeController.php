<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Notice;
use Illuminate\Http\Request;

class NoticeController extends Controller
{
    // Customer: their latest delivery updates and how many are unread
    public function index(Request $request)
    {
        $userId = $request->user()->id;

        $notices = Notice::where('user_id', $userId)->latest()->take(50)->get();

        return response()->json([
            'unread' => Notice::where('user_id', $userId)->whereNull('read_at')->count(),
            'data' => $notices->map(fn ($notice) => [
                'id' => $notice->id,
                'order_id' => $notice->order_id,
                'message' => $notice->message,
                'read' => $notice->read_at !== null,
                'created_at' => $notice->created_at,
            ]),
        ]);
    }

    // Customer: mark everything as read
    public function readAll(Request $request)
    {
        Notice::where('user_id', $request->user()->id)
            ->whereNull('read_at')
            ->update(['read_at' => now()]);

        return response()->json(['message' => 'Notifications marked as read']);
    }

    // Customer: delete one of their own notifications
    public function destroy(Request $request, Notice $notice)
    {
        if ($notice->user_id !== $request->user()->id) {
            return response()->json([
                'message' => 'You can only delete your own notifications.',
            ], 403);
        }

        $notice->delete();

        return response()->json(['message' => 'Notification deleted']);
    }

    // Customer: delete all of their notifications
    public function clear(Request $request)
    {
        Notice::where('user_id', $request->user()->id)->delete();

        return response()->json(['message' => 'Notifications cleared']);
    }
}