<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>StefaShop - Administrative Master Control Center</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@500;600;700&family=Inter:wght@400;500;600&family=IBM+Plex+Mono:wght@500;600&display=swap" rel="stylesheet">
    <style>
        :root {
            --ink: #12181B;
            --ink-soft: #4A5459;
            --cloud: #F5F6F2;
            --panel: #FFFFFF;
            --line: #E1E4DE;
            --mango: #FF7A29;
            --mango-dark: #E15F0F;
            --teal: #0E4C47;
            --teal-soft: #E6EFEE;
            --danger: #C43D3D;
            --success: #1E8E5A;
            --success-soft: #E5F3EA;
            --info: #2563EB;
            --info-soft: #DBEAFE;
            --warn: #EA580C;
            --warn-soft: #FFEDD5;
            --radius-lg: 14px;
            --radius-md: 10px;
        }

        * { box-sizing: border-box; }

        body {
            font-family: 'Inter', system-ui, sans-serif;
            background: var(--cloud);
            color: var(--ink);
            margin: 0;
            display: flex;
            height: 100vh;
            overflow: hidden;
            -webkit-font-smoothing: antialiased;
        }

        h1, h2, h3, .display { font-family: 'Space Grotesk', sans-serif; }

        /* Left Administrative Navigation Sidebar Component */
        aside {
            width: 260px;
            background: var(--teal);
            color: #B9CFCC;
            display: flex;
            flex-direction: column;
            padding: 24px;
            border-right: 1px solid rgba(255,255,255,0.06);
            overflow-y: auto;
        }
        .admin-brand {
            font-family: 'Space Grotesk', sans-serif;
            font-size: 19px;
            font-weight: 700;
            color: white;
            margin-bottom: 32px;
            text-decoration: none;
            letter-spacing: -0.01em;
        }
        .admin-brand span { color: var(--mango); }
        .sidebar-section-title {
            font-family: 'IBM Plex Mono', monospace;
            font-size: 10px;
            font-weight: 600;
            color: #6E8B87;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            margin: 18px 0 8px 10px;
        }
        .menu-link {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px 14px;
            color: #CFE0DE;
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            border-radius: var(--radius-md);
            margin-bottom: 4px;
            transition: all 0.15s;
        }
        .menu-link:hover { background: rgba(255,255,255,0.06); color: white; }
        .menu-link.active {
            border-left: 3px solid var(--mango);
            border-radius: 0 var(--radius-md) var(--radius-md) 0;
            background: rgba(255, 122, 41, 0.14);
            color: white;
            font-weight: 600;
        }

        /* Right Content Panel Sheets Window Workspace */
        main { flex: 1; display: flex; flex-direction: column; background: var(--cloud); overflow-y: auto; }
        header {
            background: var(--panel);
            padding: 16px 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid var(--line);
        }
        header > div { font-weight: 600; color: var(--ink-soft); font-size: 14px; }
        header a { text-decoration: none; color: var(--danger); font-size: 13px; font-weight: 600; }
        header a:hover { color: #A83232; }

        .workspace-view-panel { padding: 40px; display: none; }
        .workspace-view-panel.active { display: block; }

        h1 { font-size: 22px; font-weight: 700; margin: 0 0 6px 0; letter-spacing: -0.01em; }
        .sub-heading { font-size: 14px; color: var(--ink-soft); margin: 0 0 24px 0; }

        /* Stats Summary Widgets Grid */
        .stats-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 18px; margin-bottom: 32px; }
        .stat-card { background: var(--panel); padding: 22px; border-radius: var(--radius-lg); border: 1px solid var(--line); }
        .stat-card p { margin: 0; color: var(--ink-soft); font-size: 12px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.04em; }
        .stat-card h3 { margin: 10px 0 0 0; font-size: 26px; font-weight: 700; color: var(--ink); font-family: 'IBM Plex Mono', monospace; }

        /* Data Sheets Master Table Layouts */
        .table-card { background: var(--panel); border-radius: var(--radius-lg); border: 1px solid var(--line); overflow: hidden; }
        table { width: 100%; border-collapse: collapse; text-align: left; font-size: 14px; }
        th {
            background: var(--cloud);
            padding: 13px 24px;
            font-weight: 600;
            color: var(--ink-soft);
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 0.04em;
            border-bottom: 1px solid var(--line);
        }
        td { padding: 16px 24px; border-bottom: 1px solid var(--cloud); color: var(--ink); vertical-align: middle; }
        tr:last-child td { border-bottom: none; }
        td strong { font-weight: 600; }
        td.table-note { text-align: center; color: var(--ink-soft); padding: 32px 24px; }

        /* UI Control Action Badges */
        .badge {
            font-family: 'IBM Plex Mono', monospace;
            background: var(--cloud);
            color: var(--ink-soft);
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.03em;
            display: inline-block;
        }
        .badge.green { background: var(--success-soft); color: var(--success); }
        .badge.blue { background: var(--info-soft); color: var(--info); }
        .badge.orange { background: var(--warn-soft); color: var(--warn); }
        .badge.red { background: #FBE9E7; color: var(--danger); }

        .action-btn {
            background: none;
            border: 1px solid var(--line);
            padding: 6px 12px;
            border-radius: 8px;
            font-size: 12px;
            font-weight: 600;
            cursor: pointer;
            color: var(--ink);
            margin-right: 4px;
            font-family: 'Inter', sans-serif;
            transition: all 0.15s;
        }
        .action-btn:hover { background: var(--cloud); border-color: var(--ink-soft); }
        .action-btn.danger { color: var(--danger); }
        .action-btn.danger:hover { background: #FBE9E7; border-color: var(--danger); }
        .action-btn:disabled { opacity: 0.6; cursor: not-allowed; }
        .action-btn.primary-btn {
            background: var(--mango);
            color: white;
            border: none;
            padding: 10px 18px;
            font-size: 13px;
            font-weight: 600;
            border-radius: var(--radius-md);
            margin-bottom: 16px;
        }
        .action-btn.primary-btn:hover { background: var(--mango-dark); }

        .thumb { width: 44px; height: 44px; border-radius: 10px; object-fit: cover; border: 1px solid var(--line); background: var(--cloud); display: block; }
        .status-select {
            padding: 7px 10px;
            border-radius: 8px;
            border: 1px solid var(--line);
            background: var(--panel);
            font-family: 'Inter', sans-serif;
            font-size: 13px;
            font-weight: 600;
            color: var(--ink);
            cursor: pointer;
        }
        .order-items-cell { font-size: 13px; color: var(--ink-soft); line-height: 1.5; }
        .money { font-family: 'IBM Plex Mono', monospace; font-weight: 600; }

        /* Product modal */
        .modal-overlay {
            position: fixed;
            inset: 0;
            background: rgba(18, 24, 27, 0.5);
            display: none;
            align-items: center;
            justify-content: center;
            padding: 20px;
            z-index: 100;
        }
        .modal-overlay.show { display: flex; }
        .modal-card {
            background: var(--panel);
            border-radius: 18px;
            width: 100%;
            max-width: 520px;
            max-height: 92vh;
            overflow-y: auto;
            padding: 28px;
            box-shadow: 0 30px 60px -20px rgba(18, 24, 27, 0.4);
        }
        .modal-card h2 { margin: 0 0 20px 0; font-size: 20px; }
        .field { display: flex; flex-direction: column; gap: 6px; margin-bottom: 16px; }
        .field-row { display: grid; grid-template-columns: 1fr 1fr; gap: 14px; }
        .field label { font-size: 12px; font-weight: 600; color: var(--ink-soft); letter-spacing: 0.04em; }
        .field input, .field textarea {
            padding: 11px 14px;
            border-radius: 10px;
            border: 1px solid var(--line);
            background: var(--cloud);
            font-family: inherit;
            font-size: 14px;
            color: var(--ink);
            outline: none;
        }
        .field input:focus, .field textarea:focus { border-color: var(--mango); background: var(--panel); box-shadow: 0 0 0 4px rgba(255, 122, 41, 0.14); }
        .modal-error { display: none; background: #FBE9E7; color: var(--danger); border: 1px solid #F0C4BE; border-radius: 10px; padding: 10px 14px; font-size: 13px; font-weight: 500; margin-bottom: 14px; }
        .modal-actions { display: flex; justify-content: flex-end; gap: 10px; margin-top: 8px; }
        .modal-actions .action-btn { margin: 0; padding: 10px 18px; font-size: 13px; }
        .image-preview { width: 84px; height: 84px; border-radius: 12px; object-fit: cover; border: 1px solid var(--line); background: var(--cloud); margin-top: 6px; display: none; }

        .toast {
            position: fixed;
            left: 50%;
            bottom: 28px;
            transform: translate(-50%, 16px);
            background: var(--ink);
            color: #fff;
            padding: 12px 18px;
            border-radius: var(--radius-md);
            font-size: 14px;
            font-weight: 500;
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.2s ease, transform 0.3s ease;
            z-index: 200;
        }
        .toast.show { opacity: 1; transform: translate(-50%, 0); }
    </style>
</head>
<body>

    <!--  Administrative Navigation Sidebar Container -->
    <aside>
        <a href="/admin" class="admin-brand">STEFA<span>SHOP</span> <small style="font-size: 11px; font-weight: 500; display: block; color: #6E8B87; font-family: 'Inter', sans-serif; margin-top: 4px;">Admin Terminal</small></a>

        <nav style="display: flex; flex-direction: column; flex: 1;">
            <a href="#" class="menu-link active" onclick="switchAdminTab('dashboard', this)">Admin Dashboard</a>

            <div class="sidebar-section-title">Identity & Access</div>
            <a href="#" class="menu-link" onclick="switchAdminTab('users', this)">User Management</a>

            <div class="sidebar-section-title">Storefront Content</div>
            <a href="#" class="menu-link" onclick="switchAdminTab('categories', this)">Category Management</a>
            <a href="#" class="menu-link" onclick="switchAdminTab('products', this)">Product Management</a>
            <a href="#" class="menu-link" onclick="switchAdminTab('inventory', this)">Inventory Stocks</a>

            <div class="sidebar-section-title">Fulfillment & Operations</div>
            <a href="#" class="menu-link" onclick="switchAdminTab('orders', this)">Orders</a>
            <a href="#" class="menu-link" onclick="switchAdminTab('reviews', this)">Buyer Reviews</a>

            <div class="sidebar-section-title">Analytics</div>
            <a href="#" class="menu-link" onclick="switchAdminTab('reports', this)">Sales Report</a>
        </nav>
    </aside>

    <!--  Right Side Content Output Workspaces Panel Window -->
    <main>
        <header>
            <div id="operator-label">System Operator Workspace Session</div>
            <a href="/login" id="exit-link">Exit Control Terminal →</a>
        </header>

        <!-- PANEL SECTION 1: MASTER REVENUE ANALYTICS DASHBOARD -->
        <section id="tab-dashboard" class="workspace-view-panel active">
            <h1>Control Panel Dashboard</h1>
            <p class="sub-heading">Real-time system transaction tracking and configuration counters logs.</p>

            <div class="stats-grid">
                <div class="stat-card"><p>Gross Marketplace Sales</p><h3 id="stat-sales">...</h3></div>
                <div class="stat-card"><p>Active Users</p><h3 id="stat-users">...</h3></div>
                <div class="stat-card"><p>Fulfillment Order Traffic</p><h3 id="stat-orders">...</h3></div>
                <div class="stat-card"><p>Stock Warning Low Units</p><h3 id="stat-low" style="color: var(--danger);">...</h3></div>
            </div>
        </section>

        <!-- PANEL SECTION 2: USER MANAGEMENT DIRECTORY -->
        <section id="tab-users" class="workspace-view-panel">
            <h1>User Account Directory</h1>
            <p class="sub-heading">View, evaluate credentials data configurations, and update active system buyers.</p>
            <div class="table-card">
                <table>
                    <thead><tr><th>User Identification ID</th><th>Customer Name</th><th>Email Address</th><th>Status Badge</th><th>Actions Control</th></tr></thead>
                    <tbody>
                        <tr><td>#USR-0824</td><td><strong>Stefan Dev</strong></td><td>stefan@example.com</td><td><span class="badge green">Active Buyer</span></td><td><button class="action-btn" onclick="alert('Viewing User: Stefan Dev');">User Details</button><button class="action-btn" onclick="alert('Form Field Loaded: Edit User #USR-0824');">Edit User</button></td></tr>
                        <tr><td>#USR-0911</td><td><strong>Ken User</strong></td><td>ken@example.com</td><td><span class="badge green">Active Buyer</span></td><td><button class="action-btn">User Details</button><button class="action-btn">Edit User</button></td></tr>
                    </tbody>
                </table>
            </div>
        </section>

        <!-- PANEL SECTION 3: CATEGORIES ALLOCATIONS MANAGEMENT -->
        <section id="tab-categories" class="workspace-view-panel">
            <h1>Category Inventory Framework</h1>
            <p class="sub-heading">Add, update taxonomy metrics classifications, or audit store departments parameters.</p>
            <button class="action-btn primary-btn" onclick="alert('Modal Box Open: Add New Category Fields Sheet...');">Add Category Selection</button>
            <div class="table-card">
                <table>
                    <thead><tr><th>System Department ID</th><th>Category Title Name</th><th>Products Bound Count</th><th>Actions Control</th></tr></thead>
                    <tbody>
                        <tr><td>#CAT-101</td><td><strong>Sneakers</strong></td><td>12 Items</td><td><button class="action-btn" onclick="alert('Category Hierarchy: Category Details #CAT-101');">Category Details</button><button class="action-btn" onclick="alert('Form Field Loaded: Edit Category #CAT-101');">Edit Category</button></td></tr>
                        <tr><td>#CAT-102</td><td><strong>Audio Appliances</strong></td><td>8 Items</td><td><button class="action-btn">Category Details</button><button class="action-btn">Edit Category</button></td></tr>
                    </tbody>
                </table>
            </div>
        </section>

        <!-- PANEL SECTION 4: PRODUCT MANAGEMENT WORKSPACE (live from the API) -->
        <section id="tab-products" class="workspace-view-panel">
            <h1>Store Catalog Items Registry</h1>
            <p class="sub-heading">Configure product parameters data properties, description layouts, and prices.</p>
            <button class="action-btn primary-btn" onclick="openProductModal(null)">Add Product to Store</button>
            <div class="table-card">
                <table>
                    <thead><tr><th>Image</th><th>Product Name</th><th>Category</th><th>Price</th><th>Stock</th><th>Actions Control</th></tr></thead>
                    <tbody id="products-body"><tr><td colspan="6" class="table-note">Loading products...</td></tr></tbody>
                </table>
            </div>
        </section>

        <!-- PANEL SECTION 5: INVENTORY STOCKS (live from the API) -->
        <section id="tab-inventory" class="workspace-view-panel">
            <h1>Inventory Stock Levels</h1>
            <p class="sub-heading">Monitor stock counts and update them. Products with 5 units or fewer are flagged as low.</p>
            <div class="table-card">
                <table>
                    <thead><tr><th>Product Name</th><th>Category</th><th>Units In Stock</th><th>Status</th><th>Actions Control</th></tr></thead>
                    <tbody id="inventory-body"><tr><td colspan="5" class="table-note">Loading inventory...</td></tr></tbody>
                </table>
            </div>
        </section>

        <!-- PANEL SECTION 6: ORDERS (live from the API) -->
        <section id="tab-orders" class="workspace-view-panel">
            <h1>Customer Orders</h1>
            <p class="sub-heading">Review every order and update its fulfillment status.</p>
            <div class="table-card">
                <table>
                    <thead><tr><th>Order</th><th>Customer</th><th>Items</th><th>Total</th><th>Placed</th><th>Status</th></tr></thead>
                    <tbody id="orders-body"><tr><td colspan="6" class="table-note">Loading orders...</td></tr></tbody>
                </table>
            </div>
        </section>

        <!-- PANEL SECTION 7: BUYER REVIEWS -->
        <section id="tab-reviews" class="workspace-view-panel">
            <h1>Buyer Reviews</h1>
            <p class="sub-heading">Customer feedback on delivered products.</p>
            <div class="table-card">
                <table>
                    <tbody><tr><td class="table-note">Reviews are not connected to the backend yet. There is no reviews API, so nothing is stored.</td></tr></tbody>
                </table>
            </div>
        </section>

        <!-- PANEL SECTION 8: SALES REPORT (from the dashboard numbers) -->
        <section id="tab-reports" class="workspace-view-panel">
            <h1>Sales Report</h1>
            <p class="sub-heading">Summary built from live order and catalog data. Cancelled orders are not counted in sales.</p>
            <div class="stats-grid">
                <div class="stat-card"><p>Gross Sales</p><h3 id="rep-sales">...</h3></div>
                <div class="stat-card"><p>Total Orders</p><h3 id="rep-orders">...</h3></div>
                <div class="stat-card"><p>Average Order Value</p><h3 id="rep-avg">...</h3></div>
                <div class="stat-card"><p>Products In Catalog</p><h3 id="rep-products">...</h3></div>
            </div>
        </section>
    </main>

    <!-- Add / edit product modal -->
    <div class="modal-overlay" id="product-modal" role="dialog" aria-modal="true" aria-labelledby="product-modal-title">
        <div class="modal-card">
            <h2 id="product-modal-title">Add product</h2>
            <p class="modal-error" id="product-error" role="alert"></p>
            <form id="product-form" novalidate>
                <div class="field">
                    <label for="p-name">Product name</label>
                    <input type="text" id="p-name" maxlength="255" required>
                </div>
                <div class="field">
                    <label for="p-description">Description</label>
                    <textarea id="p-description" rows="3" style="resize: none;"></textarea>
                </div>
                <div class="field-row">
                    <div class="field">
                        <label for="p-price">Price ($)</label>
                        <input type="number" id="p-price" min="0" step="0.01" required>
                    </div>
                    <div class="field">
                        <label for="p-stock">Stock</label>
                        <input type="number" id="p-stock" min="0" step="1" required>
                    </div>
                </div>
                <div class="field">
                    <label for="p-category">Category</label>
                    <input type="text" id="p-category" list="category-options" maxlength="255" placeholder="Sneakers, Audio, Accessories...">
                    <datalist id="category-options">
                        <option value="Sneakers"></option>
                        <option value="Audio"></option>
                        <option value="Accessories"></option>
                    </datalist>
                </div>
                <div class="field">
                    <label for="p-image">Product image (JPG, PNG or WEBP, max 2 MB)</label>
                    <input type="file" id="p-image" accept="image/jpeg,image/png,image/webp">
                    <img class="image-preview" id="p-image-preview" alt="Image preview">
                </div>
                <div class="modal-actions">
                    <button type="button" class="action-btn" onclick="closeProductModal()">Cancel</button>
                    <button type="submit" class="action-btn primary-btn" id="product-save" style="margin: 0;">Save product</button>
                </div>
            </form>
        </div>
    </div>

    <div class="toast" id="toast" role="status" aria-live="polite"></div>

    <script>
        // ---------- Guard: only a logged-in admin may use this page ----------
        function readJSON(key, fallback) {
            try { return JSON.parse(localStorage.getItem(key)) || fallback; } catch (e) { return fallback; }
        }
        const token = localStorage.getItem('auth_token');
        const adminUser = readJSON('auth_user', {});

        function clearSession() {
            localStorage.removeItem('auth_token');
            localStorage.removeItem('auth_user');
            localStorage.removeItem('user_authenticated');
        }
        function forceLogin() {
            clearSession();
            window.location.href = '/login';
        }
        if (!token || adminUser.role !== 'admin') {
            forceLogin();
        }

        document.getElementById('operator-label').textContent =
            'System Operator Workspace Session' + (adminUser.name ? ' - ' + adminUser.name : '');

        // ---------- Helpers ----------
        function esc(value) {
            return String(value == null ? '' : value)
                .replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;')
                .replace(/"/g, '&quot;').replace(/'/g, '&#39;');
        }
        function money(n) { return '$' + Number(n || 0).toFixed(2); }
        function formatDate(iso) {
            const d = new Date(iso);
            return isNaN(d.getTime()) ? '' : d.toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' });
        }

        const FALLBACK_THUMB = 'data:image/svg+xml;utf8,' + encodeURIComponent(
            '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 68 68"><rect width="68" height="68" fill="#F3F4EF"/>' +
            '<path d="M20 44l9-11 7 8 6-7 11 13H20z" fill="#CBD3CE"/><circle cx="26" cy="24" r="5" fill="#CBD3CE"/></svg>'
        );

        let toastTimer;
        function showToast(message) {
            const toast = document.getElementById('toast');
            toast.textContent = message;
            toast.classList.add('show');
            clearTimeout(toastTimer);
            toastTimer = setTimeout(() => toast.classList.remove('show'), 2600);
        }

        // One place for every API call: adds the token, handles 401/403 and error messages
        async function api(path, options) {
            options = options || {};
            const headers = Object.assign(
                { 'Authorization': 'Bearer ' + token, 'Accept': 'application/json' },
                options.headers || {}
            );
            const res = await fetch(path, Object.assign({}, options, { headers: headers }));

            if (res.status === 401 || res.status === 403) {
                forceLogin();
                throw new Error('AUTH');
            }

            const json = await res.json().catch(() => ({}));
            if (!res.ok) {
                const firstError = json.errors ? Object.values(json.errors)[0][0] : null;
                throw new Error(firstError || json.message || 'Request failed.');
            }
            return json;
        }

        // ---------- Tabs ----------
        function switchAdminTab(name, link) {
            document.querySelectorAll('.workspace-view-panel').forEach(p => p.classList.remove('active'));
            document.getElementById('tab-' + name).classList.add('active');
            document.querySelectorAll('.menu-link').forEach(l => l.classList.remove('active'));
            if (link) link.classList.add('active');

            if (name === 'dashboard' || name === 'reports') loadStats();
            if (name === 'products' || name === 'inventory') loadProducts();
            if (name === 'orders') loadOrders();
        }

        // ---------- Dashboard and sales report (GET /api/admin/stats) ----------
        async function loadStats() {
            try {
                const s = await api('/api/admin/stats');
                document.getElementById('stat-sales').textContent = money(s.sales);
                document.getElementById('stat-users').textContent = s.users;
                document.getElementById('stat-orders').textContent = s.orders;
                document.getElementById('stat-low').textContent = s.low_stock + ' Items';

                document.getElementById('rep-sales').textContent = money(s.sales);
                document.getElementById('rep-orders').textContent = s.orders;
                document.getElementById('rep-avg').textContent = money(s.orders ? s.sales / s.orders : 0);
                document.getElementById('rep-products').textContent = s.products;
            } catch (err) {
                if (err.message !== 'AUTH') showToast(err.message);
            }
        }

        // ---------- Products (GET/POST/PUT/DELETE /api/products) ----------
        let productsCache = [];

        async function fetchAllProducts() {
            let page = 1;
            let last = 1;
            let all = [];
            do {
                const json = await api('/api/products?page=' + page);
                all = all.concat(json.data || []);
                last = (json.meta && json.meta.last_page) || 1;
                page++;
            } while (page <= last);
            return all;
        }

        function stockBadge(stock) {
            if (stock <= 0) return '<span class="badge red">Out of stock</span>';
            if (stock <= 5) return '<span class="badge orange">Low stock</span>';
            return '<span class="badge green">In stock</span>';
        }

        function renderProducts() {
            const body = document.getElementById('products-body');
            if (!productsCache.length) {
                body.innerHTML = '<tr><td colspan="6" class="table-note">No products yet. Click "Add Product to Store" to create one.</td></tr>';
                return;
            }
            body.innerHTML = productsCache.map(p => (
                '<tr>' +
                    '<td><img class="thumb" src="' + esc(p.image_url || FALLBACK_THUMB) + '" alt="" onerror="this.onerror=null; this.src=FALLBACK_THUMB;"></td>' +
                    '<td><strong>' + esc(p.name) + '</strong></td>' +
                    '<td>' + esc(p.category || '-') + '</td>' +
                    '<td class="money">' + money(p.price) + '</td>' +
                    '<td>' + esc(p.stock) + '</td>' +
                    '<td>' +
                        '<button class="action-btn" onclick="openProductModal(' + Number(p.id) + ')">Edit</button>' +
                        '<button class="action-btn danger" onclick="deleteProduct(' + Number(p.id) + ')">Delete</button>' +
                    '</td>' +
                '</tr>'
            )).join('');
        }

        function renderInventory() {
            const body = document.getElementById('inventory-body');
            if (!productsCache.length) {
                body.innerHTML = '<tr><td colspan="5" class="table-note">No products yet.</td></tr>';
                return;
            }
            body.innerHTML = productsCache.map(p => (
                '<tr>' +
                    '<td><strong>' + esc(p.name) + '</strong></td>' +
                    '<td>' + esc(p.category || '-') + '</td>' +
                    '<td class="money">' + esc(p.stock) + '</td>' +
                    '<td>' + stockBadge(Number(p.stock)) + '</td>' +
                    '<td><button class="action-btn" onclick="setStock(' + Number(p.id) + ')">Update stock</button></td>' +
                '</tr>'
            )).join('');
        }

        async function loadProducts() {
            try {
                productsCache = await fetchAllProducts();
                renderProducts();
                renderInventory();
            } catch (err) {
                if (err.message !== 'AUTH') {
                    document.getElementById('products-body').innerHTML = '<tr><td colspan="6" class="table-note">Could not load products.</td></tr>';
                    document.getElementById('inventory-body').innerHTML = '<tr><td colspan="5" class="table-note">Could not load inventory.</td></tr>';
                }
            }
        }

        // Update only the stock number
        async function setStock(id) {
            const product = productsCache.find(p => Number(p.id) === id);
            if (!product) return;
            const answer = prompt('New stock for "' + product.name + '":', product.stock);
            if (answer === null) return;
            const stock = parseInt(answer, 10);
            if (isNaN(stock) || stock < 0) {
                showToast('Enter a whole number, 0 or higher.');
                return;
            }
            try {
                await api('/api/products/' + id, {
                    method: 'PUT',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ stock: stock })
                });
                showToast('Stock updated');
                loadProducts();
                loadStats();
            } catch (err) {
                if (err.message !== 'AUTH') showToast(err.message);
            }
        }

        async function deleteProduct(id) {
            const product = productsCache.find(p => Number(p.id) === id);
            if (!product) return;
            if (!confirm('Delete "' + product.name + '"? This cannot be undone.')) return;
            try {
                await api('/api/products/' + id, { method: 'DELETE' });
                showToast('Product deleted');
                loadProducts();
                loadStats();
            } catch (err) {
                if (err.message !== 'AUTH') showToast(err.message);
            }
        }

        // ---------- Add / edit modal ----------
        let editingId = null;
        const productForm = document.getElementById('product-form');
        const imageInput = document.getElementById('p-image');
        const imagePreview = document.getElementById('p-image-preview');

        function showProductError(text) {
            const box = document.getElementById('product-error');
            box.textContent = text;
            box.style.display = text ? 'block' : 'none';
        }

        function openProductModal(id) {
            editingId = id;
            productForm.reset();
            showProductError('');
            imagePreview.style.display = 'none';
            imagePreview.removeAttribute('src');

            if (id === null) {
                document.getElementById('product-modal-title').textContent = 'Add product';
            } else {
                const p = productsCache.find(item => Number(item.id) === id);
                if (!p) return;
                document.getElementById('product-modal-title').textContent = 'Edit product';
                document.getElementById('p-name').value = p.name || '';
                document.getElementById('p-description').value = p.description || '';
                document.getElementById('p-price').value = p.price;
                document.getElementById('p-stock').value = p.stock;
                document.getElementById('p-category').value = p.category || '';
                if (p.image_url) {
                    imagePreview.src = p.image_url;
                    imagePreview.style.display = 'block';
                }
            }
            document.getElementById('product-modal').classList.add('show');
            document.getElementById('p-name').focus();
        }

        function closeProductModal() {
            document.getElementById('product-modal').classList.remove('show');
        }

        imageInput.addEventListener('change', function () {
            const file = imageInput.files[0];
            if (!file) return;
            imagePreview.src = URL.createObjectURL(file);
            imagePreview.style.display = 'block';
        });

        productForm.addEventListener('submit', async function (e) {
            e.preventDefault();
            showProductError('');

            const name = document.getElementById('p-name').value.trim();
            const price = document.getElementById('p-price').value;
            const stock = document.getElementById('p-stock').value;
            if (!name || price === '' || stock === '') {
                showProductError('Name, price and stock are required.');
                return;
            }

            const fd = new FormData();
            fd.append('name', name);
            fd.append('description', document.getElementById('p-description').value.trim());
            fd.append('price', price);
            fd.append('stock', stock);
            fd.append('category', document.getElementById('p-category').value.trim());
            if (imageInput.files[0]) fd.append('image', imageInput.files[0]);

            let url = '/api/products';
            if (editingId !== null) {
                // The route is PUT, but files only travel in a POST body, so the method is spoofed
                url += '/' + editingId;
                fd.append('_method', 'PUT');
            }

            const saveBtn = document.getElementById('product-save');
            saveBtn.disabled = true;
            saveBtn.textContent = 'Saving...';

            try {
                await api(url, { method: 'POST', body: fd });
                closeProductModal();
                showToast(editingId === null ? 'Product added' : 'Product updated');
                loadProducts();
                loadStats();
            } catch (err) {
                if (err.message !== 'AUTH') showProductError(err.message);
            }

            saveBtn.disabled = false;
            saveBtn.textContent = 'Save product';
        });

        document.getElementById('product-modal').addEventListener('click', function (e) {
            if (e.target === this) closeProductModal();
        });
        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape') closeProductModal();
        });

        // ---------- Orders (GET /api/admin/orders, PUT /api/admin/orders/{id}) ----------
        const ORDER_STATUSES = ['pending', 'processing', 'completed', 'cancelled'];

        function orderRowHtml(o) {
            const items = (o.items || []).map(it => esc(it.name || 'Item') + ' (' + Number(it.quantity || 1) + 'x)').join('<br>');
            const customer = o.customer
                ? '<strong>' + esc(o.customer.name) + '</strong><br><span class="order-items-cell">' + esc(o.customer.email) + '</span>'
                : '<span class="order-items-cell">Unknown</span>';
            const options = ORDER_STATUSES.map(s =>
                '<option value="' + s + '"' + (s === o.status ? ' selected' : '') + '>' + s.charAt(0).toUpperCase() + s.slice(1) + '</option>'
            ).join('');

            return '<tr>' +
                '<td class="money">#STF-' + String(o.id).padStart(5, '0') + '</td>' +
                '<td>' + customer + '</td>' +
                '<td class="order-items-cell">' + (items || '-') + '</td>' +
                '<td class="money">' + money(o.total) + '</td>' +
                '<td>' + esc(formatDate(o.created_at)) + '</td>' +
                '<td><select class="status-select" onchange="changeOrderStatus(' + Number(o.id) + ', this)">' + options + '</select></td>' +
            '</tr>';
        }

        async function loadOrders() {
            const body = document.getElementById('orders-body');
            try {
                const json = await api('/api/admin/orders');
                const orders = json.data || [];
                body.innerHTML = orders.length
                    ? orders.map(orderRowHtml).join('')
                    : '<tr><td colspan="6" class="table-note">No orders yet.</td></tr>';
            } catch (err) {
                if (err.message !== 'AUTH') body.innerHTML = '<tr><td colspan="6" class="table-note">Could not load orders.</td></tr>';
            }
        }

        async function changeOrderStatus(id, select) {
            select.disabled = true;
            try {
                await api('/api/admin/orders/' + id, {
                    method: 'PUT',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ status: select.value })
                });
                showToast('Order #STF-' + String(id).padStart(5, '0') + ' set to ' + select.value);
                loadStats();
            } catch (err) {
                if (err.message !== 'AUTH') {
                    showToast(err.message);
                    loadOrders();
                }
            }
            select.disabled = false;
        }

        // ---------- Exit: revoke the token on the server, clear the session ----------
        document.getElementById('exit-link').addEventListener('click', function () {
            fetch('/api/logout', {
                method: 'POST',
                headers: { 'Authorization': 'Bearer ' + token, 'Accept': 'application/json' },
                keepalive: true
            });
            clearSession();
        });

        // ---------- First load ----------
        loadStats();
    </script>

</body>
</html>