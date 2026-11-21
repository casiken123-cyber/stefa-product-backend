// Cart storage that belongs to a person, not to the browser.
//   Guest cart:    stefashop_cart:guest
//   Customer cart: stefashop_cart:<user id>
// Load this file before any other script that reads or writes the cart.
(function () {
    var PREFIX = 'stefashop_cart:';
    var MAX_QTY = 99;

    // Who owns a user object (the id, or the email when there is no id)
    function ownerOf(user) {
        return user ? String(user.id || user.email || '') || null : null;
    }

    // The signed-in customer's owner id, or null for a guest
    function currentOwner() {
        try {
            if (localStorage.getItem('user_authenticated') !== 'true') return null;
            return ownerOf(JSON.parse(localStorage.getItem('auth_user')));
        } catch (e) {
            return null;
        }
    }

    function key(owner) {
        return PREFIX + (owner || currentOwner() || 'guest');
    }

    function read(owner) {
        try { return JSON.parse(localStorage.getItem(key(owner))) || []; } catch (e) { return []; }
    }

    function write(items, owner) {
        localStorage.setItem(key(owner), JSON.stringify(items));
    }

    function count(owner) {
        return read(owner).reduce(function (sum, item) { return sum + (item.quantity || 1); }, 0);
    }

    // Move the guest cart into this user's cart (same product: add the quantities),
    // then empty the guest cart so the next guest starts clean.
    function mergeGuestInto(owner) {
        owner = String(owner || '');
        if (!owner) return;

        var guest = read('guest');
        if (!guest.length) return;

        var mine = read(owner);
        guest.forEach(function (g) {
            var found = mine.find(function (m) { return String(m.id) === String(g.id); });
            if (found) {
                found.quantity = Math.min(MAX_QTY, (found.quantity || 1) + (g.quantity || 1));
            } else {
                mine.push(g);
            }
        });

        write(mine, owner);
        localStorage.removeItem(key('guest'));
    }

    // One-time move of the old single-key cart ("stefashop_cart") to whoever owns this browser session now
    (function migrateLegacy() {
        var old = localStorage.getItem('stefashop_cart');
        if (old === null) return;
        if (!read().length) {
            try { write(JSON.parse(old) || []); } catch (e) {}
        }
        localStorage.removeItem('stefashop_cart');
    })();

    window.StefaCart = {
        ownerOf: ownerOf,
        read: read,
        write: write,
        count: count,
        mergeGuestInto: mergeGuestInto
    };
})();