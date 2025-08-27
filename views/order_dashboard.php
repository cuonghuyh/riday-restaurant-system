<?php 
$pageTitle = "Dashboard Nhân viên - Kimura Restaurant";
ob_start(); 
?>

<!-- New Dashboard Notification -->
<div class="alert alert-info alert-dismissible fade show" role="alert" style="margin: 0; border-radius: 0; position: sticky; top: 0; z-index: 1050;">
    <div class="container-fluid d-flex align-items-center justify-content-between">
        <div class="d-flex align-items-center">
            <i class="bi bi-star-fill me-2"></i>
            <strong>🎉 New Feature!</strong>
            <span class="ms-2">Try our new Riday-style Admin Dashboard with advanced menu management features!</span>
        </div>
        <div class="d-flex align-items-center gap-2">
            <a href="?controller=riday" class="btn btn-light btn-sm">
                <i class="bi bi-arrow-right-circle"></i> Try New Dashboard
            </a>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    </div>
</div>

<!DOCTYPE html>
<html lang="vi" data-bs-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riday Dashboard - Restaurant Management</title>
    
    <!-- Bootstrap 5.3 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --sidebar-width: 280px;
            --topbar-height: 70px;
            --primary-color: #6366f1;
            --primary-dark: #4f46e5;
            --success-color: #10b981;
            --warning-color: #f59e0b;
            --danger-color: #ef4444;
            --info-color: #06b6d4;
            --dark-bg: #0f172a;
            --card-bg: #1e293b;
            --border-color: #334155;
            --text-light: #cbd5e1;
            --text-muted: #64748b;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: var(--dark-bg);
            color: var(--text-light);
            overflow-x: hidden;
        }

        /* Sidebar Styles */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            width: var(--sidebar-width);
            height: 100vh;
            background: var(--card-bg);
            border-right: 1px solid var(--border-color);
            z-index: 1000;
            transition: all 0.3s ease;
            overflow-y: auto;
        }

        .sidebar.collapsed {
            width: 70px;
        }

        .sidebar-header {
            padding: 1.5rem;
            border-bottom: 1px solid var(--border-color);
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .sidebar-header .logo {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.25rem;
            font-weight: 700;
        }

        .sidebar-header .brand-text {
            font-size: 1.25rem;
            font-weight: 700;
            color: white;
            transition: opacity 0.3s ease;
        }

        .sidebar.collapsed .brand-text {
            opacity: 0;
            display: none;
        }

        .sidebar-nav {
            padding: 1rem 0;
        }

        .nav-section {
            margin-bottom: 2rem;
        }

        .nav-section-title {
            font-size: 0.75rem;
            font-weight: 600;
            color: var(--text-muted);
            text-transform: uppercase;
            padding: 0 1.5rem;
            margin-bottom: 0.5rem;
            letter-spacing: 0.05em;
            transition: opacity 0.3s ease;
        }

        .sidebar.collapsed .nav-section-title {
            opacity: 0;
            display: none;
        }

        .nav-item {
            margin-bottom: 0.25rem;
        }

        .nav-link {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.75rem 1.5rem;
            color: var(--text-light);
            text-decoration: none;
            transition: all 0.3s ease;
            border-radius: 0;
            position: relative;
        }

        .nav-link:hover {
            background: rgba(99, 102, 241, 0.1);
            color: var(--primary-color);
        }

        .nav-link.active {
            background: linear-gradient(90deg, var(--primary-color), var(--primary-dark));
            color: white;
        }

        .nav-link.active::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            bottom: 0;
            width: 4px;
            background: var(--primary-color);
        }

        .nav-link i {
            font-size: 1.1rem;
            width: 20px;
            text-align: center;
        }

        .nav-link .nav-text {
            transition: opacity 0.3s ease;
        }

        .sidebar.collapsed .nav-text {
            opacity: 0;
            display: none;
        }

        .nav-link .badge {
            margin-left: auto;
            transition: opacity 0.3s ease;
        }

        .sidebar.collapsed .badge {
            opacity: 0;
            display: none;
        }

        /* Main Content */
        .main-content {
            margin-left: var(--sidebar-width);
            transition: margin-left 0.3s ease;
        }

        .main-content.expanded {
            margin-left: 70px;
        }

        /* Topbar */
        .topbar {
            height: var(--topbar-height);
            background: var(--card-bg);
            border-bottom: 1px solid var(--border-color);
            padding: 0 2rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 999;
        }

        .topbar-left {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .sidebar-toggle {
            background: none;
            border: none;
            color: var(--text-light);
            font-size: 1.25rem;
            cursor: pointer;
            padding: 0.5rem;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .sidebar-toggle:hover {
            background: rgba(99, 102, 241, 0.1);
            color: var(--primary-color);
        }

        .breadcrumb-nav {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            color: var(--text-muted);
            font-size: 0.875rem;
        }

        .topbar-right {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .topbar-actions {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .action-btn {
            background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
            border: none;
            border-radius: 8px;
            padding: 0.5rem 1rem;
            color: white;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.875rem;
        }

        .action-btn:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(99, 102, 241, 0.3);
        }

        .action-btn.secondary {
            background: var(--warning-color);
        }

        .action-btn.success {
            background: var(--success-color);
        }

        .action-btn.outline {
            background: transparent;
            border: 1px solid var(--border-color);
            color: var(--text-light);
        }

        .action-btn.outline:hover {
            background: rgba(99, 102, 241, 0.1);
            border-color: var(--primary-color);
            color: var(--primary-color);
        }

        /* Dashboard Content */
        .dashboard-content {
            padding: 2rem;
        }

        .page-header {
            margin-bottom: 2rem;
        }

        .page-title {
            font-size: 1.875rem;
            font-weight: 700;
            color: white;
            margin-bottom: 0.5rem;
        }

        .page-subtitle {
            color: var(--text-muted);
            margin-bottom: 0;
        }

        /* Stats Cards */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .stat-card {
            background: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 16px;
            padding: 1.5rem;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, var(--primary-color), var(--primary-dark));
        }

        .stat-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
        }

        .stat-card.success::before {
            background: linear-gradient(90deg, var(--success-color), #059669);
        }

        .stat-card.warning::before {
            background: linear-gradient(90deg, var(--warning-color), #d97706);
        }

        .stat-card.danger::before {
            background: linear-gradient(90deg, var(--danger-color), #dc2626);
        }

        .stat-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 1rem;
        }

        .stat-icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            color: white;
        }

        .stat-icon.primary { background: linear-gradient(135deg, var(--primary-color), var(--primary-dark)); }
        .stat-icon.success { background: linear-gradient(135deg, var(--success-color), #059669); }
        .stat-icon.warning { background: linear-gradient(135deg, var(--warning-color), #d97706); }
        .stat-icon.danger { background: linear-gradient(135deg, var(--danger-color), #dc2626); }

        .stat-number {
            font-size: 2rem;
            font-weight: 700;
            color: white;
            margin-bottom: 0.5rem;
        }

        .stat-label {
            color: var(--text-muted);
            font-size: 0.875rem;
        }

        /* Orders Section */
        .orders-section {
            background: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 16px;
            padding: 1.5rem;
            margin-bottom: 2rem;
        }

        .orders-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 1.5rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid var(--border-color);
        }

        .orders-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: white;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .orders-controls {
            display: flex;
            align-items: center;
            gap: 1rem;
            flex-wrap: wrap;
        }

        .view-toggle {
            display: flex;
            background: var(--dark-bg);
            border-radius: 8px;
            padding: 4px;
        }

        .view-toggle label {
            padding: 0.5rem 1rem;
            font-size: 0.875rem;
            font-weight: 500;
            cursor: pointer;
            border-radius: 6px;
            transition: all 0.3s ease;
            color: var(--text-muted);
        }

        .view-toggle input:checked + label {
            background: var(--primary-color);
            color: white;
        }

        .view-toggle input {
            display: none;
        }

        .form-select, .form-control {
            background: var(--dark-bg);
            border: 1px solid var(--border-color);
            color: var(--text-light);
            border-radius: 8px;
        }

        .form-select:focus, .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.2rem rgba(99, 102, 241, 0.25);
            background: var(--dark-bg);
            color: var(--text-light);
        }

        .form-select option {
            background: var(--card-bg);
            color: var(--text-light);
        }

        .form-check-input:checked {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }

        .form-check-label {
            color: var(--text-light);
            font-size: 0.875rem;
        }

        /* Order Cards */
        .order-card {
            background: var(--dark-bg);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            padding: 1.25rem;
            margin-bottom: 1rem;
            transition: all 0.3s ease;
            border-left: 4px solid var(--border-color);
        }

        .order-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
        }

        .order-card[data-status="pending"] {
            border-left-color: var(--warning-color);
        }

        .order-card[data-status="preparing"] {
            border-left-color: var(--info-color);
        }

        .order-card[data-status="completed"] {
            border-left-color: var(--success-color);
        }

        .order-card.selected {
            border-color: var(--primary-color);
            background: rgba(99, 102, 241, 0.1);
        }

        .order-card.new-order {
            animation: slideInFromRight 0.5s ease-out, pulse 1s ease-in-out 3;
            border-left-width: 6px;
            box-shadow: 0 4px 20px rgba(16, 185, 129, 0.3);
        }

        .order-card.completing {
            border: 2px solid var(--success-color);
            box-shadow: 0 0 20px rgba(16, 185, 129, 0.3);
            animation: completingPulse 1s infinite;
        }

        @keyframes completingPulse {
            0% { box-shadow: 0 0 20px rgba(16, 185, 129, 0.3); }
            50% { box-shadow: 0 0 30px rgba(16, 185, 129, 0.6); }
            100% { box-shadow: 0 0 20px rgba(16, 185, 129, 0.3); }
        }

        @keyframes slideInFromRight {
            0% { transform: translateX(100%); opacity: 0; }
            100% { transform: translateX(0); opacity: 1; }
        }

        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.02); }
            100% { transform: scale(1); }
        }

        .completion-countdown {
            margin-top: 1rem;
            animation: slideInDown 0.3s ease-out;
        }

        @keyframes slideInDown {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .completion-countdown .alert {
            background: linear-gradient(45deg, var(--success-color), #059669) !important;
            border: none;
            color: white;
            font-weight: 600;
            animation: countdownPulse 1s infinite;
        }

        @keyframes countdownPulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.02); }
            100% { transform: scale(1); }
        }

        /* Badges and Status */
        .badge {
            font-size: 0.75rem;
            padding: 0.35rem 0.65rem;
            border-radius: 20px;
            font-weight: 600;
        }

        .bg-warning { background-color: var(--warning-color) !important; }
        .bg-success { background-color: var(--success-color) !important; }
        .bg-info { background-color: var(--info-color) !important; }
        .bg-danger { background-color: var(--danger-color) !important; }

        /* Buttons */
        .btn {
            border-radius: 8px;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .btn-primary {
            background: var(--primary-color);
            border-color: var(--primary-color);
        }

        .btn-primary:hover {
            background: var(--primary-dark);
            border-color: var(--primary-dark);
            transform: translateY(-1px);
        }

        .btn-success {
            background: var(--success-color);
            border-color: var(--success-color);
        }

        .btn-warning {
            background: var(--warning-color);
            border-color: var(--warning-color);
        }

        .btn-outline-primary {
            color: var(--primary-color);
            border-color: var(--primary-color);
        }

        .btn-outline-primary:hover {
            background: var(--primary-color);
            border-color: var(--primary-color);
        }

        .btn-sm {
            padding: 0.375rem 0.75rem;
            font-size: 0.875rem;
        }

        /* Modals */
        .modal-content {
            background: var(--card-bg);
            border: 1px solid var(--border-color);
        }

        .modal-header {
            border-bottom: 1px solid var(--border-color);
        }

        .modal-title {
            color: white;
        }

        .modal-body {
            color: var(--text-light);
        }

        .table {
            color: var(--text-light);
        }

        .table th {
            background-color: var(--dark-bg);
            border-color: var(--border-color);
            color: var(--text-light);
        }

        .table td {
            border-color: var(--border-color);
        }

        /* Notifications */
        .notification-badge {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 10000;
            padding: 15px 20px;
            border-radius: 10px;
            color: white;
            font-weight: 600;
            box-shadow: 0 4px 15px rgba(0,0,0,0.3);
            animation: slideInFromRight 0.3s ease-out;
        }

        .notification-badge.success {
            background: linear-gradient(45deg, var(--success-color), #059669);
        }

        .notification-badge.info {
            background: linear-gradient(45deg, var(--info-color), var(--primary-color));
        }

        .notification-badge.error {
            background: linear-gradient(45deg, var(--danger-color), #dc2626);
        }

        /* Auto-refresh indicator */
        .auto-refresh-indicator {
            position: fixed;
            bottom: 2rem;
            right: 2rem;
            background: rgba(99, 102, 241, 0.9);
            color: white;
            padding: 0.75rem 1rem;
            border-radius: 25px;
            font-size: 0.875rem;
            font-weight: 600;
            display: none;
            align-items: center;
            gap: 0.5rem;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.3);
            z-index: 1000;
        }

        .auto-refresh-indicator.active .refresh-icon {
            animation: spin 2s linear infinite;
        }

        @keyframes spin {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }

        /* Responsive */
        @media (max-width: 1024px) {
            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.show {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0;
            }

            .topbar {
                padding: 0 1rem;
            }

            .dashboard-content {
                padding: 1rem;
            }

            .stats-grid {
                grid-template-columns: 1fr;
            }

            .orders-controls {
                flex-direction: column;
                align-items: stretch;
                gap: 0.75rem;
            }

            .view-toggle {
                align-self: flex-start;
            }
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 6px;
        }

        ::-webkit-scrollbar-track {
            background: var(--dark-bg);
        }

        ::-webkit-scrollbar-thumb {
            background: var(--border-color);
            border-radius: 3px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: var(--text-muted);
        }

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 3rem 1rem;
            color: var(--text-muted);
        }

        .empty-state i {
            font-size: 3rem;
            margin-bottom: 1rem;
            opacity: 0.6;
        }

        /* Sound Button Effects */
        .sound-button {
            position: relative;
            transition: all 0.3s ease;
        }

        .sound-button:hover {
            transform: scale(1.05);
        }

        .sound-button.muted {
            opacity: 0.6;
        }

        .sound-wave {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 30px;
            height: 30px;
            border: 2px solid rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            animation: soundWave 1s infinite;
            pointer-events: none;
        }

        @keyframes soundWave {
            0% {
                transform: translate(-50%, -50%) scale(0.5);
                opacity: 1;
            }
            100% {
                transform: translate(-50%, -50%) scale(1.5);
                opacity: 0;
            }
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <div class="logo">🍜</div>
            <div class="brand-text">Kimura Dashboard</div>
        </div>
        
        <nav class="sidebar-nav">
            <div class="nav-section">
                <div class="nav-section-title">Main</div>
                <div class="nav-item">
                    <a href="index.php?controller=order&action=dashboard" class="nav-link active">
                        <i class="bi bi-grid-1x2"></i>
                        <span class="nav-text">Dashboard</span>
                    </a>
                </div>
                <div class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="bi bi-receipt"></i>
                        <span class="nav-text">Orders</span>
                        <span class="badge bg-warning" id="pendingOrdersBadge">0</span>
                    </a>
                </div>
                <div class="nav-item">
                    <a href="index.php?controller=admin&action=menu" class="nav-link">
                        <i class="bi bi-list-ul"></i>
                        <span class="nav-text">Menu Management</span>
                    </a>
                </div>
            </div>
            
            <div class="nav-section">
                <div class="nav-section-title">Restaurant</div>
                <div class="nav-item">
                    <a href="index.php?controller=restaurant&action=menu&table=1" class="nav-link">
                        <i class="bi bi-shop"></i>
                        <span class="nav-text">Customer View</span>
                    </a>
                </div>
                <div class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="bi bi-bar-chart"></i>
                        <span class="nav-text">Analytics</span>
                    </a>
                </div>
            </div>
            
            <div class="nav-section">
                <div class="nav-section-title">Settings</div>
                <div class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="bi bi-gear"></i>
                        <span class="nav-text">Settings</span>
                    </a>
                </div>
            </div>
        </nav>
    </div>

    <!-- Main Content -->
    <div class="main-content" id="mainContent">
        <!-- Topbar -->
        <div class="topbar">
            <div class="topbar-left">
                <button class="sidebar-toggle" id="sidebarToggle">
                    <i class="bi bi-list"></i>
                </button>
                <div class="breadcrumb-nav">
                    <span>Dashboard</span>
                    <i class="bi bi-chevron-right"></i>
                    <span class="text-light">Order Management</span>
                </div>
            </div>
            
            <div class="topbar-right">
                <div class="topbar-actions">
                    <button class="action-btn secondary" onclick="window.location.href='index.php?controller=admin&action=menu'">
                        <i class="bi bi-list me-1"></i>
                        Quản lý Menu
                    </button>
                    <button class="action-btn" onclick="refreshOrders()">
                        <i class="bi bi-arrow-clockwise me-1"></i>
                        Làm mới
                    </button>
                    <button class="action-btn success" onclick="toggleAutoRefresh()">
                        <i class="bi bi-wifi me-1"></i>
                        <span id="autoRefreshText">Bật tự động</span>
                    </button>
                    <button class="action-btn outline sound-button" onclick="toggleSound()" id="soundButton">
                        <i class="bi bi-volume-up me-1" id="soundIcon"></i>
                        <span id="soundText">Âm thanh</span>
                    </button>
                </div>
            </div>
        </div>

        <!-- Dashboard Content -->
        <div class="dashboard-content">
            <!-- Page Header -->
            <div class="page-header">
                <h1 class="page-title">Dashboard Nhân viên</h1>
                <p class="page-subtitle">Quản lý đơn hàng Kimura Restaurant</p>
            </div>

            <!-- Stats Grid -->
            <div class="stats-grid">
                <div class="stat-card warning">
                    <div class="stat-header">
                        <div class="stat-icon warning">
                            <i class="bi bi-clock-history"></i>
                        </div>
                    </div>
                    <div class="stat-number" id="pendingCount">0</div>
                    <div class="stat-label">Đang chờ</div>
                </div>

                <div class="stat-card primary">
                    <div class="stat-header">
                        <div class="stat-icon primary">
                            <i class="bi bi-gear"></i>
                        </div>
                    </div>
                    <div class="stat-number" id="preparingCount">0</div>
                    <div class="stat-label">Đang làm</div>
                </div>

                <div class="stat-card success">
                    <div class="stat-header">
                        <div class="stat-icon success">
                            <i class="bi bi-check-circle"></i>
                        </div>
                    </div>
                    <div class="stat-number" id="completedCount">0</div>
                    <div class="stat-label">Hoàn thành</div>
                </div>

                <div class="stat-card danger">
                    <div class="stat-header">
                        <div class="stat-icon danger">
                            <i class="bi bi-currency-dollar"></i>
                        </div>
                    </div>
                    <div class="stat-number" id="revenueToday">0đ</div>
                    <div class="stat-label">Doanh thu hôm nay</div>
                </div>
            </div>

            <!-- Orders Section -->
            <div class="orders-section">
                <div class="orders-header">
                    <h3 class="orders-title">
                        <i class="bi bi-list-check me-2"></i>
                        <span id="currentViewTitle">Đơn hàng hiện tại</span>
                    </h3>
                    <div class="orders-controls">
                        <!-- View Toggle Tabs -->
                        <div class="view-toggle">
                            <input type="radio" name="viewMode" id="currentView" checked>
                            <label for="currentView" onclick="switchView('current')">
                                <i class="bi bi-clock me-1"></i>Hiện tại
                            </label>
                            
                            <input type="radio" name="viewMode" id="completedView">
                            <label for="completedView" onclick="switchView('completed')">
                                <i class="bi bi-check-circle me-1"></i>Đã hoàn thành
                            </label>
                        </div>
                        
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="bulkSelectMode">
                            <label class="form-check-label" for="bulkSelectMode">
                                Chọn nhiều
                            </label>
                        </div>
                        
                        <select class="form-select" id="statusFilter" onchange="filterOrders()">
                            <option value="all">Tất cả trạng thái</option>
                            <option value="pending">Đang chờ</option>
                            <option value="preparing">Đang làm</option>
                            <option value="completed">Hoàn thành</option>
                        </select>
                        
                        <button class="btn btn-primary" id="bulkActionBtn" style="display: none;" onclick="showBulkActionModal()">
                            <i class="bi bi-gear me-2"></i>Hành động
                        </button>
                    </div>
                </div>

                <div id="ordersContainer">
                    <!-- Orders will be loaded here -->
                </div>
            </div>
        </div>
    </div>

    <!-- Auto Refresh Indicator -->
    <div id="autoRefreshIndicator" class="auto-refresh-indicator">
        <i class="bi bi-arrow-clockwise refresh-icon"></i>
        <span>Tự động làm mới</span>
    </div>
                <button class="btn btn-primary" id="bulkActionBtn" style="display: none;" onclick="showBulkActionModal()">
                    <i class="bi bi-gear me-2"></i>Hành động
                </button>
            </div>
        </div>

        <div id="ordersContainer">
            <!-- Orders will be loaded here -->
        </div>
    </div>
</div>

<!-- Auto Refresh Indicator -->
<div id="autoRefreshIndicator" class="auto-refresh-indicator" style="display: none;">
    <i class="bi bi-arrow-clockwise me-2"></i>
    <span>Tự động làm mới</span>
</div>

<!-- Order Detail Modal -->
<div class="modal fade" id="orderModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">
                    <i class="bi bi-receipt me-2"></i>
                    Chi tiết đơn hàng
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="orderModalBody">
                <!-- Order details will be loaded here -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                <div id="orderActionButtons">
                    <!-- Action buttons will be added here -->
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Bulk Action Modal -->
<div class="modal fade" id="bulkActionModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="bi bi-gear me-2"></i>
                    Hành động cho nhiều đơn hàng
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Đã chọn <span id="selectedCount">0</span> đơn hàng</p>
                <div class="mb-3">
                    <label class="form-label">Chọn hành động:</label>
                    <select class="form-select" id="bulkAction">
                        <option value="">-- Chọn hành động --</option>
                        <option value="preparing">Chuyển sang "Đang làm"</option>
                        <option value="completed">Chuyển sang "Hoàn thành"</option>
                        <option value="pending">Chuyển về "Đang chờ"</option>
                        <option value="delete" class="text-danger">Xóa đơn hàng</option>
                    </select>
                </div>
                <div class="alert alert-warning">
                    <i class="bi bi-exclamation-triangle me-2"></i>
                    Hành động này sẽ áp dụng cho tất cả đơn hàng đã chọn!
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                <button type="button" class="btn btn-primary" onclick="executeBulkAction()">Thực hiện</button>
            </div>
        </div>
    </div>
</div>

<!-- Confirm Delete Modal -->
<div class="modal fade" id="confirmDeleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title">
                    <i class="bi bi-exclamation-triangle me-2"></i>
                    Xác nhận xóa
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Bạn có chắc chắn muốn xóa đơn hàng này không?</p>
                <p class="text-danger">
                    <strong>Lưu ý:</strong> Hành động này không thể hoàn tác!
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                <button type="button" class="btn btn-danger" id="confirmDeleteBtn">Xóa</button>
            </div>
        </div>
    </div>
</div>

<script>
let autoRefreshInterval = null;
let lastUpdateTime = 0;
let selectedOrders = new Set();
let isBulkSelectMode = false;
let isSoundEnabled = true;
let currentViewMode = 'current'; // 'current' or 'completed'
let completedOrderHideTimeouts = new Map(); // Track hide timeouts for completed orders

// Load orders khi trang load
document.addEventListener('DOMContentLoaded', function() {
    // Load sound preference
    const savedSoundPref = localStorage.getItem('soundEnabled');
    if (savedSoundPref !== null) {
        isSoundEnabled = savedSoundPref === 'true';
        if (!isSoundEnabled) {
            document.getElementById('soundIcon').className = 'bi bi-volume-mute me-2';
            document.getElementById('soundText').textContent = 'Tắt tiếng';
            document.getElementById('soundButton').classList.add('muted');
        }
    }
    
    loadOrdersFromAPI(); // Load từ API thay vì PHP data
    loadStatsFromAPI();
    
    // Tự động bật auto-refresh
    startAutoRefresh();
    
    // Setup bulk select mode toggle
    document.getElementById('bulkSelectMode').addEventListener('change', function() {
        isBulkSelectMode = this.checked;
        selectedOrders.clear();
        updateBulkActionButton();
        loadOrdersFromAPI(); // Reload to show/hide checkboxes
    });
});

function switchView(viewMode) {
    currentViewMode = viewMode;
    const titleElement = document.getElementById('currentViewTitle');
    const statusFilter = document.getElementById('statusFilter');
    
    if (viewMode === 'current') {
        titleElement.textContent = 'Đơn hàng hiện tại';
        statusFilter.style.display = 'block';
        // Load current orders (pending, preparing)
        loadOrdersFromAPI();
    } else if (viewMode === 'completed') {
        titleElement.textContent = 'Đơn hàng đã hoàn thành';
        statusFilter.style.display = 'none'; // Hide filter for completed view
        // Load completed orders
        loadCompletedOrders();
    }
    
    // Clear selections when switching views
    selectedOrders.clear();
    updateBulkActionButton();
}

function loadCompletedOrders() {
    fetch('./index.php?controller=order&action=getCompletedOrders')
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                displayCompletedOrders(data.orders);
            } else {
                console.error('Failed to load completed orders:', data.message);
                showNotification('Lỗi tải đơn hàng đã hoàn thành!', 'error');
            }
        })
        .catch(error => {
            console.error('Error loading completed orders:', error);
            showNotification('Lỗi tải đơn hàng đã hoàn thành!', 'error');
        });
}

function displayCompletedOrders(orders) {
    const container = document.getElementById('ordersContainer');
    
    if (orders.length === 0) {
        container.innerHTML = `
            <div class="text-center py-5 text-secondary">
                <i class="bi bi-check-circle fs-1 mb-3"></i>
                <p>Chưa có đơn hàng nào hoàn thành hôm nay</p>
            </div>
        `;
        return;
    }
    
    let html = '';
    orders.forEach(order => {
        const orderTime = new Date(order.created_at).toLocaleString('vi-VN');
        const completedTime = order.updated_at ? new Date(order.updated_at).toLocaleString('vi-VN') : orderTime;
        const isSelected = selectedOrders.has(order.id);
        
        html += `
            <div class="order-card mb-3 p-4 border rounded completed-order ${isSelected ? 'selected' : ''}" 
                 data-status="${order.status}" data-order-id="${order.id}">
                <div class="row align-items-center">
                    ${isBulkSelectMode ? `
                        <div class="col-md-1">
                            <div class="form-check">
                                <input class="form-check-input order-checkbox" type="checkbox" 
                                       value="${order.id}" ${isSelected ? 'checked' : ''}
                                       onchange="toggleOrderSelection(${order.id})">
                            </div>
                        </div>
                    ` : ''}
                    <div class="col-md-2">
                        <div class="fw-bold text-success">${order.order_code}</div>
                        <small class="text-muted">Bàn ${order.table_number}</small>
                    </div>
                    <div class="col-md-3">
                        <div class="fw-semibold">${order.items.length} món</div>
                        <small class="text-muted">Đặt: ${orderTime}</small>
                        <small class="text-success d-block">Hoàn thành: ${completedTime}</small>
                    </div>
                    <div class="col-md-2">
                        <div class="fw-bold text-danger">${parseInt(order.final_total).toLocaleString()}đ</div>
                    </div>
                    <div class="col-md-2">
                        <span class="badge bg-success px-3 py-2">
                            <i class="bi bi-check-circle me-1"></i>Hoàn thành
                        </span>
                    </div>
                    <div class="col-md-2">
                        <div class="d-flex gap-1">
                            <button class="btn btn-sm btn-outline-primary" onclick="viewOrderDetail(${order.id})" 
                                    title="Xem chi tiết">
                                <i class="bi bi-eye"></i>
                            </button>
                            <button class="btn btn-sm btn-outline-secondary" onclick="updateOrderStatus(${order.id}, 'preparing')"
                                    title="Làm lại">
                                <i class="bi bi-arrow-counterclockwise"></i>
                            </button>
                            <button class="btn btn-sm btn-outline-danger" onclick="confirmDeleteOrder(${order.id})"
                                    title="Xóa đơn hàng">
                                <i class="bi bi-trash"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        `;
    });
    
    container.innerHTML = html;
}

function loadOrdersFromAPI() {
    const endpoint = currentViewMode === 'completed' 
        ? './index.php?controller=order&action=getCompletedOrders'
        : './index.php?controller=order&action=getCurrentOrders';
        
    fetch(endpoint)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                if (currentViewMode === 'completed') {
                    displayCompletedOrders(data.orders);
                } else {
                    displayOrders(data.orders);
                }
            } else {
                console.error('Failed to load orders:', data.message);
                showNotification('Lỗi tải đơn hàng!', 'error');
            }
        })
        .catch(error => {
            console.error('Error loading orders:', error);
            showNotification('Lỗi tải đơn hàng!', 'error');
        });
}

function startAutoRefresh() {
    const button = document.getElementById('autoRefreshText');
    const indicator = document.getElementById('autoRefreshIndicator');
    
    if (!autoRefreshInterval) {
        autoRefreshInterval = setInterval(() => {
            checkForUpdates();
        }, 3000); // Check every 3 seconds for faster updates
        button.textContent = 'Tắt tự động';
        
        // Show indicator
        if (indicator) {
            indicator.style.display = 'block';
            indicator.classList.add('active');
        }
        
        showNotification('🔄 Tự động làm mới đã được bật!', 'info');
    }
}

function checkForUpdates() {
    // Kiểm tra đơn hàng mới và cập nhật
    fetch(`./index.php?controller=order&action=getNewOrders&since=${lastUpdateTime}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                if (data.orders.length > 0) {
                    // Có đơn hàng mới - load lại toàn bộ
                    loadOrdersFromAPI();
                    loadStatsFromAPI();
                    showNotification(`🎉 ${data.orders.length} đơn hàng mới!`, 'success');
                    
                    // Play notification sound based on order count
                    if (data.orders.length === 1) {
                        playNotificationSound(); // Single ding-dong-ding
                    } else {
                        playMultipleOrdersSound(data.orders.length); // Multiple rapid dings
                    }
                    
                    // Highlight new orders
                    highlightNewOrders(data.orders);
                }
                lastUpdateTime = data.timestamp;
            }
        })
        .catch(error => {
            console.error('Error checking for updates:', error);
        });
}

function highlightNewOrders(newOrders) {
    // Thêm hiệu ứng highlight cho đơn hàng mới
    setTimeout(() => {
        newOrders.forEach(order => {
            const orderCard = document.querySelector(`[data-order-id="${order.id}"]`);
            if (orderCard) {
                orderCard.classList.add('new-order', 'border-success');
                orderCard.style.animation = 'pulse 2s ease-in-out 3';
                
                // Remove highlight after 10 seconds
                setTimeout(() => {
                    orderCard.classList.remove('new-order', 'border-success');
                    orderCard.style.animation = '';
                }, 10000);
            }
        });
    }, 500);
}

function loadStatsFromAPI() {
    fetch('./index.php?controller=order&action=getStats')
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                updateStatsDisplay(data.stats);
            }
        })
        .catch(error => {
            console.error('Error loading stats:', error);
        });
}

function updateStatsDisplay(stats) {
    document.getElementById('pendingCount').textContent = stats.pending_orders || 0;
    document.getElementById('preparingCount').textContent = stats.preparing_orders || 0;
    document.getElementById('completedCount').textContent = stats.completed_orders || 0;
    document.getElementById('revenueToday').textContent = 
        (parseInt(stats.total_revenue) || 0).toLocaleString() + 'đ';
}

function displayOrders(orders) {
    const container = document.getElementById('ordersContainer');
    
    if (orders.length === 0) {
        container.innerHTML = `
            <div class="text-center py-5 text-secondary">
                <i class="bi bi-inbox fs-1 mb-3"></i>
                <p>Chưa có đơn hàng nào</p>
            </div>
        `;
        return;
    }
    
    let html = '';
    orders.forEach(order => {
        const statusClass = getStatusClass(order.status);
        const statusText = getStatusText(order.status);
        const orderTime = new Date(order.created_at).toLocaleString('vi-VN');
        const isSelected = selectedOrders.has(order.id);
        
        html += `
            <div class="order-card mb-3 p-4 border rounded ${isSelected ? 'selected' : ''}" 
                 data-status="${order.status}" data-order-id="${order.id}">
                <div class="row align-items-center">
                    ${isBulkSelectMode ? `
                        <div class="col-md-1">
                            <div class="form-check">
                                <input class="form-check-input order-checkbox" type="checkbox" 
                                       value="${order.id}" ${isSelected ? 'checked' : ''}
                                       onchange="toggleOrderSelection(${order.id})">
                            </div>
                        </div>
                    ` : ''}
                    <div class="col-md-2">
                        <div class="fw-bold text-primary">${order.order_code}</div>
                        <small class="text-muted">Bàn ${order.table_number}</small>
                    </div>
                    <div class="col-md-3">
                        <div class="fw-semibold">${order.items.length} món</div>
                        <small class="text-muted">${orderTime}</small>
                    </div>
                    <div class="col-md-2">
                        <div class="fw-bold text-danger">${parseInt(order.final_total).toLocaleString()}đ</div>
                    </div>
                    <div class="col-md-2">
                        <span class="badge ${statusClass} px-3 py-2">${statusText}</span>
                    </div>
                    <div class="col-md-2">
                        <div class="d-flex gap-1">
                            <button class="btn btn-sm btn-outline-primary" onclick="viewOrderDetail(${order.id})" 
                                    title="Xem chi tiết">
                                <i class="bi bi-eye"></i>
                            </button>
                            ${order.status === 'pending' ? `
                                <button class="btn btn-sm btn-warning" onclick="updateOrderStatus(${order.id}, 'preparing')"
                                        title="Bắt đầu làm">
                                    <i class="bi bi-gear"></i>
                                </button>
                            ` : ''}
                            ${order.status === 'preparing' ? `
                                <button class="btn btn-sm btn-success" onclick="updateOrderStatus(${order.id}, 'completed')"
                                        title="Hoàn thành">
                                    <i class="bi bi-check"></i>
                                </button>
                            ` : ''}
                            ${order.status === 'completed' ? `
                                <button class="btn btn-sm btn-secondary" onclick="updateOrderStatus(${order.id}, 'preparing')"
                                        title="Trở về đang làm">
                                    <i class="bi bi-arrow-counterclockwise"></i>
                                </button>
                            ` : ''}
                            <button class="btn btn-sm btn-outline-danger" onclick="confirmDeleteOrder(${order.id})"
                                    title="Xóa đơn hàng">
                                <i class="bi bi-trash"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        `;
    });
    
    container.innerHTML = html;
}

function toggleOrderSelection(orderId) {
    if (selectedOrders.has(orderId)) {
        selectedOrders.delete(orderId);
    } else {
        selectedOrders.add(orderId);
    }
    
    updateBulkActionButton();
    updateOrderCardSelection(orderId);
}

function updateOrderCardSelection(orderId) {
    const card = document.querySelector(`[data-order-id="${orderId}"]`);
    if (card) {
        if (selectedOrders.has(orderId)) {
            card.classList.add('selected');
        } else {
            card.classList.remove('selected');
        }
    }
}

function updateBulkActionButton() {
    const bulkActionBtn = document.getElementById('bulkActionBtn');
    const selectedCount = selectedOrders.size;
    
    if (isBulkSelectMode && selectedCount > 0) {
        bulkActionBtn.style.display = 'block';
        bulkActionBtn.innerHTML = `<i class="bi bi-gear me-2"></i>Hành động (${selectedCount})`;
    } else {
        bulkActionBtn.style.display = 'none';
    }
}

function showBulkActionModal() {
    document.getElementById('selectedCount').textContent = selectedOrders.size;
    const modal = new bootstrap.Modal(document.getElementById('bulkActionModal'));
    modal.show();
}

function executeBulkAction() {
    const action = document.getElementById('bulkAction').value;
    if (!action) {
        showNotification('Vui lòng chọn hành động!', 'error');
        return;
    }
    
    const orderIds = Array.from(selectedOrders);
    
    if (action === 'delete') {
        if (!confirm('Bạn có chắc chắn muốn xóa tất cả đơn hàng đã chọn?')) {
            return;
        }
        
        // Delete orders one by one
        let deletePromises = orderIds.map(orderId => 
            fetch('./index.php?controller=order&action=deleteOrder', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ orderId: orderId })
            })
        );
        
        Promise.all(deletePromises)
            .then(() => {
                showNotification('Xóa đơn hàng thành công!', 'success');
                playSuccessSound();
                selectedOrders.clear();
                loadOrders();
                loadStatsFromAPI();
                bootstrap.Modal.getInstance(document.getElementById('bulkActionModal')).hide();
            })
            .catch(error => {
                showNotification('Có lỗi xảy ra khi xóa!', 'error');
                playErrorSound();
            });
    } else {
        // Update status
        fetch('./index.php?controller=order&action=bulkUpdateStatus', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({
                orderIds: orderIds,
                status: action
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showNotification(data.message, 'success');
                playSuccessSound();
                selectedOrders.clear();
                loadOrders();
                loadStatsFromAPI();
                bootstrap.Modal.getInstance(document.getElementById('bulkActionModal')).hide();
            } else {
                showNotification('Lỗi: ' + data.message, 'error');
                playErrorSound();
            }
        })
        .catch(error => {
            showNotification('Có lỗi xảy ra!', 'error');
        });
    }
}

function getStatusClass(status) {
    switch(status) {
        case 'pending': return 'bg-warning';
        case 'preparing': return 'bg-info';
        case 'completed': return 'bg-success';
        default: return 'bg-secondary';
    }
}

function getStatusText(status) {
    switch(status) {
        case 'pending': return 'Đang chờ';
        case 'preparing': return 'Đang làm';
        case 'completed': return 'Hoàn thành';
        default: return 'Không xác định';
    }
}

function updateOrderStatus(orderId, newStatus) {
    console.log('updateOrderStatus called with:', orderId, newStatus);
    
    // Add visual feedback immediately
    const orderCard = document.querySelector(`[data-order-id="${orderId}"]`);
    if (orderCard) {
        orderCard.style.opacity = '0.6';
        orderCard.style.pointerEvents = 'none';
    }
    
    fetch('./index.php?controller=order&action=updateStatus', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            orderId: parseInt(orderId),
            status: newStatus
        })
    })
    .then(response => {
        console.log('Response status:', response.status);
        return response.text();
    })
    .then(text => {
        console.log('Response text:', text);
        let data;
        try {
            data = JSON.parse(text);
        } catch (e) {
            console.error('JSON parse error:', e);
            console.error('Raw response:', text);
            throw new Error('Server returned invalid JSON: ' + text);
        }
        
        // Restore visual state
        if (orderCard) {
            orderCard.style.opacity = '1';
            orderCard.style.pointerEvents = 'auto';
        }
        
        if (data.success) {
            // Handle completed status with auto-hide
            if (newStatus === 'completed' && currentViewMode === 'current') {
                handleOrderCompletion(orderId);
            } else {
                loadOrdersFromAPI();
            }
            
            loadStatsFromAPI();
            showNotification('Cập nhật trạng thái thành công!', 'success');
            playSuccessSound();
        } else {
            showNotification('Lỗi: ' + (data.message || 'Unknown error'), 'error');
            playErrorSound();
        }
    })
    .catch(error => {
        console.error('Error:', error);
        
        // Restore visual state on error
        if (orderCard) {
            orderCard.style.opacity = '1';
            orderCard.style.pointerEvents = 'auto';
        }
        
        showNotification('Có lỗi xảy ra: ' + error.message, 'error');
    });
}

function handleOrderCompletion(orderId) {
    const orderCard = document.querySelector(`[data-order-id="${orderId}"]`);
    if (!orderCard) return;
    
    // Add completed styling
    orderCard.classList.add('completing');
    
    // Show countdown
    const countdownEl = document.createElement('div');
    countdownEl.className = 'completion-countdown';
    countdownEl.innerHTML = `
        <div class="alert alert-success d-flex align-items-center">
            <i class="bi bi-check-circle-fill me-2"></i>
            <span>Đơn hàng hoàn thành! Tự động ẩn sau <span id="countdown-${orderId}">3</span>s</span>
            <button class="btn btn-sm btn-outline-success ms-auto" onclick="cancelAutoHide(${orderId})">
                <i class="bi bi-x"></i> Hủy
            </button>
        </div>
    `;
    
    orderCard.appendChild(countdownEl);
    
    // Start countdown
    let seconds = 3;
    const countdownSpan = document.getElementById(`countdown-${orderId}`);
    
    const countdownInterval = setInterval(() => {
        seconds--;
        if (countdownSpan) {
            countdownSpan.textContent = seconds;
        }
        
        if (seconds <= 0) {
            clearInterval(countdownInterval);
            hideCompletedOrder(orderId);
        }
    }, 1000);
    
    // Store timeout reference
    completedOrderHideTimeouts.set(orderId, countdownInterval);
}

function cancelAutoHide(orderId) {
    const interval = completedOrderHideTimeouts.get(orderId);
    if (interval) {
        clearInterval(interval);
        completedOrderHideTimeouts.delete(orderId);
    }
    
    const orderCard = document.querySelector(`[data-order-id="${orderId}"]`);
    if (orderCard) {
        const countdownEl = orderCard.querySelector('.completion-countdown');
        if (countdownEl) {
            countdownEl.remove();
        }
        orderCard.classList.remove('completing');
    }
    
    showNotification('Đã hủy tự động ẩn đơn hàng', 'info');
}

function hideCompletedOrder(orderId) {
    const orderCard = document.querySelector(`[data-order-id="${orderId}"]`);
    if (!orderCard) return;
    
    // Add hide animation
    orderCard.style.transition = 'all 0.5s ease-out';
    orderCard.style.transform = 'translateX(100%)';
    orderCard.style.opacity = '0';
    
    setTimeout(() => {
        orderCard.remove();
        completedOrderHideTimeouts.delete(orderId);
        
        // Check if no orders left
        const remainingOrders = document.querySelectorAll('.order-card').length;
        if (remainingOrders === 0) {
            document.getElementById('ordersContainer').innerHTML = `
                <div class="text-center py-5 text-secondary">
                    <i class="bi bi-inbox fs-1 mb-3"></i>
                    <p>Tất cả đơn hàng đã được xử lý!</p>
                    <button class="btn btn-primary" onclick="loadOrdersFromAPI()">
                        <i class="bi bi-arrow-clockwise me-2"></i>Làm mới
                    </button>
                </div>
            `;
        }
    }, 500);
    
    showNotification('Đơn hàng đã được chuyển vào mục "Đã hoàn thành"', 'info');
}

function confirmDeleteOrder(orderId) {
    const modal = new bootstrap.Modal(document.getElementById('confirmDeleteModal'));
    
    document.getElementById('confirmDeleteBtn').onclick = function() {
        deleteOrder(orderId);
        modal.hide();
    };
    
    modal.show();
}

function deleteOrder(orderId) {
    fetch('./index.php?controller=order&action=deleteOrder', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            orderId: orderId
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            loadOrders();
            loadStatsFromAPI();
            showNotification('Xóa đơn hàng thành công!', 'success');
            playSuccessSound();
        } else {
            showNotification('Lỗi: ' + data.message, 'error');
            playErrorSound();
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification('Có lỗi xảy ra!', 'error');
    });
}

function viewOrderDetail(orderId) {
    fetch(`./index.php?controller=order&action=getOrderDetail&id=${orderId}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                displayOrderDetail(data.order);
            } else {
                showNotification('Không thể tải chi tiết đơn hàng!', 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('Có lỗi xảy ra!', 'error');
        });
}

function displayOrderDetail(order) {
    const orderTime = new Date(order.created_at).toLocaleString('vi-VN');
    const statusText = getStatusText(order.status);
    const statusClass = getStatusClass(order.status);
    
    let itemsHtml = '';
    order.items.forEach(item => {
        itemsHtml += `
            <tr>
                <td>${item.item_name}</td>
                <td class="text-center">${item.quantity}</td>
                <td class="text-end">${parseInt(item.unit_price).toLocaleString()}đ</td>
                <td class="text-end fw-bold">${parseInt(item.total_price).toLocaleString()}đ</td>
            </tr>
        `;
    });
    
    const modalBody = document.getElementById('orderModalBody');
    modalBody.innerHTML = `
        <div class="row mb-4">
            <div class="col-md-6">
                <h6 class="text-muted mb-2">Thông tin đơn hàng</h6>
                <p><strong>Mã đơn:</strong> ${order.order_code}</p>
                <p><strong>Bàn số:</strong> ${order.table_number}</p>
                <p><strong>Thời gian:</strong> ${orderTime}</p>
                <p><strong>Trạng thái:</strong> <span class="badge ${statusClass}">${statusText}</span></p>
            </div>
            <div class="col-md-6">
                <h6 class="text-muted mb-2">Tổng thanh toán</h6>
                <p><strong>Tổng tiền món:</strong> ${parseInt(order.total_amount).toLocaleString()}đ</p>
                <p><strong>Phí dịch vụ:</strong> ${parseInt(order.service_fee).toLocaleString()}đ</p>
                <p class="fs-5"><strong>Tổng cộng:</strong> <span class="text-danger">${parseInt(order.final_total).toLocaleString()}đ</span></p>
            </div>
        </div>
        
        ${order.customer_note ? `
            <div class="mb-4">
                <h6 class="text-muted mb-2">Ghi chú khách hàng</h6>
                <div class="alert alert-info">${order.customer_note}</div>
            </div>
        ` : ''}
        
        <h6 class="text-muted mb-3">Chi tiết món ăn</h6>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Tên món</th>
                    <th class="text-center">Số lượng</th>
                    <th class="text-end">Đơn giá</th>
                    <th class="text-end">Thành tiền</th>
                </tr>
            </thead>
            <tbody>
                ${itemsHtml}
            </tbody>
        </table>
    `;
    
    // Update action buttons
    const actionButtons = document.getElementById('orderActionButtons');
    let buttonsHtml = '';
    
    if (order.status === 'pending') {
        buttonsHtml += `<button class="btn btn-warning me-2" onclick="updateOrderStatus(${order.id}, 'preparing'); bootstrap.Modal.getInstance(document.getElementById('orderModal')).hide();">
            <i class="bi bi-gear me-2"></i>Bắt đầu làm
        </button>`;
    }
    
    if (order.status === 'preparing') {
        buttonsHtml += `<button class="btn btn-success me-2" onclick="updateOrderStatus(${order.id}, 'completed'); bootstrap.Modal.getInstance(document.getElementById('orderModal')).hide();">
            <i class="bi bi-check me-2"></i>Hoàn thành
        </button>`;
    }
    
    if (order.status === 'completed') {
        buttonsHtml += `<button class="btn btn-secondary me-2" onclick="updateOrderStatus(${order.id}, 'preparing'); bootstrap.Modal.getInstance(document.getElementById('orderModal')).hide();">
            <i class="bi bi-arrow-counterclockwise me-2"></i>Trở về đang làm
        </button>`;
    }
    
    buttonsHtml += `<button class="btn btn-outline-danger" onclick="confirmDeleteOrder(${order.id}); bootstrap.Modal.getInstance(document.getElementById('orderModal')).hide();">
        <i class="bi bi-trash me-2"></i>Xóa đơn hàng
    </button>`;
    
    actionButtons.innerHTML = buttonsHtml;
    
    const modal = new bootstrap.Modal(document.getElementById('orderModal'));
    modal.show();
}

function refreshOrders() {
    loadOrders();
    loadStatsFromAPI();
    showNotification('Đã làm mới!', 'success');
}

function toggleAutoRefresh() {
    const button = document.getElementById('autoRefreshText');
    const indicator = document.getElementById('autoRefreshIndicator');
    
    if (autoRefreshInterval) {
        clearInterval(autoRefreshInterval);
        autoRefreshInterval = null;
        button.textContent = 'Bật tự động';
        
        // Hide indicator
        if (indicator) {
            indicator.style.display = 'none';
            indicator.classList.remove('active');
        }
        
        showNotification('⏸️ Đã tắt tự động làm mới', 'info');
    } else {
        startAutoRefresh();
    }
}

function checkNewOrders() {
    // This function is now replaced by checkForUpdates()
    checkForUpdates();
}

function refreshOrders() {
    loadOrdersFromAPI();
    loadStatsFromAPI();
    showNotification('Đã làm mới!', 'success');
}

// Alias for backward compatibility
function loadOrders() {
    loadOrdersFromAPI();
}

function showNotification(message, type) {
    // Remove existing notifications
    const existingNotifications = document.querySelectorAll('.notification-badge');
    existingNotifications.forEach(n => n.remove());
    
    // Create new notification
    const notification = document.createElement('div');
    notification.className = `notification-badge ${type}`;
    notification.innerHTML = `
        <div class="d-flex align-items-center">
            <span>${message}</span>
            <button class="btn btn-sm ms-2 p-0" onclick="this.parentElement.parentElement.remove()" style="color: white; opacity: 0.8;">
                <i class="bi bi-x-lg"></i>
            </button>
        </div>
    `;
    
    document.body.appendChild(notification);
    
    // Auto remove after 5 seconds
    setTimeout(() => {
        if (notification.parentElement) {
            notification.remove();
        }
    }, 5000);
}

function playNotificationSound() {
    if (!isSoundEnabled) return;
    
    try {
        // Tạo âm thanh thông báo đẹp hơn bằng Web Audio API
        const audioContext = new (window.AudioContext || window.webkitAudioContext)();
        
        // Tạo chuỗi âm thanh: ding-dong-ding
        playTone(audioContext, 800, 0.1, 'sine'); // Nốt cao
        setTimeout(() => playTone(audioContext, 600, 0.1, 'sine'), 150); // Nốt thấp
        setTimeout(() => playTone(audioContext, 800, 0.2, 'sine'), 300); // Nốt cao dài
        
    } catch (error) {
        // Fallback to simple beep if Web Audio API not supported
        playSimpleBeep();
    }
}

function playTone(audioContext, frequency, duration, type = 'sine') {
    const oscillator = audioContext.createOscillator();
    const gainNode = audioContext.createGain();
    
    oscillator.connect(gainNode);
    gainNode.connect(audioContext.destination);
    
    oscillator.frequency.value = frequency;
    oscillator.type = type;
    
    gainNode.gain.setValueAtTime(0.3, audioContext.currentTime);
    gainNode.gain.exponentialRampToValueAtTime(0.01, audioContext.currentTime + duration);
    
    oscillator.start(audioContext.currentTime);
    oscillator.stop(audioContext.currentTime + duration);
}

function playSimpleBeep() {
    // Enhanced simple beep - longer and more pleasant
    const audio = new Audio('data:audio/wav;base64,UklGRhoBAABXQVZFZm10IBAAAAABAAEARKwAAIhYAQACABAAZGF0YQgBAAC0ssyDPK8TBLvhG0TH0hVE4wkkRu7wIkHdwiY+mZYhOmeQHStvgBg2WVQQP0gPE0dGC19dBkZtRVZGOCwJLhVOCyoAVRcsKCgOCxtVDj8nKB5bQR4VKTc9SVdIGydJF1gVMg1gNgdLRRdwTCMPgCclNz8yXy9gH1s3CQZtLQQEGSAGEy8XIl0REVBEMyIAXRU9HgKiPTVOCCUcITs3RhE6AhAAA/URADcFDgkDCREJKAIaCwJTCjcOBBdCBzkNDwgOOw4LBgAKDwIABbD7+OjR9fDW/vC7/fCF+vdz9/Zk8vdP8PhB6Pks5vkf6vgQ8vkC+v4FBA0IPRENKdYCOJAGOKYKOZ0OOVAPMo8OIXQIJHcCGFf9AFAA+/8t+/q3/PP89f3sCP0AEgP+IwMAMAIA+v8w9fgs6fIc4e8R3esPuPDy1YLyR9Hw8XnQ8JdkyP73Nbn+7zuv/Pk1qP/8OqT8AQCe+P8Gmfb+DZT0/RaR8/shjvP6LKf7COKP+xHdkPsJ2pP6/tiV+vHZkfvh2430YtqW8TrcsPCG3rr+3+FH/0XlLP9f6Bb+HusA/JXr/PdN7azy6e7P8WDxz/Hm8/3xvvby8ob7//WgA/PVDPP0BwP0/ggF9EUJBO6TB/bqcQn24nYK+N8lCvPaSAny1XwFytSg/07V3+kJ2K3Vg9xRwmbh5dZc50bY/+2r2S/zyOsn3OMLAAL4A9cLAOcT3QUD0xsJAyEhCQIjKwsBISEIAB4UBQEYAwDTEnv+Fxd++kEZd/W4HXT+mSNy+Pkpc+6tMHLp8j4N6sNR7v7LXb7K1GW+KdxetFbip6n+6IKglO93nBb29E2i+vMILKf+7hEyr/vs+TTC+eMqzdDvDRbcgBs5zJAoLrmGNjyoQUS2mPEz');
    audio.volume = 0.5;
    audio.play().catch(e => console.log('Cannot play notification sound'));
}

function toggleSound() {
    isSoundEnabled = !isSoundEnabled;
    const soundIcon = document.getElementById('soundIcon');
    const soundText = document.getElementById('soundText');
    const soundButton = document.getElementById('soundButton');
    
    if (isSoundEnabled) {
        soundIcon.className = 'bi bi-volume-up me-2';
        soundText.textContent = 'Âm thanh';
        soundButton.classList.remove('muted');
        showNotification('🔊 Đã bật âm thanh thông báo', 'info');
        
        // Add sound wave effect
        const soundWave = document.createElement('div');
        soundWave.className = 'sound-wave';
        soundButton.appendChild(soundWave);
        setTimeout(() => soundWave.remove(), 1000);
        
        // Test sound
        setTimeout(() => playNotificationSound(), 500);
    } else {
        soundIcon.className = 'bi bi-volume-mute me-2';
        soundText.textContent = 'Tắt tiếng';
        soundButton.classList.add('muted');
        showNotification('🔇 Đã tắt âm thanh thông báo', 'info');
    }
    
    // Save preference
    localStorage.setItem('soundEnabled', isSoundEnabled);
}

function playMultipleOrdersSound(orderCount) {
    if (!isSoundEnabled) return;
    
    try {
        const audioContext = new (window.AudioContext || window.webkitAudioContext)();
        
        // Play rapid ascending tones for multiple orders
        for (let i = 0; i < Math.min(orderCount, 5); i++) {
            const frequency = 600 + (i * 100); // Ascending notes
            const delay = i * 100;
            setTimeout(() => playTone(audioContext, frequency, 0.1, 'sine'), delay);
        }
        
        // Final celebratory chord
        setTimeout(() => {
            playTone(audioContext, 800, 0.3, 'sine');
            playTone(audioContext, 1000, 0.3, 'sine');
            playTone(audioContext, 1200, 0.3, 'sine');
        }, Math.min(orderCount, 5) * 100 + 200);
        
    } catch (error) {
        // Fallback
        for (let i = 0; i < Math.min(orderCount, 3); i++) {
            setTimeout(() => playSimpleBeep(), i * 200);
        }
    }
}

function playSuccessSound() {
    if (!isSoundEnabled) return;
    
    try {
        const audioContext = new (window.AudioContext || window.webkitAudioContext)();
        
        // Success: ascending major chord
        playTone(audioContext, 523, 0.2, 'sine'); // C
        setTimeout(() => playTone(audioContext, 659, 0.2, 'sine'), 100); // E
        setTimeout(() => playTone(audioContext, 784, 0.3, 'sine'), 200); // G
        
    } catch (error) {
        playSimpleBeep();
    }
}

function playErrorSound() {
    if (!isSoundEnabled) return;
    
    try {
        const audioContext = new (window.AudioContext || window.webkitAudioContext)();
        
        // Error: descending minor notes
        playTone(audioContext, 400, 0.2, 'sawtooth');
        setTimeout(() => playTone(audioContext, 300, 0.3, 'sawtooth'), 150);
        
    } catch (error) {
        playSimpleBeep();
    }
}

function filterOrders() {
    const filter = document.getElementById('statusFilter').value;
    const orderCards = document.querySelectorAll('.order-card');
    
    orderCards.forEach(card => {
        if (filter === 'all' || card.dataset.status === filter) {
            card.style.display = 'block';
        } else {
            card.style.display = 'none';
        }
    });
}
</script>

<style>
.order-card {
    transition: all 0.3s ease;
    border-left: 4px solid #e9ecef;
}

.order-card[data-status="pending"] {
    border-left-color: #ffc107;
    background: linear-gradient(90deg, #fff3cd, #ffffff);
}

.order-card[data-status="preparing"] {
    border-left-color: #17a2b8;
    background: linear-gradient(90deg, #d1ecf1, #ffffff);
}

.order-card[data-status="completed"] {
    border-left-color: #28a745;
    background: linear-gradient(90deg, #d4edda, #ffffff);
}

.order-card.completing {
    border: 2px solid #28a745;
    box-shadow: 0 0 20px rgba(40, 167, 69, 0.3);
    animation: completingPulse 1s infinite;
}

@keyframes completingPulse {
    0% { box-shadow: 0 0 20px rgba(40, 167, 69, 0.3); }
    50% { box-shadow: 0 0 30px rgba(40, 167, 69, 0.6); }
    100% { box-shadow: 0 0 20px rgba(40, 167, 69, 0.3); }
}

.completion-countdown {
    margin-top: 1rem;
    animation: slideInDown 0.3s ease-out;
}

@keyframes slideInDown {
    from {
        opacity: 0;
        transform: translateY(-20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.completion-countdown .alert {
    background: linear-gradient(45deg, #28a745, #20c997) !important;
    border: none;
    color: white;
    font-weight: 600;
    animation: countdownPulse 1s infinite;
}

@keyframes countdownPulse {
    0% { transform: scale(1); }
    50% { transform: scale(1.02); }
    100% { transform: scale(1); }
}

.order-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
}

.order-card.selected {
    border-color: #007bff !important;
    background: linear-gradient(90deg, #cce7ff, #ffffff) !important;
    box-shadow: 0 0 0 2px rgba(0, 123, 255, 0.25);
}

.order-checkbox {
    transform: scale(1.2);
}

.badge {
    font-size: 0.8em;
    border-radius: 20px;
}

.btn-sm {
    padding: 0.25rem 0.5rem;
    font-size: 0.875rem;
}

.modal-header {
    border-bottom: 2px solid #e9ecef;
}

.table th {
    background-color: #f8f9fa;
    border-bottom: 2px solid #dee2e6;
    font-weight: 600;
}

.alert {
    border-radius: 10px;
    border: none;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
}

.form-check-input:checked {
    background-color: #007bff;
    border-color: #007bff;
}

.form-switch .form-check-input {
    width: 2em;
    height: 1em;
}

.text-gradient {
    background: linear-gradient(45deg, #007bff, #6610f2);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.card-modern {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.2);
    border-radius: 15px;
    box-shadow: 0 8px 32px rgba(31, 38, 135, 0.1);
    transition: all 0.3s ease;
}

.card-modern:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 45px rgba(31, 38, 135, 0.2);
}

@keyframes pulse {
    0% { transform: scale(1); }
    50% { transform: scale(1.05); }
    100% { transform: scale(1); }
}

@keyframes slideInFromRight {
    0% {
        transform: translateX(100%);
        opacity: 0;
    }
    100% {
        transform: translateX(0);
        opacity: 1;
    }
}

.order-card.new-order {
    animation: slideInFromRight 0.5s ease-out, pulse 1s ease-in-out 3;
    border-left-width: 6px !important;
    box-shadow: 0 4px 20px rgba(40, 167, 69, 0.3) !important;
}

.notification-badge {
    position: fixed;
    top: 20px;
    right: 20px;
    z-index: 10000;
    padding: 15px 20px;
    border-radius: 10px;
    color: white;
    font-weight: bold;
    box-shadow: 0 4px 15px rgba(0,0,0,0.3);
    animation: slideInFromRight 0.3s ease-out;
}

.notification-badge.success {
    background: linear-gradient(45deg, #28a745, #20c997);
}

.notification-badge.info {
    background: linear-gradient(45deg, #17a2b8, #6610f2);
}

.notification-badge.error {
    background: linear-gradient(45deg, #dc3545, #fd7e14);
}

.auto-refresh-indicator {
    position: fixed;
    bottom: 20px;
    right: 20px;
    background: rgba(0, 123, 255, 0.9);
    color: white;
    padding: 8px 15px;
    border-radius: 20px;
    font-size: 12px;
    z-index: 1000;
}

.auto-refresh-indicator.active {
    animation: pulse 2s infinite;
}

.sound-button {
    position: relative;
    transition: all 0.3s ease;
}

.sound-button:hover {
    transform: scale(1.05);
}

.sound-button.muted {
    opacity: 0.6;
}

.sound-wave {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    width: 30px;
    height: 30px;
    border: 2px solid rgba(255, 255, 255, 0.3);
    border-radius: 50%;
    animation: soundWave 1s infinite;
    pointer-events: none;
}

@keyframes soundWave {
    0% {
        transform: translate(-50%, -50%) scale(0.5);
        opacity: 1;
    }
    100% {
        transform: translate(-50%, -50%) scale(1.5);
        opacity: 0;
    }
}

.notification-sound-btn {
    position: relative;
}

.notification-sound-btn::after {
    content: '🔊';
    position: absolute;
    top: -5px;
    right: -5px;
    font-size: 12px;
}
</style>

<?php
$content = ob_get_clean();
include 'restaurant_layout.php';
?>
