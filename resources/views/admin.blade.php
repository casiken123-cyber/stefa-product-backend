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
        .stars { color: #E0A400; letter-spacing: 2px; white-space: nowrap; font-size: 15px; }
        .comment-cell { max-width: 320px; font-size: 13px; color: var(--ink-soft); line-height: 1.5; }

        /* Modals (product, user, category) */
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
        .info-lines { background: var(--cloud); border: 1px solid var(--line); border-radius: 12px; padding: 6px 16px; margin-bottom: 16px; }
        .info-lines div { display: flex; justify-content: space-between; gap: 16px; padding: 9px 0; border-bottom: 1px solid var(--line); font-size: 13px; }
        .info-lines div:last-child { border-bottom: none; }
        .info-lines span { color: var(--ink-soft); font-weight: 600; }
        .info-lines em { font-style: normal; text-align: right; word-break: break-word; }

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
            <a href="#" class="menu-link" onclick="switchAdminTab('admins', this)">Admin Accounts</a>

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

        <!-- PANEL SECTION 2: USER MANAGEMENT DIRECTORY (live from the API) -->
        <section id="tab-users" class="workspace-view-panel">
            <h1>User Account Directory</h1>
            <p class="sub-heading">View customer details, update their name and email, or remove accounts that have no orders.</p>
            <div class="table-card">
                <table>
                    <thead><tr><th>User ID</th><th>Customer Name</th><th>Email Address</th><th>Orders</th><th>Total Spent</th><th>Actions Control</th></tr></thead>
                    <tbody id="users-body"><tr><td colspan="6" class="table-note">Loading users...</td></tr></tbody>
                </table>
            </div>
        </section>

        <!-- PANEL SECTION 2B: ADMIN ACCOUNTS (live from the API) -->
        <section id="tab-admins" class="workspace-view-panel">
            <h1>Administrator Accounts</h1>
            <p class="sub-heading">Create, edit or remove the accounts that can sign in to this terminal. You cannot delete your own account.</p>
            <button class="action-btn primary-btn" onclick="openAdminModal(null)">Add Admin Account</button>
            <div class="table-card">
                <table>
                    <thead><tr><th>Admin ID</th><th>Name</th><th>Email Address</th><th>Role</th><th>Created</th><th>Actions Control</th></tr></thead>
                    <tbody id="admins-body"><tr><td colspan="6" class="table-note">Loading admin accounts...</td></tr></tbody>
                </table>
            </div>
        </section>

        <!-- PANEL SECTION 3: CATEGORIES ALLOCATIONS MANAGEMENT (live from the API) -->
        <section id="tab-categories" class="workspace-view-panel">
            <h1>Category Inventory Framework</h1>
            <p class="sub-heading">Add, rename or remove store departments. Renaming a category also updates its products.</p>
            <button class="action-btn primary-btn" onclick="openCategoryModal(null)">Add Category Selection</button>
            <div class="table-card">
                <table>
                    <thead><tr><th>System Department ID</th><th>Category Title Name</th><th>Products Bound Count</th><th>Actions Control</th></tr></thead>
                    <tbody id="categories-body"><tr><td colspan="4" class="table-note">Loading categories...</td></tr></tbody>
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
                    <thead><tr><th>Order</th><th>Customer</th><th>Items</th><th>Total</th><th>Placed</th><th>Status</th><th>Delivery Update</th></tr></thead>
                    <tbody id="orders-body"><tr><td colspan="7" class="table-note">Loading orders...</td></tr></tbody>
                </table>
            </div>
        </section>

        <!-- PANEL SECTION 7: BUYER REVIEWS (live from the API) -->
        <section id="tab-reviews" class="workspace-view-panel">
            <h1>Buyer Reviews</h1>
            <p class="sub-heading">Feedback customers left on products from their completed orders. Remove reviews that break your rules.</p>
            <div class="table-card">
                <table>
                    <thead><tr><th>Product</th><th>Customer</th><th>Rating</th><th>Comment</th><th>Date</th><th>Actions Control</th></tr></thead>
                    <tbody id="reviews-body"><tr><td colspan="6" class="table-note">Loading reviews...</td></tr></tbody>
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
                    <input type="text" id="p-category" list="category-options" maxlength="255" placeholder="Pick a category or type a new one">
                    <datalist id="category-options"></datalist>
                </div>
                <div class="field">
                    <label for="p-image">Product image (JPG, PNG or WEBP, max 2 MB)</label>
                    <input type="file" id="p-image" accept="image/jpeg,image/png,image/webp">
                    <img class="image-preview" id="p-image-preview" alt="Image preview">
                </div>
                <div class="modal-actions">
                    <button type="button" class="action-btn" onclick="closeModal('product-modal')">Cancel</button>
                    <button type="submit" class="action-btn primary-btn" id="product-save" style="margin: 0;">Save product</button>
                </div>
            </form>
        </div>
    </div>

    <!-- User details / edit modal -->
    <div class="modal-overlay" id="user-modal" role="dialog" aria-modal="true" aria-labelledby="user-modal-title">
        <div class="modal-card">
            <h2 id="user-modal-title">User details</h2>
            <p class="modal-error" id="user-error" role="alert"></p>
            <form id="user-form" novalidate>
                <div class="field">
                    <label for="u-name">Full name</label>
                    <input type="text" id="u-name" maxlength="255" required>
                </div>
                <div class="field">
                    <label for="u-email">Email address</label>
                    <input type="email" id="u-email" maxlength="255" required>
                </div>
                <div class="info-lines" id="user-info"></div>
                <div class="modal-actions">
                    <button type="button" class="action-btn" onclick="closeModal('user-modal')">Close</button>
                    <button type="submit" class="action-btn primary-btn" id="user-save" style="margin: 0;">Save changes</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Add / rename category modal -->
    <div class="modal-overlay" id="category-modal" role="dialog" aria-modal="true" aria-labelledby="category-modal-title">
        <div class="modal-card">
            <h2 id="category-modal-title">Add category</h2>
            <p class="modal-error" id="category-error" role="alert"></p>
            <form id="category-form" novalidate>
                <div class="field">
                    <label for="c-name">Category name</label>
                    <input type="text" id="c-name" maxlength="255" required>
                </div>
                <div class="modal-actions">
                    <button type="button" class="action-btn" onclick="closeModal('category-modal')">Cancel</button>
                    <button type="submit" class="action-btn primary-btn" id="category-save" style="margin: 0;">Save category</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Add / edit admin modal -->
    <div class="modal-overlay" id="admin-modal" role="dialog" aria-modal="true" aria-labelledby="admin-modal-title">
        <div class="modal-card">
            <h2 id="admin-modal-title">Add admin account</h2>
            <p class="modal-error" id="admin-error" role="alert"></p>
            <form id="admin-form" novalidate>
                <div class="field">
                    <label for="a-name">Full name</label>
                    <input type="text" id="a-name" maxlength="255" required>
                </div>
                <div class="field">
                    <label for="a-email">Email address</label>
                    <input type="email" id="a-email" maxlength="255" required>
                </div>
                <div class="field">
                    <label for="a-role">Role (optional)</label>
                    <input type="text" id="a-role" maxlength="50" placeholder="For example: Manager">
                </div>
                <div class="field">
                    <label for="a-password" id="a-password-label">Password</label>
                    <input type="password" id="a-password" minlength="8" autocomplete="new-password">
                </div>
                <div class="modal-actions">
                    <button type="button" class="action-btn" onclick="closeModal('admin-modal')">Cancel</button>
                    <button type="submit" class="action-btn primary-btn" id="admin-save" style="margin: 0;">Save admin</button>
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
        function pad(n, size) { return String(n).padStart(size, '0'); }

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

        const JSON_HEADERS = { 'Content-Type': 'application/json' };

        // ---------- Modals ----------
        function openModal(id) { document.getElementById(id).classList.add('show'); }
        function closeModal(id) { document.getElementById(id).classList.remove('show'); }
        function showModalError(id, text) {
            const box = document.getElementById(id);
            box.textContent = text;
            box.style.display = text ? 'block' : 'none';
        }

        document.querySelectorAll('.modal-overlay').forEach(overlay => {
            overlay.addEventListener('click', function (e) {
                if (e.target === overlay) overlay.classList.remove('show');
            });
        });
        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape') document.querySelectorAll('.modal-overlay').forEach(o => o.classList.remove('show'));
        });

        // ---------- Tabs ----------
        function switchAdminTab(name, link) {
            document.querySelectorAll('.workspace-view-panel').forEach(p => p.classList.remove('active'));
            document.getElementById('tab-' + name).classList.add('active');
            document.querySelectorAll('.menu-link').forEach(l => l.classList.remove('active'));
            if (link) link.classList.add('active');

            if (name === 'dashboard' || name === 'reports') loadStats();
            if (name === 'users') loadUsers();
            if (name === 'admins') loadAdmins();
            if (name === 'categories') loadCategories();
            if (name === 'products' || name === 'inventory') loadProducts();
            if (name === 'orders') loadOrders();
            if (name === 'reviews') loadReviews();
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

        // ---------- Users (GET /api/admin/users, PUT and DELETE /api/admin/users/{id}) ----------
        let usersCache = [];
        let editingUserId = null;

        function renderUsers() {
            const body = document.getElementById('users-body');
            if (!usersCache.length) {
                body.innerHTML = '<tr><td colspan="6" class="table-note">No customers have registered yet.</td></tr>';
                return;
            }
            body.innerHTML = usersCache.map(u => (
                '<tr>' +
                    '<td class="money">#USR-' + pad(u.id, 4) + '</td>' +
                    '<td><strong>' + esc(u.name) + '</strong></td>' +
                    '<td>' + esc(u.email) + '</td>' +
                    '<td>' + Number(u.orders_count) + '</td>' +
                    '<td class="money">' + money(u.spent) + '</td>' +
                    '<td>' +
                        '<button class="action-btn" onclick="openUserModal(' + Number(u.id) + ')">Details / Edit</button>' +
                        '<button class="action-btn danger" onclick="deleteUser(' + Number(u.id) + ')">Delete</button>' +
                    '</td>' +
                '</tr>'
            )).join('');
        }

        async function loadUsers() {
            try {
                const json = await api('/api/admin/users');
                usersCache = json.data || [];
                renderUsers();
            } catch (err) {
                if (err.message !== 'AUTH') document.getElementById('users-body').innerHTML = '<tr><td colspan="6" class="table-note">Could not load users.</td></tr>';
            }
        }

        function openUserModal(id) {
            const u = usersCache.find(item => Number(item.id) === id);
            if (!u) return;
            editingUserId = id;
            showModalError('user-error', '');
            document.getElementById('user-modal-title').textContent = 'User #USR-' + pad(u.id, 4);
            document.getElementById('u-name').value = u.name || '';
            document.getElementById('u-email').value = u.email || '';
            document.getElementById('user-info').innerHTML =
                '<div><span>Phone</span><em>' + esc(u.phone || '-') + '</em></div>' +
                '<div><span>City / region</span><em>' + esc(u.city || '-') + '</em></div>' +
                '<div><span>Delivery address</span><em>' + esc(u.address || '-') + '</em></div>' +
                '<div><span>Orders placed</span><em>' + Number(u.orders_count) + '</em></div>' +
                '<div><span>Total spent</span><em>' + money(u.spent) + '</em></div>' +
                '<div><span>Joined</span><em>' + esc(formatDate(u.created_at)) + '</em></div>';
            openModal('user-modal');
        }

        document.getElementById('user-form').addEventListener('submit', async function (e) {
            e.preventDefault();
            showModalError('user-error', '');

            const saveBtn = document.getElementById('user-save');
            saveBtn.disabled = true;
            try {
                await api('/api/admin/users/' + editingUserId, {
                    method: 'PUT',
                    headers: JSON_HEADERS,
                    body: JSON.stringify({
                        name: document.getElementById('u-name').value.trim(),
                        email: document.getElementById('u-email').value.trim()
                    })
                });
                closeModal('user-modal');
                showToast('User updated');
                loadUsers();
            } catch (err) {
                if (err.message !== 'AUTH') showModalError('user-error', err.message);
            }
            saveBtn.disabled = false;
        });

        async function deleteUser(id) {
            const u = usersCache.find(item => Number(item.id) === id);
            if (!u) return;
            if (!confirm('Delete the account of ' + u.name + '? This cannot be undone.')) return;
            try {
                await api('/api/admin/users/' + id, { method: 'DELETE' });
                showToast('User deleted');
                loadUsers();
                loadStats();
            } catch (err) {
                if (err.message !== 'AUTH') showToast(err.message);
            }
        }

        // ---------- Admin accounts (GET/POST/PUT/DELETE /api/admins) ----------
        let adminsCache = [];
        let editingAdminId = null;

        function renderAdmins() {
            const body = document.getElementById('admins-body');
            if (!adminsCache.length) {
                body.innerHTML = '<tr><td colspan="6" class="table-note">No admin accounts found.</td></tr>';
                return;
            }
            body.innerHTML = adminsCache.map(a => {
                const isMe = Number(a.id) === Number(adminUser.id);
                return '<tr>' +
                    '<td class="money">#ADM-' + pad(a.id, 3) + '</td>' +
                    '<td><strong>' + esc(a.name) + '</strong>' + (isMe ? ' <span class="badge green">You</span>' : '') + '</td>' +
                    '<td>' + esc(a.email) + '</td>' +
                    '<td>' + esc(a.role || '-') + '</td>' +
                    '<td>' + esc(formatDate(a.created_at) || '-') + '</td>' +
                    '<td>' +
                        '<button class="action-btn" onclick="openAdminModal(' + Number(a.id) + ')">Edit</button>' +
                        (isMe ? '' : '<button class="action-btn danger" onclick="deleteAdmin(' + Number(a.id) + ')">Delete</button>') +
                    '</td>' +
                '</tr>';
            }).join('');
        }

        async function loadAdmins() {
            try {
                const json = await api('/api/admins');
                adminsCache = json.data || [];
                renderAdmins();
            } catch (err) {
                if (err.message !== 'AUTH') document.getElementById('admins-body').innerHTML = '<tr><td colspan="6" class="table-note">Could not load admin accounts.</td></tr>';
            }
        }

        function openAdminModal(id) {
            editingAdminId = id;
            showModalError('admin-error', '');
            document.getElementById('admin-form').reset();

            if (id === null) {
                document.getElementById('admin-modal-title').textContent = 'Add admin account';
                document.getElementById('a-password-label').textContent = 'Password (minimum 8 characters)';
            } else {
                const a = adminsCache.find(item => Number(item.id) === id);
                if (!a) return;
                document.getElementById('admin-modal-title').textContent = 'Edit admin #ADM-' + pad(a.id, 3);
                document.getElementById('a-name').value = a.name || '';
                document.getElementById('a-email').value = a.email || '';
                document.getElementById('a-role').value = a.role || '';
                document.getElementById('a-password-label').textContent = 'New password (leave empty to keep the current one)';
            }
            openModal('admin-modal');
            document.getElementById('a-name').focus();
        }

        document.getElementById('admin-form').addEventListener('submit', async function (e) {
            e.preventDefault();
            showModalError('admin-error', '');

            const name = document.getElementById('a-name').value.trim();
            const email = document.getElementById('a-email').value.trim();
            const role = document.getElementById('a-role').value.trim();
            const password = document.getElementById('a-password').value;
            const isNew = editingAdminId === null;

            if (!name || !email) {
                showModalError('admin-error', 'Name and email are required.');
                return;
            }
            if (isNew && password.length < 8) {
                showModalError('admin-error', 'The password needs at least 8 characters.');
                return;
            }

            const payload = { name: name, email: email };
            if (role) payload.role = role;
            if (password) payload.password = password;

            const saveBtn = document.getElementById('admin-save');
            saveBtn.disabled = true;
            try {
                await api(isNew ? '/api/admins' : '/api/admins/' + editingAdminId, {
                    method: isNew ? 'POST' : 'PUT',
                    headers: JSON_HEADERS,
                    body: JSON.stringify(payload)
                });
                closeModal('admin-modal');
                showToast(isNew ? 'Admin account created' : 'Admin account updated');
                loadAdmins();
            } catch (err) {
                if (err.message !== 'AUTH') showModalError('admin-error', err.message);
            }
            saveBtn.disabled = false;
        });

        async function deleteAdmin(id) {
            const a = adminsCache.find(item => Number(item.id) === id);
            if (!a) return;
            if (!confirm('Delete the admin account of ' + a.name + '? They will be signed out everywhere.')) return;
            try {
                await api('/api/admins/' + id, { method: 'DELETE' });
                showToast('Admin account deleted');
                loadAdmins();
            } catch (err) {
                if (err.message !== 'AUTH') showToast(err.message);
            }
        }

        // ---------- Categories (GET/POST/PUT/DELETE /api/categories) ----------
        let categoriesCache = [];
        let editingCategoryId = null;

        function fillCategoryOptions() {
            document.getElementById('category-options').innerHTML =
                categoriesCache.map(c => '<option value="' + esc(c.name) + '"></option>').join('');
        }

        function renderCategories() {
            const body = document.getElementById('categories-body');
            if (!categoriesCache.length) {
                body.innerHTML = '<tr><td colspan="4" class="table-note">No categories yet. Click "Add Category Selection" to create one.</td></tr>';
                return;
            }
            body.innerHTML = categoriesCache.map(c => (
                '<tr>' +
                    '<td class="money">#CAT-' + pad(c.id, 3) + '</td>' +
                    '<td><strong>' + esc(c.name) + '</strong></td>' +
                    '<td>' + Number(c.products_count) + ' Items</td>' +
                    '<td>' +
                        '<button class="action-btn" onclick="openCategoryModal(' + Number(c.id) + ')">Edit Category</button>' +
                        '<button class="action-btn danger" onclick="deleteCategory(' + Number(c.id) + ')">Delete</button>' +
                    '</td>' +
                '</tr>'
            )).join('');
        }

        async function loadCategories() {
            try {
                const json = await api('/api/categories');
                categoriesCache = json.data || [];
                renderCategories();
                fillCategoryOptions();
            } catch (err) {
                if (err.message !== 'AUTH') document.getElementById('categories-body').innerHTML = '<tr><td colspan="4" class="table-note">Could not load categories.</td></tr>';
            }
        }

        function openCategoryModal(id) {
            editingCategoryId = id;
            showModalError('category-error', '');
            const nameInput = document.getElementById('c-name');
            if (id === null) {
                document.getElementById('category-modal-title').textContent = 'Add category';
                nameInput.value = '';
            } else {
                const c = categoriesCache.find(item => Number(item.id) === id);
                if (!c) return;
                document.getElementById('category-modal-title').textContent = 'Rename category';
                nameInput.value = c.name;
            }
            openModal('category-modal');
            nameInput.focus();
        }

        document.getElementById('category-form').addEventListener('submit', async function (e) {
            e.preventDefault();
            showModalError('category-error', '');

            const name = document.getElementById('c-name').value.trim();
            if (!name) {
                showModalError('category-error', 'Enter a category name.');
                return;
            }

            const saveBtn = document.getElementById('category-save');
            saveBtn.disabled = true;
            try {
                const isNew = editingCategoryId === null;
                await api(isNew ? '/api/categories' : '/api/categories/' + editingCategoryId, {
                    method: isNew ? 'POST' : 'PUT',
                    headers: JSON_HEADERS,
                    body: JSON.stringify({ name: name })
                });
                closeModal('category-modal');
                showToast(isNew ? 'Category added' : 'Category renamed');
                loadCategories();
            } catch (err) {
                if (err.message !== 'AUTH') showModalError('category-error', err.message);
            }
            saveBtn.disabled = false;
        });

        async function deleteCategory(id) {
            const c = categoriesCache.find(item => Number(item.id) === id);
            if (!c) return;
            if (!confirm('Delete the category "' + c.name + '"?')) return;
            try {
                await api('/api/categories/' + id, { method: 'DELETE' });
                showToast('Category deleted');
                loadCategories();
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
                    headers: JSON_HEADERS,
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

        // ---------- Add / edit product modal ----------
        let editingId = null;
        const productForm = document.getElementById('product-form');
        const imageInput = document.getElementById('p-image');
        const imagePreview = document.getElementById('p-image-preview');

        function openProductModal(id) {
            editingId = id;
            productForm.reset();
            showModalError('product-error', '');
            imagePreview.style.display = 'none';
            imagePreview.removeAttribute('src');

            // The category list comes from the categories table
            loadCategories();

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
            openModal('product-modal');
            document.getElementById('p-name').focus();
        }

        imageInput.addEventListener('change', function () {
            const file = imageInput.files[0];
            if (!file) return;
            imagePreview.src = URL.createObjectURL(file);
            imagePreview.style.display = 'block';
        });

        productForm.addEventListener('submit', async function (e) {
            e.preventDefault();
            showModalError('product-error', '');

            const name = document.getElementById('p-name').value.trim();
            const price = document.getElementById('p-price').value;
            const stock = document.getElementById('p-stock').value;
            if (!name || price === '' || stock === '') {
                showModalError('product-error', 'Name, price and stock are required.');
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
                closeModal('product-modal');
                showToast(editingId === null ? 'Product added' : 'Product updated');
                loadProducts();
                loadStats();
            } catch (err) {
                if (err.message !== 'AUTH') showModalError('product-error', err.message);
            }

            saveBtn.disabled = false;
            saveBtn.textContent = 'Save product';
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
                '<td class="money">#STF-' + pad(o.id, 5) + '</td>' +
                '<td>' + customer + '</td>' +
                '<td class="order-items-cell">' + (items || '-') + '</td>' +
                '<td class="money">' + money(o.total) + '</td>' +
                '<td>' + esc(formatDate(o.created_at)) + '</td>' +
                '<td><select class="status-select" onchange="changeOrderStatus(' + Number(o.id) + ', this)">' + options + '</select></td>' +
                '<td><button class="action-btn" onclick="notifyCustomer(' + Number(o.id) + ')">Send update</button></td>' +
            '</tr>';
        }

        async function loadOrders() {
            const body = document.getElementById('orders-body');
            try {
                const json = await api('/api/admin/orders');
                const orders = json.data || [];
                body.innerHTML = orders.length
                    ? orders.map(orderRowHtml).join('')
                    : '<tr><td colspan="7" class="table-note">No orders yet.</td></tr>';
            } catch (err) {
                if (err.message !== 'AUTH') body.innerHTML = '<tr><td colspan="7" class="table-note">Could not load orders.</td></tr>';
            }
        }

        async function changeOrderStatus(id, select) {
            select.disabled = true;
            try {
                await api('/api/admin/orders/' + id, {
                    method: 'PUT',
                    headers: JSON_HEADERS,
                    body: JSON.stringify({ status: select.value })
                });
                showToast('Order #STF-' + pad(id, 5) + ' set to ' + select.value + '. The customer was notified.');
                loadStats();
            } catch (err) {
                if (err.message !== 'AUTH') {
                    showToast(err.message);
                    loadOrders();
                }
            }
            select.disabled = false;
        }

        // Send the customer a custom delivery update (POST /api/admin/orders/{id}/notify)
        async function notifyCustomer(id) {
            const message = prompt('Delivery update for order #STF-' + pad(id, 5) + ' (the customer sees this in Notifications):');
            if (message === null) return;
            if (!message.trim()) {
                showToast('Write a message first.');
                return;
            }
            try {
                await api('/api/admin/orders/' + id + '/notify', {
                    method: 'POST',
                    headers: JSON_HEADERS,
                    body: JSON.stringify({ message: message.trim() })
                });
                showToast('Update sent to the customer');
            } catch (err) {
                if (err.message !== 'AUTH') showToast(err.message);
            }
        }

        // ---------- Reviews (GET /api/admin/reviews, DELETE /api/admin/reviews/{id}) ----------
        let reviewsCache = [];

        function starText(rating) {
            const n = Math.max(0, Math.min(5, Number(rating) || 0));
            return '\u2605'.repeat(n) + '\u2606'.repeat(5 - n);
        }

        function renderReviews() {
            const body = document.getElementById('reviews-body');
            if (!reviewsCache.length) {
                body.innerHTML = '<tr><td colspan="6" class="table-note">No reviews yet. Customers can review products after an order is marked completed.</td></tr>';
                return;
            }
            body.innerHTML = reviewsCache.map(r => (
                '<tr>' +
                    '<td><strong>' + esc(r.product ? r.product.name : 'Deleted product') + '</strong></td>' +
                    '<td>' + esc(r.customer ? r.customer.name : 'Unknown') + '</td>' +
                    '<td><span class="stars">' + starText(r.rating) + '</span></td>' +
                    '<td class="comment-cell">' + esc(r.comment) + '</td>' +
                    '<td>' + esc(formatDate(r.created_at)) + '</td>' +
                    '<td><button class="action-btn danger" onclick="deleteReview(' + Number(r.id) + ')">Delete</button></td>' +
                '</tr>'
            )).join('');
        }

        async function loadReviews() {
            try {
                const json = await api('/api/admin/reviews');
                reviewsCache = json.data || [];
                renderReviews();
            } catch (err) {
                if (err.message !== 'AUTH') document.getElementById('reviews-body').innerHTML = '<tr><td colspan="6" class="table-note">Could not load reviews.</td></tr>';
            }
        }

        async function deleteReview(id) {
            if (!confirm('Delete this review? This cannot be undone.')) return;
            try {
                await api('/api/admin/reviews/' + id, { method: 'DELETE' });
                showToast('Review deleted');
                loadReviews();
            } catch (err) {
                if (err.message !== 'AUTH') showToast(err.message);
            }
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
