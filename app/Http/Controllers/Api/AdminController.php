<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\AdminResource;
use App\Models\Admin;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        return AdminResource::collection(Admin::all());
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:admins,email',
            'password' => 'required|string|min:8',
            'role' => 'sometimes|string|max:50',
        ]);

        $admin = Admin::create($data);

        return (new AdminResource($admin))
            ->response()
            ->setStatusCode(201);
    }

    public function show(Admin $admin)
    {
        return new AdminResource($admin);
    }

    public function update(Request $request, Admin $admin)
    {
        $data = $request->validate([
            'name' => 'sometimes|string|max:255',
            'email' => 'sometimes|email|unique:admins,email,' . $admin->id,
            'password' => 'sometimes|string|min:8',
            'role' => 'sometimes|string|max:50',
        ]);

        $admin->update($data);

        return new AdminResource($admin);
    }

    public function destroy(Admin $admin)
    {
        $admin->delete();

        return response()->noContent();
    }
}