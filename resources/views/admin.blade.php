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
            <div>System Operator Workspace Session</div>
            <a href="/shop">Exit Control Terminal →</a>
        </header>

        <!-- PANEL SECTION 1: MASTER REVENUE ANALYTICS DASHBOARD -->
        <section id="tab-dashboard" class="workspace-view-panel active">
            <h1>Control Panel Dashboard</h1>
            <p class="sub-heading">Real-time system transaction tracking and configuration counters logs.</p>

            <div class="stats-grid">
                <div class="stat-card"><p>Gross Marketplace Sales</p><h3>0</h3></div>
                <div class="stat-card"><p>Active Users</p><h3>0</h3></div>
                <div class="stat-card"><p>Fulfillment Order Traffic</p><h3>0</h3></div>
                <div class="stat-card"><p>Stock Warning Low Units</p><h3 style="color: var(--danger);">2 Items</h3></div>
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

        <!-- PANEL SECTION 4: PRODUCT MANAGEMENT WORKSPACE -->
        <section id="tab-products" class="workspace-view-panel">
            <h1>Store Catalog Items Registry</h1>
            <p class="sub-heading">Configure product parameters data properties, description layouts, and prices.</p>
            <button class="action-btn primary-btn" onclick="alert('Modal Form Layer Panel Open: Add Product Fields Sheet...');">Add Product to Store</button>
            <div class="table-card">
                <table>