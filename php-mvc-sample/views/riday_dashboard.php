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
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
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

        /* Light theme variables */
        [data-theme="light"] {
            --dark-bg: #f8fafc;
            --sidebar-bg: #f1f5f9;
            --card-bg: #ffffff;
            --text-light: #334155;
            --text-muted: #64748b;
            --border-color: #e2e8f0;
        }

        /* Dark theme variables (default) */
        [data-theme="dark"] {
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

        .search-box {
            position: relative;
        }

        .search-box input {
            background: var(--dark-bg);
            border: 1px solid var(--border-color);
            border-radius: 10px;
            padding: 0.5rem 1rem 0.5rem 2.5rem;
            color: var(--text-light);
            width: 300px;
            transition: all 0.3s ease;
        }

        .search-box input:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
        }

        .search-box i {
            position: absolute;
            left: 0.75rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-muted);
        }

        .notification-icon, .settings-icon, .theme-toggle {
            position: relative;
            background: none;
            border: none;
            color: var(--text-light);
            font-size: 1.25rem;
            padding: 0.5rem;
            border-radius: 8px;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .notification-icon:hover, .settings-icon:hover, .theme-toggle:hover {
            background: rgba(99, 102, 241, 0.1);
            color: var(--primary-color);
        }

        .theme-toggle {
            position: relative;
            overflow: hidden;
        }

        .theme-toggle::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(99, 102, 241, 0.2), transparent);
            transition: left 0.5s;
        }

        .theme-toggle:hover::before {
            left: 100%;
        }

        #themeIcon {
            transition: transform 0.3s ease;
        }

        .theme-toggle:hover #themeIcon {
            transform: rotate(180deg);
        }

        .notification-badge {
            position: absolute;
            top: 0.25rem;
            right: 0.25rem;
            width: 8px;
            height: 8px;
            background: var(--danger-color);
            border-radius: 50%;
        }

        .user-menu {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            cursor: pointer;
            padding: 0.5rem;
            border-radius: 10px;
            transition: all 0.3s ease;
        }

        .user-menu:hover {
            background: rgba(99, 102, 241, 0.1);
        }

        .user-avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
        }

        .user-info h6 {
            margin: 0;
            font-size: 0.875rem;
            font-weight: 600;
        }

        .user-info span {
            font-size: 0.75rem;
            color: var(--text-muted);
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

        .stat-trend {
            display: flex;
            align-items: center;
            gap: 0.25rem;
            font-size: 0.75rem;
            padding: 0.25rem 0.5rem;
            border-radius: 6px;
        }

        .stat-trend.up {
            background: rgba(16, 185, 129, 0.1);
            color: var(--success-color);
        }

        .stat-trend.down {
            background: rgba(239, 68, 68, 0.1);
            color: var(--danger-color);
        }

        .stat-number {
            font-size: 2rem;
            font-weight: 700;
            color: white;
            margin-bottom: 0.5rem;
        }

        .stat-label {
            color: var(--text-muted);
            font-size: 0.875rem;
            margin-bottom: 0.75rem;
        }

        .stat-footer {
            display: flex;
            align-items: center;
            justify-content: space-between;
            font-size: 0.75rem;
            color: var(--text-muted);
        }

        /* Charts and Widgets */
        .dashboard-grid {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 2rem;
            margin-bottom: 2rem;
        }

        .chart-card, .widget-card {
            background: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 16px;
            padding: 1.5rem;
        }

        .card-header {
            display: flex;
            align-items: center;
            justify-content: between;
            margin-bottom: 1.5rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid var(--border-color);
        }

        .card-title {
            font-size: 1.125rem;
            font-weight: 600;
            color: white;
            margin-bottom: 0.25rem;
        }

        .card-subtitle {
            font-size: 0.875rem;
            color: var(--text-muted);
        }

        .chart-container {
            height: 300px;
            position: relative;
        }

        /* Orders List */
        .orders-section {
            background: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 16px;
            padding: 1.5rem;
        }

        .order-item {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 1rem;
            border: 1px solid var(--border-color);
            border-radius: 12px;
            margin-bottom: 1rem;
            transition: all 0.3s ease;
        }

        .order-item:hover {
            background: rgba(99, 102, 241, 0.05);
            border-color: var(--primary-color);
        }

        .order-info {
            flex: 1;
        }

        .order-id {
            font-weight: 600;
            color: white;
            margin-bottom: 0.25rem;
        }

        .order-details {
            font-size: 0.875rem;
            color: var(--text-muted);
        }

        .order-status {
            padding: 0.25rem 0.75rem;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
        }

        .status-pending { background: rgba(245, 158, 11, 0.1); color: var(--warning-color); }
        .status-preparing { background: rgba(6, 182, 212, 0.1); color: var(--info-color); }
        .status-completed { background: rgba(16, 185, 129, 0.1); color: var(--success-color); }

        .order-amount {
            font-weight: 700;
            color: white;
            font-size: 1.125rem;
        }

        /* Recent Activity */
        .activity-item {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 0.75rem 0;
            border-bottom: 1px solid var(--border-color);
        }

        .activity-item:last-child {
            border-bottom: none;
        }

        .activity-icon {
            width: 32px;
            height: 32px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.875rem;
            background: rgba(99, 102, 241, 0.1);
            color: var(--primary-color);
        }

        .activity-content {
            flex: 1;
        }

        .activity-title {
            font-size: 0.875rem;
            color: white;
            margin-bottom: 0.25rem;
        }

        .activity-time {
            font-size: 0.75rem;
            color: var(--text-muted);
        }

        /* Quick Actions */
        .quick-actions {
            display: flex;
            gap: 1rem;
            margin-bottom: 2rem;
        }

        .action-btn {
            background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
            border: none;
            border-radius: 12px;
            padding: 0.75rem 1.5rem;
            color: white;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .action-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(99, 102, 241, 0.3);
        }

        .action-btn.secondary {
            background: rgba(100, 116, 139, 0.2);
            color: var(--text-light);
        }

        .action-btn.secondary:hover {
            background: rgba(100, 116, 139, 0.3);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
        }
        
        .action-btn.danger {
            background: rgba(220, 53, 69, 0.1);
            border: 1px solid var(--danger-color);
            color: var(--danger-color);
        }
        
        .action-btn.danger:hover {
            background: var(--danger-color);
            color: white;
            box-shadow: 0 10px 25px rgba(220, 53, 69, 0.3);
        }

        /* Responsive */
        @media (max-width: 1024px) {
            .dashboard-grid {
                grid-template-columns: 1fr;
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

            .search-box input {
                width: 200px;
            }

            .dashboard-content {
                padding: 1rem;
            }

            .stats-grid {
                grid-template-columns: 1fr;
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

        /* Loading Animation */
        .loading-pulse {
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0% { opacity: 1; }
            50% { opacity: 0.5; }
            100% { opacity: 1; }
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
            display: flex;
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

        /* Order management styles */
        .order-card {
            transition: all 0.3s ease;
            border: 1px solid var(--border-color) !important;
            background: var(--card-bg) !important;
        }

        .order-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.3);
        }

        .order-card.selected {
            border-color: var(--primary-color) !important;
            background: rgba(99, 102, 241, 0.1) !important;
        }

        .order-card.new-order {
            animation: pulse 2s ease-in-out 3;
        }

        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.02); }
            100% { transform: scale(1); }
        }

        .sound-button.muted {
            opacity: 0.6;
        }

        .sound-wave {
            position: absolute;
            top: 50%;
            left: 50%;
            width: 20px;
            height: 20px;
            border: 2px solid var(--primary-color);
            border-radius: 50%;
            transform: translate(-50%, -50%);
            animation: soundWave 1s ease-out;
        }

        @keyframes soundWave {
            0% {
                transform: translate(-50%, -50%) scale(0);
                opacity: 1;
            }
            100% {
                transform: translate(-50%, -50%) scale(3);
                opacity: 0;
            }
        }

        /* Dark theme for tables */
        .table-dark {
            --bs-table-bg: var(--card-bg);
            --bs-table-striped-bg: rgba(255, 255, 255, 0.05);
        }

        .table-dark th,
        .table-dark td {
            border-color: var(--border-color);
        }

        /* Light theme specific adjustments */
        [data-theme="light"] .sidebar {
            background: linear-gradient(180deg, var(--sidebar-bg) 0%, var(--dark-bg) 100%);
            border-right: 1px solid var(--border-color);
            box-shadow: 2px 0 10px rgba(0, 0, 0, 0.08);
        }

        [data-theme="light"] .topbar {
            background: rgba(248, 250, 252, 0.95);
            border-bottom: 1px solid var(--border-color);
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
        }

        [data-theme="light"] .stats-card {
            background: var(--card-bg);
            border: 1px solid var(--border-color);
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
        }
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }

        [data-theme="light"] .chart-card {
            background: #ffffff;
            border: 1px solid var(--border-color);
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }

        [data-theme="light"] .table-dark {
            --bs-table-bg: #ffffff;
            --bs-table-striped-bg: #f8fafc;
            color: var(--text-light);
        }

        [data-theme="light"] .table-dark th {
            background: #f8fafc;
            color: var(--text-light);
            border-color: var(--border-color);
        }

        [data-theme="light"] .table-dark td {
            color: var(--text-light);
            border-color: var(--border-color);
        }

        [data-theme="light"] .nav-link {
            color: var(--text-light);
        }

        [data-theme="light"] .nav-link:hover {
            background: rgba(99, 102, 241, 0.1);
            color: var(--primary-color);
        }

        [data-theme="light"] .nav-link.active {
            background: var(--primary-color);
            color: white;
        }

        [data-theme="light"] .badge {
            color: var(--text-light) !important;
        }

        [data-theme="light"] .search-box input {
            background: #ffffff;
            color: var(--text-light);
            border: 1px solid var(--border-color);
        }

        [data-theme="light"] .search-box input::placeholder {
            color: var(--text-muted);
        }

        /* Search highlight styles */
        .search-highlight {
            background: linear-gradient(120deg, #fbbf24 0%, #f59e0b 100%);
            color: #1f2937;
            padding: 0.1rem 0.2rem;
            border-radius: 3px;
            font-weight: 600;
            animation: highlightPulse 1s ease-in-out;
        }

        @keyframes highlightPulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }

        /* Search Results Info */
        .search-results-info {
            background: rgba(99, 102, 241, 0.1);
            border: 1px solid rgba(99, 102, 241, 0.3);
            color: var(--text-light);
            padding: 12px 20px;
            border-radius: 8px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            animation: slideInDown 0.3s ease;
        }

        [data-theme="light"] .search-results-info {
            background: rgba(99, 102, 241, 0.05);
            border-color: rgba(99, 102, 241, 0.2);
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

        /* Notification Toast */
        .notification-toast {
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
            border-left: 4px solid rgba(255, 255, 255, 0.3);
        }

        /* Enhanced Theme Toggle Animation */
        .theme-toggle #themeIcon {
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .theme-toggle:hover #themeIcon {
            transform: scale(1.1) rotate(15deg);
        }

        /* Light theme input placeholders */
        [data-theme="light"] input::placeholder {
            color: #94a3b8;
        }

        [data-theme="light"] input:focus::placeholder {
            color: #cbd5e1;
        }

        /* Dark/Light Theme for Charts */
        [data-theme="light"] .chart-container {
            background: #ffffff;
            border: 1px solid #e2e8f0;
        }

        [data-theme="light"] .chart-container canvas {
            filter: none;
        }

        [data-theme="dark"] .chart-container canvas {
            filter: brightness(0.9);
        }

        /* Fix Bootstrap text classes in light mode */
        [data-theme="light"] .text-light {
            color: var(--text-light) !important;
        }

        [data-theme="light"] .text-muted {
            color: var(--text-muted) !important;
        }

        [data-theme="light"] .text-white {
            color: #1e293b !important;
        }

        [data-theme="light"] .text-dark {
            color: var(--text-light) !important;
        }

        /* Fix badge colors in light mode */
        [data-theme="light"] .badge.bg-warning,
        [data-theme="light"] .badge.bg-info {
            color: #1e293b !important;
        }

        [data-theme="light"] .badge.bg-success,
        [data-theme="light"] .badge.bg-secondary,
        [data-theme="light"] .badge.bg-danger {
            color: #ffffff !important;
        }

        /* Fix table text colors */
        [data-theme="light"] .table th,
        [data-theme="light"] .table td {
            color: var(--text-light) !important;
        }

        /* Fix dropdown and modal text */
        [data-theme="light"] .dropdown-menu {
            background: var(--card-bg);
            border: 1px solid var(--border-color);
        }

        [data-theme="light"] .dropdown-item {
            color: var(--text-light);
        }

        [data-theme="light"] .dropdown-item:hover {
            background: rgba(99, 102, 241, 0.1);
            color: var(--text-light);
        }

        [data-theme="light"] .modal-content {
            background: var(--card-bg);
            color: var(--text-light);
        }

        [data-theme="light"] .modal-header {
            border-bottom: 1px solid var(--border-color);
        }

        [data-theme="light"] .modal-footer {
            border-top: 1px solid var(--border-color);
        }

        /* Global text color fixes for light mode */
        [data-theme="light"] h1, [data-theme="light"] h2, [data-theme="light"] h3, 
        [data-theme="light"] h4, [data-theme="light"] h5, [data-theme="light"] h6 {
            color: var(--text-light) !important;
        }

        [data-theme="light"] p, [data-theme="light"] span, [data-theme="light"] div {
            color: var(--text-light);
        }

        [data-theme="light"] .small, [data-theme="light"] small {
            color: var(--text-muted) !important;
        }

        /* Fix form elements text */
        [data-theme="light"] .form-label, [data-theme="light"] label {
            color: var(--text-light) !important;
        }

        [data-theme="light"] .form-control {
            background: var(--card-bg) !important;
            border: 1px solid var(--border-color) !important;
            color: var(--text-light) !important;
        }

        [data-theme="light"] .form-control:focus {
            background: var(--card-bg) !important;
            border-color: var(--primary-color) !important;
            color: var(--text-light) !important;
            box-shadow: 0 0 0 0.2rem rgba(99, 102, 241, 0.25) !important;
        }

        [data-theme="light"] .form-select {
            background: var(--card-bg) !important;
            border: 1px solid var(--border-color) !important;
            color: var(--text-light) !important;
        }

        /* Fix button text colors */
        [data-theme="light"] .btn-outline-primary {
            color: var(--primary-color) !important;
            border-color: var(--primary-color) !important;
        }

        [data-theme="light"] .btn-outline-primary:hover {
            background: var(--primary-color) !important;
            color: #ffffff !important;
        }

        [data-theme="light"] .btn-outline-secondary {
            color: var(--text-light) !important;
            border-color: var(--border-color) !important;
        }

        [data-theme="light"] .btn-outline-secondary:hover {
            background: var(--text-light) !important;
            color: var(--card-bg) !important;
        }

        /* Fix navigation text */
        [data-theme="light"] .navbar-brand {
            color: var(--text-light) !important;
        }

        [data-theme="light"] .nav-link {
            color: var(--text-light) !important;
        }

        [data-theme="light"] .nav-link:hover {
            color: var(--primary-color) !important;
        }

        /* Fix alert text colors */
        [data-theme="light"] .alert {
            color: var(--text-light) !important;
        }

        /* Fix list group items */
        [data-theme="light"] .list-group-item {
            background: var(--card-bg) !important;
            border: 1px solid var(--border-color) !important;
            color: var(--text-light) !important;
        }

        /* Fix menu items table in light mode */
        [data-theme="light"] .table tbody tr {
            border-bottom: 1px solid var(--border-color) !important;
        }

        [data-theme="light"] .table tbody td {
            color: var(--text-light) !important;
            background: var(--card-bg) !important;
        }

        [data-theme="light"] .table tbody td strong {
            color: var(--text-light) !important;
        }

        [data-theme="light"] .table tbody td small {
            color: var(--text-muted) !important;
        }

        /* Fix buttons in menu items */
        [data-theme="light"] .btn-outline-light {
            color: var(--text-light) !important;
            border-color: var(--border-color) !important;
            background: transparent !important;
        }

        [data-theme="light"] .btn-outline-light:hover {
            background: var(--text-light) !important;
            color: var(--card-bg) !important;
            border-color: var(--text-light) !important;
        }

        /* Fix dynamically generated content */
        [data-theme="light"] tr[style*="border-bottom"] {
            border-bottom-color: var(--border-color) !important;
        }

        [data-theme="light"] td[style*="color"] {
            color: var(--text-light) !important;
        }

        [data-theme="light"] strong[style*="color"] {
            color: var(--text-light) !important;
        }

        [data-theme="light"] small[style*="color"] {
            color: var(--text-muted) !important;
        }

        /* Fix image containers in menu items */
        [data-theme="light"] div[style*="background: var(--dark-bg)"] {
            background: var(--card-bg) !important;
            border: 1px solid var(--border-color) !important;
        }

        /* Specific menu item styling */
        .menu-item-row {
            background: var(--card-bg) !important;
        }

        .menu-item-name {
            color: var(--text-light) !important;
        }

        .menu-item-desc {
            color: var(--text-muted) !important;
        }

        .menu-item-category {
            color: var(--text-light) !important;
        }

        .menu-item-price {
            color: var(--text-light) !important;
        }

        .menu-image-container {
            background: var(--card-bg) !important;
            border: 1px solid var(--border-color) !important;
        }

        [data-theme="light"] .menu-image-container {
            background: var(--dark-bg) !important;
            border: 1px solid var(--border-color) !important;
        }

        /* Force override for dynamically generated menu items */
        [data-theme="light"] .menu-item-row td {
            color: var(--text-light) !important;
            background: var(--card-bg) !important;
        }

        [data-theme="light"] .menu-item-name {
            color: var(--text-light) !important;
        }

        [data-theme="light"] .menu-item-desc {
            color: var(--text-muted) !important;
        }

        [data-theme="light"] .menu-item-category {
            color: var(--text-light) !important;
        }

        [data-theme="light"] .menu-item-price {
            color: var(--text-light) !important;
        }

        /* Fix table headers in light mode */
        [data-theme="light"] .table thead {
            background: var(--card-bg) !important;
        }

        [data-theme="light"] .table thead th {
            background: var(--card-bg) !important;
            color: var(--text-light) !important;
            border-bottom: 2px solid var(--border-color) !important;
        }

        [data-theme="light"] thead[style*="background: var(--dark-bg)"] {
            background: var(--card-bg) !important;
        }

        [data-theme="light"] thead[style*="background: var(--dark-bg)"] th {
            background: var(--card-bg) !important;
            color: var(--text-light) !important;
        }

        .no-search-results {
            text-align: center;
            padding: 2rem;
            color: var(--text-muted);
            font-style: italic;
        }

        .search-results-info {
            background: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 8px;
            padding: 0.75rem 1rem;
            margin-bottom: 1rem;
            color: var(--text-light);
            font-size: 0.9rem;
        }

        /* Transition for theme switching */
        * {
            transition: background-color 0.3s ease, color 0.3s ease, border-color 0.3s ease !important;
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <div class="logo">🍜</div>
            <div class="brand-text">Riday Dashboard</div>
        </div>
        
        <nav class="sidebar-nav">
            <div class="nav-section">
                <div class="nav-section-title">Main</div>
                <div class="nav-item">
                    <a href="#" class="nav-link active" onclick="showDashboardPage()">
                        <i class="bi bi-grid-1x2"></i>
                        <span class="nav-text">Dashboard</span>
                    </a>
                </div>
                <div class="nav-item">
                    <a href="#" class="nav-link" onclick="showOrdersPage()">
                        <i class="bi bi-receipt"></i>
                        <span class="nav-text">Orders</span>
                        <span class="badge bg-warning" id="pendingOrdersBadge">5</span>
                    </a>
                </div>
                <div class="nav-item">
                    <a href="#" class="nav-link" data-bs-toggle="collapse" data-bs-target="#menuSubmenu">
                        <i class="bi bi-list-ul"></i>
                        <span class="nav-text">Menu</span>
                        <i class="bi bi-chevron-down ms-auto"></i>
                    </a>
                    <div class="collapse" id="menuSubmenu">
                        <div class="nav-item ms-3">
                            <a href="#" class="nav-link" onclick="showAddMenuPage()">
                                <i class="bi bi-plus"></i>
                                <span class="nav-text">Add New Menu</span>
                            </a>
                        </div>
                        <div class="nav-item ms-3">
                            <a href="#" class="nav-link" onclick="showMenuListPage()">
                                <i class="bi bi-list"></i>
                                <span class="nav-text">Menu List</span>
                            </a>
                        </div>
                        <div class="nav-item ms-3">
                            <a href="#" class="nav-link">
                                <i class="bi bi-tags"></i>
                                <span class="nav-text">Categories</span>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="bi bi-people"></i>
                        <span class="nav-text">Customers</span>
                    </a>
                </div>
            </div>
            
            <div class="nav-section">
                <div class="nav-section-title">Analytics</div>
                <div class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="bi bi-bar-chart"></i>
                        <span class="nav-text">Analysis</span>
                    </a>
                </div>
                <div class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="bi bi-graph-up"></i>
                        <span class="nav-text">Reports</span>
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
                <div class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="bi bi-question-circle"></i>
                        <span class="nav-text">Help</span>
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
                    <span class="text-light">Restaurant Overview</span>
                </div>
            </div>
            
            <div class="topbar-right">
                <div class="search-box">
                    <i class="bi bi-search"></i>
                    <input type="text" id="globalSearch" placeholder="Search orders, menu, customers..." oninput="performGlobalSearch(this.value)">
                </div>
                
                <button class="theme-toggle" id="themeToggle" onclick="toggleTheme()" title="Toggle Dark/Light Mode">
                    <i class="bi bi-moon-fill" id="themeIcon"></i>
                </button>
                
                <button class="notification-icon" id="soundButton" onclick="toggleSound()">
                    <i class="bi bi-volume-up" id="soundIcon"></i>
                    <div class="notification-badge"></div>
                </button>
                
                <button class="notification-icon">
                    <i class="bi bi-bell"></i>
                    <div class="notification-badge"></div>
                </button>
                
                <button class="settings-icon">
                    <i class="bi bi-gear"></i>
                </button>
                
                <div class="user-menu">
                    <div class="user-avatar">A</div>
                    <div class="user-info">
                        <h6>Admin User</h6>
                        <span>Restaurant Manager</span>
                    </div>
                    <i class="bi bi-chevron-down"></i>
                </div>
            </div>
        </div>

        <!-- Dashboard Content -->
        <div class="dashboard-content">
            <!-- Add Menu Page -->
            <div id="addMenuPage" style="display: none;">
                <div class="page-header">
                    <h1 class="page-title"><i class="bi bi-plus-circle"></i> Add Menu</h1>
                    <p class="page-subtitle">Manage Your food and beverages menu</p>
                </div>
                
                <div class="row">
                    <div class="col-lg-8">
                        <div class="chart-card">
                            <div class="card-header">
                                <div>
                                    <h3 class="card-title">Add/Edit Menu</h3>
                                    <p class="card-subtitle">Fill in the menu item details</p>
                                </div>
                            </div>
                            <form id="addMenuForm">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Menu Name *</label>
                                        <input type="text" class="form-control" id="menuName" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Category</label>
                                        <select class="form-select" id="menuCategory">
                                            <option value="">Select Category</option>
                                            <option value="Food">Food</option>
                                            <option value="Drinks">Drinks</option>
                                            <option value="Dessert">Dessert</option>
                                            <option value="Appetizer">Appetizer</option>
                                        </select>
                                    </div>
                                </div>
                                
                                <div class="mb-3">
                                    <label class="form-label">Ingredients</label>
                                    <input type="text" class="form-control" id="menuIngredients" placeholder="e.g., Tomato, Cheese, Basil">
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label">Status</label>
                                        <select class="form-select" id="menuStatus">
                                            <option value="available">Published</option>
                                            <option value="unavailable">Draft</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label">Price (VNĐ) *</label>
                                        <input type="number" class="form-control" id="menuPrice" min="0" required>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label">Discount (%)</label>
                                        <input type="number" class="form-control" id="menuDiscount" min="0" max="100" value="0">
                                    </div>
                                </div>
                                
                                <div class="mb-3">
                                    <label class="form-label">Ingredients and Description</label>
                                    <textarea class="form-control" id="menuDescription" rows="5" placeholder="There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form..."></textarea>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Meta Title</label>
                                        <input type="text" class="form-control" id="metaTitle">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Meta Keyword</label>
                                        <input type="text" class="form-control" id="metaKeyword">
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    
                    <div class="col-lg-4">
                        <div class="widget-card">
                            <div class="card-header">
                                <div>
                                    <h3 class="card-title">Uploaded Image</h3>
                                    <p class="card-subtitle">Menu item image</p>
                                </div>
                            </div>
                            <div class="text-center">
                                <div class="menu-item-image mb-3" id="imagePreview" style="height: 200px; border-radius: 12px; background: var(--dark-bg); border: 2px dashed var(--border-color); display: flex; align-items: center; justify-content: center;">
                                    <div class="placeholder">
                                        <i class="bi bi-camera" style="font-size: 3rem; color: var(--text-muted);"></i>
                                        <p class="text-muted mt-2">Click to upload image</p>
                                    </div>
                                </div>
                                <input type="file" class="form-control mb-3" id="menuImage" accept="image/*">
                                <small class="text-muted">Images will be uploaded to Cloudinary cloud storage</small>
                                <div class="d-flex gap-2 justify-content-center">
                                    <button type="button" class="btn btn-outline-light btn-sm">
                                        <i class="bi bi-upload"></i> Upload Another Image
                                    </button>
                                    <button type="button" class="btn btn-outline-warning btn-sm">
                                        <i class="bi bi-pencil"></i> Edit
                                    </button>
                                    <button type="button" class="btn btn-outline-danger btn-sm">
                                        <i class="bi bi-trash"></i> Delete
                                    </button>
                                </div>
                            </div>
                        </div>
                        
                        <div class="widget-card">
                            <div class="card-header">
                                <div>
                                    <h3 class="card-title">General Info</h3>
                                    <p class="card-subtitle">Actions</p>
                                </div>
                            </div>
                            <div class="d-grid gap-2">
                                <button type="button" class="action-btn" onclick="addMenuItem()">
                                    <i class="bi bi-check-circle"></i> Save / Add
                                </button>
                                <button type="button" class="action-btn secondary" onclick="showDashboardPage()">
                                    <i class="bi bi-x-circle"></i> Cancel
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Menu List Page -->
            <div id="menuListPage" style="display: none;">
                <div class="page-header">
                    <h1 class="page-title"><i class="bi bi-list-ul"></i> Menu List</h1>
                    <p class="page-subtitle">Manage Your food and beverages menu</p>
                </div>
                
                <!-- Stats Row -->
                <div class="stats-grid mb-4">
                    <div class="stat-card primary">
                        <div class="stat-header">
                            <div class="stat-icon primary">
                                <i class="bi bi-list-ul"></i>
                            </div>
                        </div>
                        <div class="stat-number" id="totalMenuItems">0</div>
                        <div class="stat-label">Total Menu Items</div>
                    </div>
                    <div class="stat-card success">
                        <div class="stat-header">
                            <div class="stat-icon success">
                                <i class="bi bi-check-circle"></i>
                            </div>
                        </div>
                        <div class="stat-number" id="publishedMenuItems">0</div>
                        <div class="stat-label">Published</div>
                    </div>
                    <div class="stat-card warning">
                        <div class="stat-header">
                            <div class="stat-icon warning">
                                <i class="bi bi-clock"></i>
                            </div>
                        </div>
                        <div class="stat-number" id="draftMenuItems">0</div>
                        <div class="stat-label">Draft</div>
                    </div>
                    <div class="stat-card danger">
                        <div class="stat-header">
                            <div class="stat-icon danger">
                                <i class="bi bi-image"></i>
                            </div>
                        </div>
                        <div class="stat-number" id="menuItemsWithImages">0</div>
                        <div class="stat-label">With Images</div>
                    </div>
                </div>

                <!-- Controls -->
                <div class="quick-actions mb-4">
                    <button class="action-btn" onclick="showAddMenuPage()">
                        <i class="bi bi-plus-circle"></i> Add New Menu
                    </button>
                    <button class="action-btn secondary" onclick="loadMenuItems()">
                        <i class="bi bi-arrow-clockwise"></i> Refresh
                    </button>
                    <div class="d-flex gap-2 ms-auto">
                        <input type="text" class="form-control" id="searchInput" placeholder="Search menu items..." onkeyup="searchMenuItems()" style="width: 250px; background: var(--dark-bg); border: 1px solid var(--border-color); color: var(--text-light);">
                        <select class="form-select" id="statusFilter" onchange="filterMenuItems()" style="width: 150px; background: var(--dark-bg); border: 1px solid var(--border-color); color: var(--text-light);">
                            <option value="">All Status</option>
                            <option value="available">Published</option>
                            <option value="unavailable">Draft</option>
                        </select>
                    </div>
                </div>

                <!-- Menu Items Table -->
                <div class="chart-card">
                    <div class="card-header">
                        <div>
                            <h3 class="card-title">Menu Items</h3>
                            <p class="card-subtitle">All menu items with actions</p>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table" style="color: var(--text-light);">
                            <thead style="background: var(--dark-bg);">
                                <tr>
                                    <th>Image</th>
                                    <th>Menu Name</th>
                                    <th>Category</th>
                                    <th>Price</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody id="menuTableBody">
                                <!-- Menu items will be loaded here -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Orders Page -->
            <div id="ordersPage" style="display: none;">
                <div class="page-header">
                    <h1 class="page-title"><i class="bi bi-receipt"></i> Orders Management</h1>
                    
                    <div class="d-flex gap-2 mb-4">
                        <button class="btn btn-outline-light btn-sm" onclick="loadOrdersFromAPI()">
                            <i class="bi bi-arrow-clockwise"></i> Refresh Orders
                        </button>
                        <button class="btn btn-outline-warning btn-sm" onclick="testDebug()">
                            🐛 Debug Test
                        </button>
                    </div>
                    <p class="page-subtitle">Manage restaurant orders and track status</p>
                </div>
                
                <!-- Orders Stats Row -->
                <div class="stats-grid mb-4">
                    <div class="stat-card warning">
                        <div class="stat-header">
                            <div class="stat-icon warning">
                                <i class="bi bi-clock-history"></i>
                            </div>
                        </div>
                        <div class="stat-number" id="ordersStatsTotal">0</div>
                        <div class="stat-label">Total Orders Today</div>
                    </div>
                    <div class="stat-card danger">
                        <div class="stat-header">
                            <div class="stat-icon danger">
                                <i class="bi bi-exclamation-triangle"></i>
                            </div>
                        </div>
                        <div class="stat-number" id="ordersStatsPending">0</div>
                        <div class="stat-label">Pending Orders</div>
                    </div>
                    <div class="stat-card info">
                        <div class="stat-header">
                            <div class="stat-icon info">
                                <i class="bi bi-arrow-repeat"></i>
                            </div>
                        </div>
                        <div class="stat-number" id="ordersStatsPreparing">0</div>
                        <div class="stat-label">Preparing</div>
                    </div>
                    <div class="stat-card success">
                        <div class="stat-header">
                            <div class="stat-icon success">
                                <i class="bi bi-check-circle"></i>
                            </div>
                        </div>
                        <div class="stat-number" id="ordersStatsCompleted">0</div>
                        <div class="stat-label">Completed</div>
                    </div>
                </div>

                <!-- Orders Controls -->
                <div class="quick-actions mb-4">
                    <button class="action-btn" onclick="loadAllOrders()">
                        <i class="bi bi-arrow-clockwise"></i> Refresh Orders
                    </button>
                    <button class="action-btn secondary" onclick="toggleMultiSelect()">
                        <i class="bi bi-check2-square"></i> Multi Select
                    </button>
                    <button class="action-btn secondary" id="bulkActionBtn" style="display: none;" onclick="showBulkActions()">
                        <i class="bi bi-gear"></i> Bulk Actions
                    </button>
                    <div class="d-flex gap-2 ms-auto">
                        <select class="form-select" id="orderStatusFilter" onchange="filterOrders()" style="width: 150px; background: var(--dark-bg); border: 1px solid var(--border-color); color: var(--text-light);">
                            <option value="active">Active Orders</option>
                            <option value="pending">Pending</option>
                            <option value="preparing">Preparing</option>
                            <option value="completed">Completed</option>
                        </select>
                        <input type="text" class="form-control" id="orderSearchInput" placeholder="Search orders..." onkeyup="searchOrders()" style="width: 200px; background: var(--dark-bg); border: 1px solid var(--border-color); color: var(--text-light);">
                    </div>
                </div>

                <!-- Orders Table -->
                <div class="chart-card">
                    <div class="card-header">
                        <div>
                            <h3 class="card-title">All Orders</h3>
                            <p class="card-subtitle">Current restaurant orders with details</p>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table" style="color: var(--text-light);">
                            <thead style="background: var(--dark-bg);">
                                <tr>
                                    <th style="display: none;" id="checkboxColumn">
                                        <input type="checkbox" id="selectAllOrders" onchange="toggleSelectAllOrders()">
                                    </th>
                                    <th>Order Code</th>
                                    <th>Table</th>
                                    <th>Items</th>
                                    <th>Total</th>
                                    <th>Status</th>
                                    <th>Time</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody id="ordersTableBody">
                                <!-- Orders will be loaded here -->
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Orders Container for card view -->
                    <div id="ordersContainer" style="display: none;">
                        <!-- Orders cards will be displayed here -->
                    </div>
                </div>
            </div>

            <!-- Default Dashboard Page -->
            <div id="dashboardPage">
            <!-- Page Header -->
            <div class="page-header">
                <h1 class="page-title">Restaurant Dashboard</h1>
                <p class="page-subtitle">Welcome back! Here's what's happening at your restaurant today.</p>
            </div>

            <!-- Quick Actions -->
            <div class="quick-actions">
                <button class="action-btn" onclick="refreshDashboard()">
                    <i class="bi bi-arrow-clockwise"></i>
                    Refresh Data
                </button>
                <button class="action-btn secondary" onclick="viewAllOrders()">
                    <i class="bi bi-list-ul"></i>
                    View All Orders
                </button>
                <button class="action-btn secondary" onclick="showAddMenuPage()">
                    <i class="bi bi-plus-circle"></i>
                    Add Menu Item
                </button>
                <button class="action-btn danger" onclick="confirmResetStats()">
                    <i class="bi bi-trash3"></i>
                    Reset All Data
                </button>
            </div>

            <!-- Stats Grid -->
            <div class="stats-grid">
                <div class="stat-card warning">
                    <div class="stat-header">
                        <div class="stat-icon warning">
                            <i class="bi bi-clock-history"></i>
                        </div>
                        <div class="stat-trend up">
                            <i class="bi bi-arrow-up"></i>
                            +3%
                        </div>
                    </div>
                    <div class="stat-number" id="pendingCount">89</div>
                    <div class="stat-label">Pending Orders</div>
                    <div class="stat-footer">
                        <span>vs last week</span>
                        <span>15 days</span>
                    </div>
                </div>

                <div class="stat-card success">
                    <div class="stat-header">
                        <div class="stat-icon success">
                            <i class="bi bi-check-circle"></i>
                        </div>
                        <div class="stat-trend up">
                            <i class="bi bi-arrow-up"></i>
                            +8%
                        </div>
                    </div>
                    <div class="stat-number" id="deliveredCount">899</div>
                    <div class="stat-label">Total Delivered</div>
                    <div class="stat-footer">
                        <span>vs last week</span>
                        <span>15 days</span>
                    </div>
                </div>

                <div class="stat-card danger">
                    <div class="stat-header">
                        <div class="stat-icon danger">
                            <i class="bi bi-x-circle"></i>
                        </div>
                        <div class="stat-trend down">
                            <i class="bi bi-arrow-down"></i>
                            -2%
                        </div>
                    </div>
                    <div class="stat-number" id="canceledCount">59</div>
                    <div class="stat-label">Total Canceled</div>
                    <div class="stat-footer">
                        <span>vs last week</span>
                        <span>15 days</span>
                    </div>
                </div>

                <div class="stat-card primary">
                    <div class="stat-header">
                        <div class="stat-icon primary">
                            <i class="bi bi-currency-dollar"></i>
                        </div>
                        <div class="stat-trend up">
                            <i class="bi bi-arrow-up"></i>
                            +12%
                        </div>
                    </div>
                    <div class="stat-number" id="revenueToday">$789k</div>
                    <div class="stat-label">Total Revenue</div>
                    <div class="stat-footer">
                        <span>vs last week</span>
                        <span>15 days</span>
                    </div>
                </div>
            </div>

            <!-- Dashboard Grid -->
            <div class="dashboard-grid">
                <!-- Revenue Chart -->
                <div class="chart-card">
                    <div class="card-header">
                        <div>
                            <h3 class="card-title">Daily Revenue</h3>
                            <p class="card-subtitle">Revenue trends over the last 7 days</p>
                        </div>
                    </div>
                    <div class="chart-container">
                        <canvas id="revenueChart"></canvas>
                    </div>
                </div>

                <!-- Recent Activity -->
                <div class="widget-card">
                    <div class="card-header">
                        <div>
                            <h3 class="card-title">Recent Activity</h3>
                            <p class="card-subtitle">Latest updates and notifications</p>
                        </div>
                    </div>
                    <div id="activityList">
                        <div class="activity-item">
                            <div class="activity-icon">
                                <i class="bi bi-plus-circle"></i>
                            </div>
                            <div class="activity-content">
                                <div class="activity-title">New order #ORD-2024-001</div>
                                <div class="activity-time">2 minutes ago</div>
                            </div>
                        </div>
                        <div class="activity-item">
                            <div class="activity-icon">
                                <i class="bi bi-check-circle"></i>
                            </div>
                            <div class="activity-content">
                                <div class="activity-title">Order #ORD-2024-000 completed</div>
                                <div class="activity-time">5 minutes ago</div>
                            </div>
                        </div>
                        <div class="activity-item">
                            <div class="activity-icon">
                                <i class="bi bi-person-plus"></i>
                            </div>
                            <div class="activity-content">
                                <div class="activity-title">New customer registered</div>
                                <div class="activity-time">10 minutes ago</div>
                            </div>
                        </div>
                        <div class="activity-item">
                            <div class="activity-icon">
                                <i class="bi bi-star"></i>
                            </div>
                            <div class="activity-content">
                                <div class="activity-title">5-star review received</div>
                                <div class="activity-time">15 minutes ago</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Current Orders -->
            <div class="orders-section">
                <div class="card-header">
                    <div>
                        <h3 class="card-title">Current Orders</h3>
                        <p class="card-subtitle">Orders currently being processed</p>
                    </div>
                    <div class="d-flex gap-2">
                        <button class="btn btn-outline-light btn-sm" onclick="loadCurrentOrders()">
                            <i class="bi bi-arrow-clockwise"></i> Refresh
                        </button>
                        <button class="btn btn-outline-success btn-sm" onclick="showAllOrdersPage()">
                            <i class="bi bi-list"></i> View All Orders
                        </button>
                    </div>
                </div>
                <div id="currentOrders">
                    <!-- Orders will be loaded here -->
                </div>
            </div>
            </div>
        </div>
    </div>

    <!-- Edit Menu Modal -->
    <div class="modal fade" id="editMenuModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content" style="background: var(--card-bg); border: 1px solid var(--border-color);">
                <div class="modal-header" style="border-bottom: 1px solid var(--border-color);">
                    <h5 class="modal-title" style="color: var(--text-light);">Edit Menu Item</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" style="filter: invert(1);"></button>
                </div>
                <div class="modal-body">
                    <form id="editMenuForm">
                        <input type="hidden" id="editMenuId">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label" style="color: var(--text-light);">Menu Name *</label>
                                <input type="text" class="form-control" id="editMenuName" required style="background: var(--dark-bg); border: 1px solid var(--border-color); color: var(--text-light);">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label" style="color: var(--text-light);">Category</label>
                                <select class="form-select" id="editMenuCategory" style="background: var(--dark-bg); border: 1px solid var(--border-color); color: var(--text-light);">
                                    <option value="">Select Category</option>
                                    <option value="Food">Food</option>
                                    <option value="Drinks">Drinks</option>
                                    <option value="Dessert">Dessert</option>
                                    <option value="Appetizer">Appetizer</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label" style="color: var(--text-light);">Price (VNĐ) *</label>
                                <input type="number" class="form-control" id="editMenuPrice" min="0" required style="background: var(--dark-bg); border: 1px solid var(--border-color); color: var(--text-light);">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label" style="color: var(--text-light);">Status</label>
                                <select class="form-select" id="editMenuStatus" style="background: var(--dark-bg); border: 1px solid var(--border-color); color: var(--text-light);">
                                    <option value="available">Published</option>
                                    <option value="unavailable">Draft</option>
                                </select>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" style="color: var(--text-light);">Description</label>
                            <textarea class="form-control" id="editMenuDescription" rows="3" style="background: var(--dark-bg); border: 1px solid var(--border-color); color: var(--text-light);"></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" style="color: var(--text-light);">Change Image</label>
                            <input type="file" class="form-control" id="editMenuImage" accept="image/*" style="background: var(--dark-bg); border: 1px solid var(--border-color); color: var(--text-light);">
                            <small class="text-muted">Leave empty to keep current image. Upload to Cloudinary.</small>
                        </div>
                    </form>
                </div>
                <div class="modal-footer" style="border-top: 1px solid var(--border-color);">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="action-btn" onclick="updateMenuItem()">Update Menu</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Upload Image Modal -->
    <div class="modal fade" id="uploadImageModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content" style="background: var(--card-bg); border: 1px solid var(--border-color);">
                <div class="modal-header" style="border-bottom: 1px solid var(--border-color);">
                    <h5 class="modal-title" style="color: var(--text-light);">Upload Menu Image</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" style="filter: invert(1);"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="uploadItemId">
                    <div class="mb-3">
                        <label class="form-label" style="color: var(--text-light);">Select Image</label>
                        <input type="file" class="form-control" id="uploadImageFile" accept="image/*" required style="background: var(--dark-bg); border: 1px solid var(--border-color); color: var(--text-light);">
                    </div>
                    <div id="uploadImagePreview" class="text-center mb-3">
                        <!-- Image preview will appear here -->
                    </div>
                </div>
                <div class="modal-footer" style="border-top: 1px solid var(--border-color);">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="action-btn" onclick="uploadImage()">Upload Image</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Order Detail Modal -->
    <div class="modal fade" id="orderDetailModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content" style="background: var(--card-bg); border: 1px solid var(--border-color);">
                <div class="modal-header" style="border-bottom: 1px solid var(--border-color);">
                    <h5 class="modal-title" style="color: var(--text-light);">Order Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" style="filter: invert(1);"></button>
                </div>
                <div class="modal-body" style="color: var(--text-light);">
                    <div id="orderDetailContent">
                        <!-- Order details will be loaded here -->
                    </div>
                </div>
                <div class="modal-footer" style="border-top: 1px solid var(--border-color);">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <div id="statusUpdateButtons">
                        <!-- Status buttons will be dynamically added here -->
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bulk Actions Modal -->
    <div class="modal fade" id="bulkActionsModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content" style="background: var(--card-bg); border: 1px solid var(--border-color);">
                <div class="modal-header" style="border-bottom: 1px solid var(--border-color);">
                    <h5 class="modal-title" style="color: var(--text-light);">Bulk Actions</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" style="filter: invert(1);"></button>
                </div>
                <div class="modal-body" style="color: var(--text-light);">
                    <p>Selected <span id="selectedOrdersCount">0</span> orders</p>
                    <div class="mb-3">
                        <label class="form-label">Action:</label>
                        <select class="form-select" id="bulkActionSelect" style="background: var(--dark-bg); border: 1px solid var(--border-color); color: var(--text-light);">
                            <option value="">Select Action</option>
                            <option value="preparing">Mark as Preparing</option>
                            <option value="completed">Mark as Completed</option>
                            <option value="delete">Delete Orders</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer" style="border-top: 1px solid var(--border-color);">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="action-btn" onclick="executeBulkAction()">Execute Action</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Reset Stats Confirmation Modal -->
    <div class="modal fade" id="resetStatsModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content" style="background: var(--card-bg); border: 1px solid var(--border-color);">
                <div class="modal-header" style="border-bottom: 1px solid var(--border-color);">
                    <h5 class="modal-title" style="color: var(--danger-color);">
                        <i class="bi bi-exclamation-triangle"></i> Reset All Data
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" style="filter: invert(1);"></button>
                </div>
                <div class="modal-body" style="color: var(--text-light);">
                    <div class="alert alert-danger" style="background: rgba(220, 53, 69, 0.1); border: 1px solid var(--danger-color); color: var(--danger-color);">
                        <i class="bi bi-exclamation-circle me-2"></i>
                        <strong>Cảnh báo!</strong> Hành động này không thể hoàn tác.
                    </div>
                    <p><strong>Bạn có chắc chắn muốn xóa tất cả dữ liệu không?</strong></p>
                    <p>Dữ liệu sẽ bị xóa bao gồm:</p>
                    <ul>
                        <li>✗ Tất cả đơn hàng (Orders)</li>
                        <li>✗ Chi tiết món ăn trong đơn (Order Items)</li>
                        <li>✗ Lịch sử giao dịch</li>
                        <li>✗ Thống kê doanh thu</li>
                    </ul>
                    <p style="color: var(--warning-color);">
                        <i class="bi bi-info-circle"></i>
                        <strong>Lưu ý:</strong> Menu và danh sách món ăn sẽ được giữ nguyên.
                    </p>
                </div>
                <div class="modal-footer" style="border-top: 1px solid var(--border-color);">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy bỏ</button>
                    <button type="button" class="btn btn-danger" onclick="executeResetStats()">
                        <i class="bi bi-trash3"></i> Xác nhận xóa
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Auto-refresh Indicator -->
    <div class="auto-refresh-indicator" id="autoRefreshIndicator">
        <i class="bi bi-arrow-clockwise refresh-icon"></i>
        <span>Auto-refreshing...</span>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Sidebar Toggle
        const sidebarToggle = document.getElementById('sidebarToggle');
        const sidebar = document.getElementById('sidebar');
        const mainContent = document.getElementById('mainContent');

        sidebarToggle.addEventListener('click', () => {
            sidebar.classList.toggle('collapsed');
            mainContent.classList.toggle('expanded');
        });

        // Menu Management Variables
        let menuItems = [];
        let filteredMenuItems = [];

        // Page Navigation Functions
        function showDashboardPage() {
            document.getElementById('dashboardPage').style.display = 'block';
            document.getElementById('addMenuPage').style.display = 'none';
            document.getElementById('menuListPage').style.display = 'none';
            document.getElementById('ordersPage').style.display = 'none';
            updateNavActive('dashboard');
            
            // Load stats when showing dashboard
            loadStatsFromAPI();
            
            // Load recent activity
            loadRecentActivity();
        }

        function showAddMenuPage() {
            document.getElementById('dashboardPage').style.display = 'none';
            document.getElementById('addMenuPage').style.display = 'block';
            document.getElementById('menuListPage').style.display = 'none';
            document.getElementById('ordersPage').style.display = 'none';
            updateNavActive('addMenu');
            clearAddMenuForm();
        }

        function showMenuListPage() {
            document.getElementById('dashboardPage').style.display = 'none';
            document.getElementById('addMenuPage').style.display = 'none';
            document.getElementById('menuListPage').style.display = 'block';
            document.getElementById('ordersPage').style.display = 'none';
            updateNavActive('menuList');
            loadMenuItems();
        }

        function showOrdersPage() {
            console.log('showOrdersPage() called');
            
            // Hide all pages
            document.getElementById('dashboardPage').style.display = 'none';
            document.getElementById('addMenuPage').style.display = 'none';
            document.getElementById('menuListPage').style.display = 'none';
            
            // Show orders page
            const ordersPage = document.getElementById('ordersPage');
            ordersPage.style.display = 'block';
            console.log('Orders page should be visible now');
            
            // Show card view instead of table
            const tableContainer = ordersPage.querySelector('.table-responsive');
            const cardContainer = document.getElementById('ordersContainer');
            if (tableContainer) tableContainer.style.display = 'none';
            if (cardContainer) cardContainer.style.display = 'block';
            
            // Update navigation
            updateNavActive('orders');
            
            // Force load orders data immediately
            console.log('Loading orders data...');
            setTimeout(() => {
                loadOrdersFromAPI();
                loadStatsFromAPI();
                if (!autoRefreshInterval) {
                    startAutoRefresh();
                }
            }, 100);
        }

        function updateNavActive(page) {
            // Remove active class from all nav links
            document.querySelectorAll('.nav-link').forEach(link => {
                link.classList.remove('active');
            });
            
            // Add active to specific page nav link based on page parameter
            if (page === 'dashboard') {
                document.querySelector('a[href="#"]:has(.bi-grid-1x2)').classList.add('active');
            } else if (page === 'addMenu') {
                document.querySelector('a[onclick="showAddMenuPage()"]').classList.add('active');
            } else if (page === 'menuList') {
                document.querySelector('a[onclick="showMenuListPage()"]').classList.add('active');
            } else if (page === 'orders') {
                document.querySelector('a[onclick="showOrdersPage()"]').classList.add('active');
            }
        }

        // Load menu items from API
        async function loadMenuItems() {
            try {
                const response = await fetch('index.php?controller=restaurant&action=getMenuItems');
                const data = await response.json();
                
                if (data.success) {
                    menuItems = data.menuItems;
                    filteredMenuItems = [...menuItems];
                    updateMenuStats();
                    renderMenuTable();
                } else {
                    showNotification('error', 'Cannot load menu items');
                }
            } catch (error) {
                console.error('Load menu error:', error);
                showNotification('error', 'Connection error: ' + error.message);
            }
        }

        // Update menu statistics
        function updateMenuStats() {
            const total = menuItems.length;
            const published = menuItems.filter(item => item.status === 'available').length;
            const draft = menuItems.filter(item => item.status === 'unavailable').length;
            const withImages = menuItems.filter(item => item.image && item.image !== '').length;
            
            document.getElementById('totalMenuItems').textContent = total;
            document.getElementById('publishedMenuItems').textContent = published;
            document.getElementById('draftMenuItems').textContent = draft;
            document.getElementById('menuItemsWithImages').textContent = withImages;
        }

        // Search menu items
        function searchMenuItems() {
            const searchTerm = document.getElementById('searchInput').value.toLowerCase();
            const statusFilter = document.getElementById('statusFilter').value;
            
            filteredMenuItems = menuItems.filter(item => {
                const matchesSearch = item.name.toLowerCase().includes(searchTerm) || 
                                    (item.description && item.description.toLowerCase().includes(searchTerm));
                const matchesStatus = !statusFilter || item.status === statusFilter;
                return matchesSearch && matchesStatus;
            });
            
            renderMenuTable();
        }

        // Filter menu items by status
        function filterMenuItems() {
            searchMenuItems(); // Reuse search function which includes status filter
        }

        // Render menu table
        function renderMenuTable() {
            const tbody = document.getElementById('menuTableBody');
            const itemsToShow = filteredMenuItems.length > 0 ? filteredMenuItems : menuItems;
            
            if (itemsToShow.length === 0) {
                tbody.innerHTML = '<tr><td colspan="6" class="text-center" style="color: var(--text-muted);">No menu items found</td></tr>';
                return;
            }
            
            let html = '';
            itemsToShow.forEach(item => {
                // Handle image source - dùng trực tiếp từ database (Cloudinary URL)
                let imageSrc = null;
                if (item.image && item.image !== '') {
                    if (item.image.includes('cloudinary.com') || item.image.includes('http')) {
                        // Full Cloudinary URL - dùng trực tiếp
                        imageSrc = item.image;
                    } else if (item.image.startsWith('restaurant/menu/') || item.image.startsWith('menu_item_')) {
                        // Cloudinary public_id - tạo URL với thumbnail size
                        imageSrc = `https://res.cloudinary.com/dx9ngssmo/image/upload/c_fill,w_60,h_60,f_auto,q_auto/${item.image}`;
                    } else {
                        // Local path fallback (nếu còn data cũ)
                        imageSrc = `assets/${item.image}`;
                    }
                }
                
                const statusBadge = item.status === 'available' 
                    ? '<span class="badge bg-success">Published</span>'
                    : '<span class="badge bg-warning">Draft</span>';
                
                const category = item.category || 'Food/Noodle';
                
                html += `
                    <tr class="menu-item-row" style="border-bottom: 1px solid var(--border-color);">
                        <td>
                            <div class="menu-image-container" style="width: 60px; height: 60px; border-radius: 8px; overflow: hidden; background: var(--card-bg); border: 1px solid var(--border-color); display: flex; align-items: center; justify-content: center; cursor: pointer;" onclick="openUploadModal(${item.id}, '${item.name}')">
                                ${imageSrc ? 
                                    `<img src="${imageSrc}" alt="${item.name}" style="width: 100%; height: 100%; object-fit: cover;" 
                                         onerror="this.style.display='none'; this.parentElement.innerHTML='<i class=\\"bi bi-camera text-muted\\"></i>'; handleBrokenImage(${item.id});">` :
                                    '<i class="bi bi-camera text-muted"></i>'
                                }
                            </div>
                        </td>
                        <td>
                            <div>
                                <strong class="menu-item-name">${item.name}</strong>
                                <br>
                                <small class="menu-item-desc text-muted">${item.description ? item.description.substring(0, 50) + '...' : 'No description'}</small>
                            </div>
                        </td>
                        <td class="menu-item-category">${category}</td>
                        <td><strong class="menu-item-price">${parseInt(item.price).toLocaleString()}đ</strong></td>
                        <td>${statusBadge}</td>
                        <td>
                            <div class="btn-group">
                                <button class="btn btn-outline-secondary btn-sm" onclick="viewMenuItem(${item.id})" title="View">
                                    <i class="bi bi-eye"></i>
                                </button>
                                <button class="btn btn-outline-primary btn-sm" onclick="openEditModal(${item.id})" title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </button>
                                <button class="btn btn-outline-danger btn-sm" onclick="deleteMenuItem(${item.id}, '${item.name}')" title="Delete">
                                    <i class="bi bi-trash"></i>
                                </button>
                                <button class="btn btn-outline-success btn-sm" onclick="duplicateMenuItem(${item.id})" title="Duplicate">
                                    <i class="bi bi-copy"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                `;
            });
            
            tbody.innerHTML = html;
        }

        // Clear add menu form
        function clearAddMenuForm() {
            document.getElementById('addMenuForm').reset();
            document.getElementById('imagePreview').innerHTML = `
                <div class="placeholder">
                    <i class="bi bi-camera" style="font-size: 3rem; color: var(--text-muted);"></i>
                    <p class="text-muted mt-2">Click to upload image</p>
                </div>
            `;
        }

        // Add new menu item
        async function addMenuItem() {
            const name = document.getElementById('menuName').value.trim();
            const category = document.getElementById('menuCategory').value;
            const description = document.getElementById('menuDescription').value.trim();
            const price = parseInt(document.getElementById('menuPrice').value);
            const discount = parseInt(document.getElementById('menuDiscount').value) || 0;
            const status = document.getElementById('menuStatus').value;
            const ingredients = document.getElementById('menuIngredients').value.trim();
            const metaTitle = document.getElementById('metaTitle').value.trim();
            const metaKeyword = document.getElementById('metaKeyword').value.trim();
            const imageFile = document.getElementById('menuImage').files[0];
            
            if (!name || !price) {
                showNotification('warning', 'Please fill in all required fields');
                return;
            }
            
            try {
                const submitBtn = document.querySelector('#addMenuPage .action-btn');
                const originalText = submitBtn.innerHTML;
                submitBtn.innerHTML = '<i class="spinner-border spinner-border-sm me-2"></i>Adding...';
                submitBtn.disabled = true;
                
                // Prepare description with additional fields
                let fullDescription = description;
                if (ingredients) fullDescription += `\nIngredients: ${ingredients}`;
                if (metaTitle) fullDescription += `\nMeta Title: ${metaTitle}`;
                if (metaKeyword) fullDescription += `\nMeta Keywords: ${metaKeyword}`;
                
                const response = await fetch('index.php?controller=admin&action=addMenuItem', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        name: name,
                        description: fullDescription,
                        price: price,
                        category: category
                    })
                });
                
                const result = await response.json();
                
                if (result.success) {
                    console.log('Menu item added successfully:', result);
                    
                    // If there's an image, upload it
                    if (imageFile) {
                        console.log('Image file found, uploading to Cloudinary...');
                        await loadMenuItems();
                        const newItem = menuItems.find(item => item.name === name);
                        console.log('Found new item:', newItem);
                        
                        if (newItem) {
                            console.log('Uploading image for item ID:', newItem.id);
                            await uploadImageForNewItem(newItem.id, imageFile);
                            await loadMenuItems();
                        } else {
                            console.error('Could not find newly created menu item');
                        }
                    } else {
                        console.log('No image file selected');
                    }
                    
                    showNotification('success', result.message);
                    clearAddMenuForm();
                    
                    if (!imageFile) {
                        loadMenuItems();
                    }
                } else {
                    showNotification('error', result.message);
                }
                
                submitBtn.innerHTML = originalText;
                submitBtn.disabled = false;
                
            } catch (error) {
                console.error('Add menu error:', error);
                showNotification('error', 'Connection error: ' + error.message);
                
                const submitBtn = document.querySelector('#addMenuPage .action-btn');
                submitBtn.innerHTML = '<i class="bi bi-check-circle"></i> Save / Add';
                submitBtn.disabled = false;
            }
        }

        // Upload image for newly added item
        async function uploadImageForNewItem(itemId, imageFile) {
            console.log('uploadImageForNewItem called with:', { itemId, imageFile });
            
            const formData = new FormData();
            formData.append('itemId', itemId);
            formData.append('imageFile', imageFile);
            
            console.log('FormData prepared, sending request to Cloudinary API...');
            
            try {
                // Upload to Cloudinary instead of local storage
                const response = await fetch('index.php?controller=admin&action=uploadImageCloudinary', {
                    method: 'POST',
                    body: formData
                });
                
                console.log('Response received:', response);
                const result = await response.json();
                console.log('Response data:', result);
                
                if (result.success) {
                    console.log('Image uploaded to Cloudinary successfully:', result.imageUrl);
                    showNotification('success', 'Ảnh đã được upload lên Cloudinary thành công!');
                } else {
                    console.warn('Cloudinary upload failed:', result.message);
                    showNotification('warning', 'Menu item added but Cloudinary upload failed: ' + result.message);
                }
            } catch (error) {
                console.error('Cloudinary upload error:', error);
                showNotification('warning', 'Menu item added but Cloudinary upload error occurred');
            }
        }

        // View menu item
        function viewMenuItem(itemId) {
            const item = menuItems.find(i => i.id == itemId);
            if (!item) return;
            
            showNotification('info', `Viewing: ${item.name} - ${parseInt(item.price).toLocaleString()}đ`);
        }

        // Open edit modal
        function openEditModal(itemId) {
            const item = menuItems.find(i => i.id == itemId);
            if (!item) return;
            
            document.getElementById('editMenuId').value = item.id;
            document.getElementById('editMenuName').value = item.name;
            document.getElementById('editMenuCategory').value = item.category || '';
            document.getElementById('editMenuDescription').value = item.description || '';
            document.getElementById('editMenuPrice').value = item.price;
            document.getElementById('editMenuStatus').value = item.status;
            
            new bootstrap.Modal(document.getElementById('editMenuModal')).show();
        }

        // Update menu item
        async function updateMenuItem() {
            const id = document.getElementById('editMenuId').value;
            const name = document.getElementById('editMenuName').value.trim();
            const category = document.getElementById('editMenuCategory').value;
            const description = document.getElementById('editMenuDescription').value.trim();
            const price = parseInt(document.getElementById('editMenuPrice').value);
            const status = document.getElementById('editMenuStatus').value;
            const imageFile = document.getElementById('editMenuImage') ? document.getElementById('editMenuImage').files[0] : null;
            
            if (!name || !price) {
                showNotification('warning', 'Please fill in all required fields');
                return;
            }
            
            try {
                const submitBtn = document.querySelector('#editMenuModal .action-btn');
                const originalText = submitBtn.innerHTML;
                submitBtn.innerHTML = '<i class="spinner-border spinner-border-sm me-2"></i>Updating...';
                submitBtn.disabled = true;

                // Get original item data for comparison
                const originalItem = menuItems.find(i => i.id == id);
                let hasTextChanges = false;
                
                if (originalItem) {
                    hasTextChanges = (
                        originalItem.name !== name ||
                        (originalItem.description || '') !== description ||
                        parseInt(originalItem.price) !== price ||
                        originalItem.status !== status
                    );
                }

                // Only call update API if there are actual text changes
                if (hasTextChanges) {
                    const response = await fetch('index.php?controller=admin&action=updateMenuItem', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({
                            id: id,
                            name: name,
                            description: description,
                            price: price,
                            status: status
                        })
                    });
                    
                    const result = await response.json();
                    if (!result.success) {
                        throw new Error(result.message);
                    }
                }

                // Handle image upload if there's a new image
                if (imageFile) {
                    console.log('Image file selected, uploading to Cloudinary...');
                    try {
                        await uploadImageForMenuItem(id, imageFile);
                        showNotification('success', hasTextChanges ? 'Menu item and image updated successfully!' : 'Image updated successfully!');
                    } catch (imageError) {
                        console.error('Image upload error:', imageError);
                        if (hasTextChanges) {
                            showNotification('warning', 'Menu updated but image upload failed: ' + imageError.message);
                        } else {
                            showNotification('error', 'Image upload failed: ' + imageError.message);
                            return; // Don't close modal on image-only failure
                        }
                    }
                } else if (hasTextChanges) {
                    showNotification('success', 'Menu item updated successfully!');
                } else {
                    showNotification('info', 'No changes detected');
                }

                // Close modal and refresh
                bootstrap.Modal.getInstance(document.getElementById('editMenuModal')).hide();
                loadMenuItems();
                
                // Reset form and button
                submitBtn.innerHTML = originalText;
                submitBtn.disabled = false;
                
            } catch (error) {
                console.error('Update menu error:', error);
                showNotification('error', 'Connection error: ' + error.message);
                
                const submitBtn = document.querySelector('#editMenuModal .action-btn');
                submitBtn.innerHTML = 'Update Menu';
                submitBtn.disabled = false;
            }
        }
        
        // Upload image for existing menu item
        async function uploadImageForMenuItem(itemId, imageFile) {
            console.log('uploadImageForMenuItem called with:', itemId, imageFile.name);
            
            const formData = new FormData();
            formData.append('itemId', itemId);
            formData.append('imageFile', imageFile);
            
            console.log('FormData prepared for itemId:', itemId);
            
            try {
                const response = await fetch('index.php?controller=admin&action=uploadImageCloudinary', {
                    method: 'POST',
                    body: formData
                });
                
                console.log('Response status:', response.status);
                const result = await response.json();
                console.log('Response result:', result);
                
                if (result.success) {
                    console.log('Image updated on Cloudinary successfully:', result.imageUrl);
                    showNotification('success', 'Ảnh đã được cập nhật lên Cloudinary thành công!');
                } else {
                    console.warn('Cloudinary upload failed:', result.message);
                    showNotification('warning', 'Menu updated but Cloudinary upload failed: ' + result.message);
                    throw new Error(result.message);
                }
            } catch (error) {
                console.error('Cloudinary upload error:', error);
                showNotification('error', 'Image upload error: ' + error.message);
                throw error;
            }
        }

        // Delete menu item
        async function deleteMenuItem(itemId, itemName) {
            if (!confirm(`Are you sure you want to delete "${itemName}"?\nThis action cannot be undone.`)) {
                return;
            }
            
            try {
                const response = await fetch('index.php?controller=admin&action=deleteMenuItem', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        id: itemId
                    })
                });
                
                const result = await response.json();
                
                if (result.success) {
                    showNotification('success', result.message);
                    loadMenuItems();
                } else {
                    showNotification('error', result.message);
                }
            } catch (error) {
                console.error('Delete error:', error);
                showNotification('error', 'Connection error: ' + error.message);
            }
        }

        // Duplicate menu item
        async function duplicateMenuItem(itemId) {
            const item = menuItems.find(i => i.id == itemId);
            if (!item) return;
            
            if (!confirm(`Duplicate "${item.name}"?`)) {
                return;
            }
            
            try {
                const response = await fetch('index.php?controller=admin&action=addMenuItem', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        name: item.name + ' (Copy)',
                        description: item.description,
                        price: item.price
                    })
                });
                
                const result = await response.json();
                
                if (result.success) {
                    showNotification('success', 'Menu item duplicated successfully!');
                    loadMenuItems();
                } else {
                    showNotification('error', result.message);
                }
            } catch (error) {
                console.error('Duplicate error:', error);
                showNotification('error', 'Connection error: ' + error.message);
            }
        }

        // Upload image modal functions
        function openUploadModal(itemId, itemName) {
            document.getElementById('uploadItemId').value = itemId;
            document.querySelector('#uploadImageModal .modal-title').textContent = `Upload Image: ${itemName}`;
            
            new bootstrap.Modal(document.getElementById('uploadImageModal')).show();
        }

        async function uploadImage() {
            const itemId = document.getElementById('uploadItemId').value;
            const imageFile = document.getElementById('uploadImageFile').files[0];
            
            if (!imageFile) {
                showNotification('warning', 'Please select an image file');
                return;
            }
            
            const formData = new FormData();
            formData.append('itemId', itemId);
            formData.append('imageFile', imageFile);
            
            try {
                const submitBtn = document.querySelector('#uploadImageModal .action-btn');
                
                // Debug check
                if (!submitBtn) {
                    console.error('Submit button not found!');
                    showNotification('error', 'Submit button not found');
                    return;
                }
                
                const originalText = submitBtn.innerHTML;
                submitBtn.innerHTML = '<i class="spinner-border spinner-border-sm me-2"></i>Uploading to Cloudinary...';
                submitBtn.disabled = true;
                
                console.log('Uploading with itemId:', itemId);
                console.log('FormData prepared:', formData);
                
                // Upload to Cloudinary instead of local storage
                const response = await fetch('index.php?controller=admin&action=uploadImageCloudinary', {
                    method: 'POST',
                    body: formData
                });
                
                console.log('Response status:', response.status);
                const result = await response.json();
                console.log('Response result:', result);
                
                if (result.success) {
                    showNotification('success', 'Image uploaded to Cloudinary successfully!');
                    bootstrap.Modal.getInstance(document.getElementById('uploadImageModal')).hide();
                    document.getElementById('uploadImageFile').value = '';
                    document.getElementById('uploadImagePreview').innerHTML = '';
                    loadMenuItems();
                } else {
                    showNotification('error', result.message);
                }
                
                submitBtn.innerHTML = originalText;
                submitBtn.disabled = false;
                
            } catch (error) {
                console.error('Upload error:', error);
                showNotification('error', 'Connection error: ' + error.message);
                
                const submitBtn = document.querySelector('#uploadImageModal .action-btn');
                submitBtn.innerHTML = 'Upload Image';
                submitBtn.disabled = false;
            }
        }

        // Show notification
        function showNotification(type, message) {
            const alertType = type === 'error' ? 'danger' : type;
            const alertHtml = `
                <div class="alert alert-${alertType} alert-dismissible fade show" role="alert" style="position: fixed; top: 20px; right: 20px; z-index: 9999; min-width: 300px; background: var(--card-bg); border: 1px solid var(--border-color); color: var(--text-light);">
                    ${message}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" style="filter: invert(1);"></button>
                </div>
            `;
            
            document.body.insertAdjacentHTML('beforeend', alertHtml);
            
            // Auto dismiss after 5 seconds
            setTimeout(() => {
                const alerts = document.querySelectorAll('.alert');
                if (alerts.length > 0) {
                    bootstrap.Alert.getOrCreateInstance(alerts[alerts.length - 1]).close();
                }
            }, 5000);
        }

        // Initialize Charts
        function initCharts() {
            // Revenue Chart
            const revenueCtx = document.getElementById('revenueChart').getContext('2d');
            new Chart(revenueCtx, {
                type: 'line',
                data: {
                    labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
                    datasets: [{
                        label: 'Revenue',
                        data: [120, 150, 180, 220, 170, 190, 210],
                        borderColor: '#6366f1',
                        backgroundColor: 'rgba(99, 102, 241, 0.1)',
                        borderWidth: 3,
                        fill: true,
                        tension: 0.4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        x: {
                            grid: {
                                color: '#334155'
                            },
                            ticks: {
                                color: '#64748b'
                            }
                        },
                        y: {
                            grid: {
                                color: '#334155'
                            },
                            ticks: {
                                color: '#64748b'
                            }
                        }
                    }
                }
            });
        }

        // Load Dashboard Data
        function loadDashboardData() {
            // Simulate loading real data
            fetch('./index.php?controller=order&action=getStats')
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        updateStats(data.stats);
                    }
                })
                .catch(error => {
                    console.error('Error loading stats:', error);
                    // Use dummy data if API fails
                    updateStats({
                        pending_orders: 89,
                        preparing_orders: 45,
                        completed_orders: 899,
                        total_revenue: 789000
                    });
                });

            loadCurrentOrders();
        }

        function updateStats(stats) {
            document.getElementById('pendingCount').textContent = stats.pending_orders || 0;
            document.getElementById('deliveredCount').textContent = stats.completed_orders || 0;
            document.getElementById('canceledCount').textContent = stats.canceled_orders || 0;
            document.getElementById('revenueToday').textContent = '$' + ((stats.total_revenue || 0) / 1000).toFixed(0) + 'k';
            
            // Update sidebar badge
            document.getElementById('pendingOrdersBadge').textContent = stats.pending_orders || 0;
        }

        function loadCurrentOrders() {
            fetch('./index.php?controller=order&action=getAllOrders')
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        displayOrders(data.orders);
                    }
                })
                .catch(error => {
                    console.error('Error loading orders:', error);
                    // Show dummy orders if API fails
                    displayDummyOrders();
                });
        }

        function displayOrders(orders) {
            const container = document.getElementById('currentOrders');
            
            if (orders.length === 0) {
                container.innerHTML = `
                    <div class="text-center py-5">
                        <i class="bi bi-inbox" style="font-size: 3rem; color: var(--text-muted);"></i>
                        <p class="text-muted mt-3">No current orders</p>
                    </div>
                `;
                return;
            }

            let html = '';
            orders.slice(0, 5).forEach(order => { // Show only first 5 orders
                const statusClass = getStatusClass(order.status);
                const statusText = getStatusText(order.status);
                
                html += `
                    <div class="order-item">
                        <div class="order-info">
                            <div class="order-id">#${order.order_code}</div>
                            <div class="order-details">Table ${order.table_number} • ${order.items.length} items</div>
                        </div>
                        <div class="order-status ${statusClass}">${statusText}</div>
                        <div class="order-amount">${parseInt(order.final_total).toLocaleString()}đ</div>
                    </div>
                `;
            });
            
            container.innerHTML = html;
        }

        function displayDummyOrders() {
            const container = document.getElementById('currentOrders');
            container.innerHTML = `
                <div class="order-item">
                    <div class="order-info">
                        <div class="order-id">#ORD-001</div>
                        <div class="order-details">Table 5 • 3 items</div>
                    </div>
                    <div class="order-status status-pending">Pending</div>
                    <div class="order-amount">$24.50</div>
                </div>
                <div class="order-item">
                    <div class="order-info">
                        <div class="order-id">#ORD-002</div>
                        <div class="order-details">Table 2 • 2 items</div>
                    </div>
                    <div class="order-status status-preparing">Preparing</div>
                    <div class="order-amount">$18.00</div>
                </div>
                <div class="order-item">
                    <div class="order-info">
                        <div class="order-id">#ORD-003</div>
                        <div class="order-details">Table 8 • 4 items</div>
                    </div>
                    <div class="order-status status-completed">Completed</div>
                    <div class="order-amount">$32.75</div>
                </div>
            `;
        }

        function getStatusClass(status) {
            switch(status) {
                case 'pending': return 'status-pending';
                case 'preparing': return 'status-preparing';
                case 'completed': return 'status-completed';
                default: return 'status-pending';
            }
        }

        function getStatusText(status) {
            switch(status) {
                case 'pending': return 'Pending';
                case 'preparing': return 'Preparing';
                case 'completed': return 'Completed';
                default: return 'Unknown';
            }
        }

        // Quick Action Functions
        function refreshDashboard() {
            document.getElementById('autoRefreshIndicator').style.display = 'flex';
            setTimeout(() => {
                loadDashboardData();
                document.getElementById('autoRefreshIndicator').style.display = 'none';
            }, 1000);
        }

        function viewAllOrders() {
            // Navigate to orders page
            window.location.href = './index.php?controller=admin&action=dashboard';
        }

        function addNewItem() {
            // Navigate to add menu page
            showAddMenuPage();
        }

        // Image preview handlers
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize charts and load data
            initCharts();
            loadDashboardData();

            // Image preview for add form
            document.getElementById('menuImage').addEventListener('change', function(e) {
                const file = e.target.files[0];
                const preview = document.getElementById('imagePreview');
                
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        preview.innerHTML = `<img src="${e.target.result}" style="width: 100%; height: 100%; object-fit: cover; border-radius: 8px;">`;
                    };
                    reader.readAsDataURL(file);
                } else {
                    preview.innerHTML = `
                        <div class="placeholder">
                            <i class="bi bi-camera" style="font-size: 3rem; color: var(--text-muted);"></i>
                            <p class="text-muted mt-2">Click to upload image</p>
                        </div>
                    `;
                }
            });

            // Upload modal image preview
            document.getElementById('uploadImageFile').addEventListener('change', function(e) {
                const file = e.target.files[0];
                const preview = document.getElementById('uploadImagePreview');
                
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        preview.innerHTML = `<img src="${e.target.result}" class="img-fluid rounded" style="max-height: 200px;">`;
                    };
                    reader.readAsDataURL(file);
                } else {
                    preview.innerHTML = '';
                }
            });
        });

        // Auto-refresh every 30 seconds
        setInterval(() => {
            if (document.getElementById('dashboardPage').style.display !== 'none') {
                loadDashboardData();
            }
        }, 30000);

        // Mobile responsiveness
        window.addEventListener('resize', () => {
            if (window.innerWidth <= 768) {
                sidebar.classList.add('collapsed');
                mainContent.classList.add('expanded');
            }
        });
    </script>

    <script>
        // Order management variables
        let ordersData = [];
        let selectedOrders = new Set();
        let isBulkSelectMode = false;
        let autoRefreshInterval = null;
        let lastUpdateTime = Math.floor(Date.now() / 1000);
        let isSoundEnabled = localStorage.getItem('soundEnabled') !== 'false';
        let currentOrderId = null;

        // Load orders from API
        function loadOrdersFromAPI() {
            console.log('loadOrdersFromAPI() called');
            const endpoint = './index.php?controller=order&action=getAllOrders';
                
            fetch(endpoint)
                .then(response => {
                    console.log('API response status:', response.status);
                    return response.json();
                })
                .then(data => {
                    console.log('API response data:', data);
                    if (data.success) {
                        console.log('Orders received:', data.orders.length);
                        displayOrders(data.orders);
                        ordersData = data.orders;
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

        // Display orders in the orders page
        function displayOrders(orders) {
            console.log('displayOrders() called with', orders.length, 'orders');
            const container = document.getElementById('ordersContainer');
            
            if (!container) {
                console.error('ordersContainer not found!');
                return; // Orders page not active
            }
            
            console.log('ordersContainer found, displaying orders...');
            
            if (orders.length === 0) {
                container.innerHTML = `
                    <div class="text-center py-5" style="color: var(--text-muted);">
                        <i class="bi bi-inbox fs-1 mb-3"></i>
                        <p>Chưa có đơn hàng nào</p>
                        <button class="btn btn-outline-primary" onclick="loadOrdersFromAPI()">
                            <i class="bi bi-arrow-clockwise"></i> Refresh
                        </button>
                    </div>
                `;
                return;
            }
            
            let html = '';
            orders.forEach(order => {
                console.log('Processing order:', order.order_code);
                const statusClass = getStatusClass(order.status);
                const statusText = getStatusText(order.status);
                const orderTime = new Date(order.created_at).toLocaleString('vi-VN');
                const isSelected = selectedOrders.has(order.id);
                
                html += `
                    <div class="order-card mb-3 p-4 border rounded ${isSelected ? 'selected' : ''}" 
                         data-status="${order.status}" data-order-id="${order.id}"
                         style="background: var(--card-bg); border-color: var(--border-color) !important; color: var(--text-light);">
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
                                <div class="fw-bold" style="color: var(--primary-color);">${order.order_code}</div>
                                <small style="color: var(--text-muted);">Bàn ${order.table_number}</small>
                            </div>
                            <div class="col-md-3">
                                <div class="fw-semibold">${order.items ? order.items.length : 0} món</div>
                                <small style="color: var(--text-muted);">${orderTime}</small>
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
            console.log('Orders HTML rendered, total HTML length:', html.length);
        }

        // Get status CSS class
        function getStatusClass(status) {
            switch (status) {
                case 'pending': return 'bg-warning text-dark';
                case 'preparing': return 'bg-info text-dark';
                case 'completed': return 'bg-success text-white';
                default: return 'bg-secondary text-white';
            }
        }

        // Get status text in Vietnamese
        function getStatusText(status) {
            switch (status) {
                case 'pending': return 'Chờ xử lý';
                case 'preparing': return 'Đang làm';
                case 'completed': return 'Hoàn thành';
                default: return 'Không xác định';
            }
        }

        // View order detail
        function viewOrderDetail(orderId) {
            currentOrderId = orderId;
            
            fetch(`./index.php?controller=order&action=getOrderDetail&orderId=${orderId}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        displayOrderDetail(data.order);
                        const modal = new bootstrap.Modal(document.getElementById('orderDetailModal'));
                        modal.show();
                    } else {
                        showNotification('Lỗi tải chi tiết đơn hàng!', 'error');
                    }
                })
                .catch(error => {
                    console.error('Error loading order detail:', error);
                    showNotification('Lỗi tải chi tiết đơn hàng!', 'error');
                });
        }

        // Display order detail in modal
        function displayOrderDetail(order) {
            const content = document.getElementById('orderDetailContent');
            const statusClass = getStatusClass(order.status);
            const statusText = getStatusText(order.status);
            
            let itemsHtml = '';
            order.items.forEach(item => {
                itemsHtml += `
                    <tr>
                        <td style="color: var(--text-light);">${item.name}</td>
                        <td style="color: var(--text-light);">${item.quantity}</td>
                        <td style="color: var(--text-light);">${parseInt(item.price).toLocaleString()}đ</td>
                        <td style="color: var(--text-light);">${parseInt(item.quantity * item.price).toLocaleString()}đ</td>
                    </tr>
                `;
            });
            
            content.innerHTML = `
                <div class="row mb-3">
                    <div class="col-md-6">
                        <h6>Thông tin đơn hàng</h6>
                        <p><strong>Mã đơn:</strong> ${order.order_code}</p>
                        <p><strong>Bàn số:</strong> ${order.table_number}</p>
                        <p><strong>Thời gian:</strong> ${new Date(order.created_at).toLocaleString('vi-VN')}</p>
                        <p><strong>Trạng thái:</strong> <span class="badge ${statusClass}">${statusText}</span></p>
                    </div>
                    <div class="col-md-6">
                        <h6>Tổng tiền</h6>
                        <p><strong>Tạm tính:</strong> ${parseInt(order.subtotal).toLocaleString()}đ</p>
                        <p><strong>Thuế (10%):</strong> ${parseInt(order.tax_amount).toLocaleString()}đ</p>
                        <p><strong>Tổng cộng:</strong> <span class="text-danger fw-bold">${parseInt(order.final_total).toLocaleString()}đ</span></p>
                    </div>
                </div>
                <h6>Chi tiết món ăn</h6>
                <div class="table-responsive">
                    <table class="table table-dark">
                        <thead>
                            <tr>
                                <th>Món ăn</th>
                                <th>Số lượng</th>
                                <th>Đơn giá</th>
                                <th>Thành tiền</th>
                            </tr>
                        </thead>
                        <tbody>
                            ${itemsHtml}
                        </tbody>
                    </table>
                </div>
            `;
            
            // Update status buttons based on current order status
            const statusButtons = document.getElementById('statusUpdateButtons');
            let buttonsHtml = '';
            
            if (order.status === 'pending') {
                buttonsHtml = `
                    <button type="button" class="btn btn-warning me-2" onclick="updateOrderStatus(${order.id}, 'preparing')">
                        <i class="bi bi-gear"></i> Bắt đầu làm
                    </button>
                    <button type="button" class="btn btn-success" onclick="updateOrderStatus(${order.id}, 'completed')">
                        <i class="bi bi-check"></i> Hoàn thành luôn
                    </button>
                `;
            } else if (order.status === 'preparing') {
                buttonsHtml = `
                    <button type="button" class="btn btn-success" onclick="updateOrderStatus(${order.id}, 'completed')">
                        <i class="bi bi-check"></i> Hoàn thành
                    </button>
                    <button type="button" class="btn btn-outline-warning" onclick="updateOrderStatus(${order.id}, 'pending')">
                        <i class="bi bi-arrow-left"></i> Quay lại Pending
                    </button>
                `;
            } else if (order.status === 'completed') {
                buttonsHtml = `
                    <button type="button" class="btn btn-outline-warning" onclick="updateOrderStatus(${order.id}, 'preparing')">
                        <i class="bi bi-arrow-left"></i> Quay lại Preparing
                    </button>
                    <button type="button" class="btn btn-outline-secondary" onclick="updateOrderStatus(${order.id}, 'pending')">
                        <i class="bi bi-arrow-left-circle"></i> Quay lại Pending
                    </button>
                `;
            }
            
            statusButtons.innerHTML = buttonsHtml;
        }

        // Update order status
        function updateOrderStatus(orderId, newStatus) {
            console.log('updateOrderStatus called with:', { orderId, newStatus, currentOrderId });
            
            if (!orderId) orderId = currentOrderId;
            
            if (!orderId) {
                console.error('No orderId provided!');
                showNotification('Lỗi: Không có ID đơn hàng!', 'error');
                return;
            }
            
            const orderCard = document.querySelector(`[data-order-id="${orderId}"]`);
            if (orderCard) {
                orderCard.style.opacity = '0.6';
                orderCard.style.pointerEvents = 'none';
            }
            
            const requestData = {
                orderId: parseInt(orderId),
                status: newStatus
            };
            
            console.log('Sending update request:', requestData);
            
            fetch('./index.php?controller=order&action=updateStatus', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(requestData)
            })
            .then(response => {
                console.log('Response status:', response.status);
                return response.text();
            })
            .then(text => {
                console.log('Raw response:', text);
                let data;
                try {
                    data = JSON.parse(text);
                } catch (e) {
                    console.error('JSON parse error:', e);
                    throw new Error('Server returned invalid JSON: ' + text);
                }
                
                console.log('Parsed response:', data);
                
                // Restore visual state
                if (orderCard) {
                    orderCard.style.opacity = '1';
                    orderCard.style.pointerEvents = 'auto';
                }
                
                if (data.success) {
                    showNotification('Cập nhật trạng thái thành công!', 'success');
                    
                    // If order is completed and current filter is active, hide the card
                    const currentFilter = document.getElementById('orderStatusFilter').value;
                    if (newStatus === 'completed' && currentFilter === 'active') {
                        if (orderCard) {
                            orderCard.style.display = 'none';
                        }
                    } else {
                        loadOrdersFromAPI(); // Reload orders only if not hiding
                    }
                    
                    loadStatsFromAPI(); // Always reload stats
                    loadRecentActivity(); // Reload recent activity
                    
                    // Close modal if open
                    const modal = bootstrap.Modal.getInstance(document.getElementById('orderDetailModal'));
                    if (modal) {
                        modal.hide();
                    }
                } else {
                    console.error('API returned error:', data.message);
                    showNotification('Lỗi cập nhật trạng thái: ' + (data.message || 'Unknown error'), 'error');
                }
            })
            .catch(error => {
                console.error('Update status error:', error);
                showNotification('Lỗi kết nối: ' + error.message, 'error');
                
                if (orderCard) {
                    orderCard.style.opacity = '1';
                    orderCard.style.pointerEvents = 'auto';
                }
            });
        }

        // Confirm delete order
        function confirmDeleteOrder(orderId) {
            if (confirm('Bạn có chắc chắn muốn xóa đơn hàng này?')) {
                deleteOrder(orderId);
            }
        }

        // Delete order
        function deleteOrder(orderId) {
            fetch('./index.php?controller=order&action=deleteOrder', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    orderId: parseInt(orderId)
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showNotification('Xóa đơn hàng thành công!', 'success');
                    loadOrdersFromAPI();
                    loadStatsFromAPI();
                } else {
                    showNotification('Lỗi xóa đơn hàng!', 'error');
                }
            })
            .catch(error => {
                console.error('Error deleting order:', error);
                showNotification('Lỗi xóa đơn hàng!', 'error');
            });
        }

        // Toggle sound notification
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

        // Play notification sound
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
            const audio = new Audio('data:audio/wav;base64,UklGRhoBAABXQVZFZm10IBAAAAABAAEARKwAAIhYAQACABAAZGF0YQgBAAC0ssyDPK8TBLvhG0TH0hVE4wkkRu7wIkHdwiY+mZYhOmeQHStvgBg2WVQQP0gPE0dGC19dBkZtRVZGOCwJLhVOCyoAVRcsKCgOCxtVDj8nKB5bQR4VKTc9SVdIGydJF1gVMg1gNgdLRRdwTCMPgCclNz8yXy9gH1s3CQZtLQQEGSAGEy8XIl0REVBEMyIAXRU9HgKiPTVOCCUcITs3RhE6AhAAA/URADcFDgkDCREJKAIaCwJTCjcOBBdCBzkNDwgOOw4LBgAKDwIABbD7+OjR9fDW/vC7/fCF+vdz9/Zk8vdP8PhB6Pks5vkf6vgQ8vkC+v4FBA0IPRENKdYCOJAGOKYKOZ0OOVAPMo8OIXQIJHcCGFf9AFAA+/8t+/q3/PP89f3sCP0AEgP+IwMAMAIA+v8w9fgs6fIc4e8R3esPuPDy1YLyR9Hw8XnQ8JdkyP73Nbn+7zuv/Pk1qP/8OqT8AQCe+P8Gmfb+DZT0/RaR8/shjvP6LKf7COKP+xHdkPsJ2pP6/tiV+vHZkfvh2430YtqW8TrcsPCG3rr+3+FH/0XlLP9f6Bb+HusA/JXr/PdN7ary6e7P8WDxz/Hm8/3xvvby8ob7//WgA/PVDPP0BwP0/ggF9EUJBO6TB/bqcQn24nYK+N8lCvPaSAny1XwFytSg/07V3+kJ2K3Vg9xRwmbh5dZc50bY/+2r2S/zyOsn3OMLAAL4A9cLAOcT3QUD0xsJAyEhCQIjKwsBISEIAB4UBQEYAwDTEnv+Fxd++kEZd/W4HXT+mSNy+Pkpc+6tMHLp8j4N6sNR7v7LXb7K1GW+KdxetFbip6n+6IKglO93nBb29E2i+vMILKf+7hEyr/vs+TTC+eMqzdDvDRbcgBs5zJAoLrmGNjyoQUS2mPEz');
            audio.volume = 0.5;
            audio.play().catch(e => console.log('Cannot play notification sound'));
        }

        // Load recent activity
        function loadRecentActivity() {
            console.log('Loading recent activity...');
            fetch('./index.php?controller=order&action=getRecentActivity')
                .then(response => {
                    console.log('Activity response:', response);
                    return response.json();
                })
                .then(data => {
                    console.log('Activity data:', data);
                    if (data.success) {
                        displayRecentActivity(data.activities);
                    } else {
                        console.error('Activity API error:', data.message);
                    }
                })
                .catch(error => {
                    console.error('Error loading recent activity:', error);
                });
        }

        // Display recent activity
        function displayRecentActivity(activities) {
            console.log('Displaying activities:', activities);
            
            const activityList = document.getElementById('activityList');
            
            if (!activityList) {
                console.error('activityList element not found!');
                return;
            }
            
            if (!activities || activities.length === 0) {
                activityList.innerHTML = '<div class="text-center text-muted py-3">Chưa có hoạt động nào</div>';
                return;
            }
            
            let html = '';
            activities.forEach(activity => {
                let icon = 'bi-info-circle';
                let iconClass = 'info';
                
                switch(activity.type) {
                    case 'new_order':
                        icon = 'bi-plus-circle';
                        iconClass = 'warning';
                        break;
                    case 'order_completed':
                    case 'order_complete': // Handle both variations
                        icon = 'bi-check-circle';
                        iconClass = 'success';
                        break;
                    case 'order_cancelled':
                        icon = 'bi-x-circle';
                        iconClass = 'danger';
                        break;
                    case 'status_updated':
                        icon = 'bi-arrow-repeat';
                        iconClass = 'info';
                        break;
                    default:
                        icon = 'bi-info-circle';
                        iconClass = 'primary';
                }
                
                html += `
                    <div class="activity-item">
                        <div class="activity-icon ${iconClass}">
                            <i class="bi ${icon}"></i>
                        </div>
                        <div class="activity-content">
                            <div class="activity-title">${activity.description}</div>
                            <div class="activity-time">${activity.time_ago}</div>
                        </div>
                    </div>
                `;
            });
            
            console.log('Generated HTML:', html);
            activityList.innerHTML = html;
        }

        // Load statistics from API
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

        // Update statistics display
        function updateStatsDisplay(stats) {
            const totalElement = document.getElementById('ordersStatsTotal');
            const pendingElement = document.getElementById('ordersStatsPending');
            const preparingElement = document.getElementById('ordersStatsPreparing');
            const completedElement = document.getElementById('ordersStatsCompleted');
            const revenueElement = document.getElementById('revenueToday');
            
            if (totalElement) totalElement.textContent = stats.total_orders || 0;
            if (pendingElement) pendingElement.textContent = stats.pending_orders || 0;
            if (preparingElement) preparingElement.textContent = stats.preparing_orders || 0;
            if (completedElement) completedElement.textContent = stats.completed_orders || 0;
            if (revenueElement) revenueElement.textContent = (parseInt(stats.total_revenue) || 0).toLocaleString() + 'đ';
            
            console.log('Stats updated:', stats);
        }

        // Auto refresh functionality
        function startAutoRefresh() {
            if (!autoRefreshInterval) {
                autoRefreshInterval = setInterval(() => {
                    checkForUpdates();
                }, 5000); // Check every 5 seconds
                
                showNotification('🔄 Tự động làm mới đã được bật!', 'info');
            }
        }

        function checkForUpdates() {
            // Check for new orders and update
            fetch(`./index.php?controller=order&action=getNewOrders&since=${lastUpdateTime}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success && data.orders.length > 0) {
                        // Có đơn hàng mới - load lại toàn bộ
                        loadOrdersFromAPI();
                        loadStatsFromAPI();
                        loadRecentActivity(); // Reload recent activity
                        showNotification(`🎉 ${data.orders.length} đơn hàng mới!`, 'success');
                        
                        // Play notification sound
                        playNotificationSound();
                        
                        lastUpdateTime = data.timestamp;
                    }
                })
                .catch(error => {
                    console.error('Error checking for updates:', error);
                });
        }

        // Toggle bulk select mode
        function toggleBulkSelectMode() {
            isBulkSelectMode = !isBulkSelectMode;
            selectedOrders.clear();
            loadOrdersFromAPI(); // Refresh to show/hide checkboxes
        }

        // Toggle order selection
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
            const bulkBtn = document.getElementById('bulkActionsBtn');
            const count = selectedOrders.size;
            
            if (bulkBtn) {
                if (count > 0) {
                    bulkBtn.textContent = `Bulk Actions (${count})`;
                    bulkBtn.disabled = false;
                } else {
                    bulkBtn.textContent = 'Bulk Actions';
                    bulkBtn.disabled = true;
                }
            }
        }

        // Show bulk actions modal
        function showBulkActions() {
            document.getElementById('selectedOrdersCount').textContent = selectedOrders.size;
            const modal = new bootstrap.Modal(document.getElementById('bulkActionsModal'));
            modal.show();
        }

        // Execute bulk action
        function executeBulkAction() {
            const action = document.getElementById('bulkActionSelect').value;
            if (!action) {
                showNotification('Vui lòng chọn hành động!', 'error');
                return;
            }

            const orderIds = Array.from(selectedOrders);
            
            fetch('./index.php?controller=order&action=bulkUpdate', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    orderIds: orderIds,
                    action: action
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showNotification(`Đã thực hiện ${action} cho ${orderIds.length} đơn hàng!`, 'success');
                    selectedOrders.clear();
                    loadOrdersFromAPI();
                    loadStatsFromAPI();
                    
                    // Close modal
                    const modal = bootstrap.Modal.getInstance(document.getElementById('bulkActionsModal'));
                    modal.hide();
                } else {
                    showNotification('Lỗi thực hiện bulk action!', 'error');
                }
            })
            .catch(error => {
                console.error('Error executing bulk action:', error);
                showNotification('Lỗi thực hiện bulk action!', 'error');
            });
        }

        // Initialize when page loads
        document.addEventListener('DOMContentLoaded', function() {
            // Set sound button state
            const soundIcon = document.getElementById('soundIcon');
            const soundText = document.getElementById('soundText');
            const soundButton = document.getElementById('soundButton');
            
            if (soundIcon && soundText && soundButton) {
                if (isSoundEnabled) {
                    soundIcon.className = 'bi bi-volume-up me-2';
                    soundText.textContent = 'Âm thanh';
                    soundButton.classList.remove('muted');
                } else {
                    soundIcon.className = 'bi bi-volume-mute me-2';
                    soundText.textContent = 'Tắt tiếng';
                    soundButton.classList.add('muted');
                }
            }
            
            // Don't auto-load orders anymore - only when Orders page is shown
            // Show dashboard page by default
            showDashboardPage();
        });

        // Debug test function
        function testDebug() {
            console.log('=== DEBUG TEST START ===');
            
            // Force show orders page first
            showOrdersPage();
            
            setTimeout(() => {
                console.log('ordersContainer exists:', document.getElementById('ordersContainer') !== null);
                console.log('ordersPage visible:', document.getElementById('ordersPage').style.display);
                
                // Test API directly
                fetch('./index.php?controller=order&action=getAllOrders')
                    .then(response => {
                        console.log('API Response status:', response.status);
                        return response.json();
                    })
                    .then(data => {
                        console.log('API Response data:', data);
                        
                        const container = document.getElementById('ordersContainer');
                        if (container && data.success && data.orders && data.orders.length > 0) {
                            // Use the actual displayOrders function
                            displayOrders(data.orders);
                            showNotification(`✅ Debug: Loaded ${data.orders.length} orders successfully!`, 'success');
                        } else if (container) {
                            container.innerHTML = `
                                <div class="alert alert-warning">
                                    <h5>🐛 Debug Results:</h5>
                                    <p><strong>API Success:</strong> ${data.success}</p>
                                    <p><strong>Orders Count:</strong> ${data.orders ? data.orders.length : 0}</p>
                                    <p><strong>Message:</strong> ${data.message || 'No message'}</p>
                                    <hr>
                                    <details>
                                        <summary>Raw API Response</summary>
                                        <pre style="max-height: 300px; overflow: auto;">${JSON.stringify(data, null, 2)}</pre>
                                    </details>
                                </div>
                            `;
                        }
                    })
                    .catch(error => {
                        console.error('API Error:', error);
                        const container = document.getElementById('ordersContainer');
                        if (container) {
                            container.innerHTML = `
                                <div class="alert alert-danger">
                                    <h5>❌ API Error:</h5>
                                    <p>${error.message}</p>
                                </div>
                            `;
                        }
                    });
                
                console.log('=== DEBUG TEST END ===');
            }, 200);
        }

        // Notification system
        function showNotification(message, type = 'info') {
            // Remove existing notifications
            const existingNotifications = document.querySelectorAll('.custom-notification');
            existingNotifications.forEach(notification => notification.remove());
            
            // Create notification element
            const notification = document.createElement('div');
            notification.className = `custom-notification alert alert-${type === 'error' ? 'danger' : type} alert-dismissible`;
            notification.style.cssText = `
                position: fixed;
                top: 80px;
                right: 20px;
                z-index: 9999;
                min-width: 300px;
                max-width: 400px;
                animation: slideInRight 0.3s ease-out;
                box-shadow: 0 4px 12px rgba(0, 0, 0, 0.4);
            `;
            
            notification.innerHTML = `
                <div class="d-flex align-items-center">
                    <span>${message}</span>
                    <button type="button" class="btn-close ms-auto" onclick="this.parentElement.parentElement.remove()"></button>
                </div>
            `;
            
            document.body.appendChild(notification);
            
            // Auto remove after 5 seconds
            setTimeout(() => {
                if (notification.parentElement) {
                    notification.style.animation = 'slideOutRight 0.3s ease-out';
                    setTimeout(() => notification.remove(), 300);
                }
            }, 5000);
        }

        // Add CSS for notification animations
        if (!document.getElementById('notificationStyles')) {
            const style = document.createElement('style');
            style.id = 'notificationStyles';
            style.textContent = `
                @keyframes slideInRight {
                    from {
                        transform: translateX(100%);
                        opacity: 0;
                    }
                    to {
                        transform: translateX(0);
                        opacity: 1;
                    }
                }
                
                @keyframes slideOutRight {
                    from {
                        transform: translateX(0);
                        opacity: 1;
                    }
                    to {
                        transform: translateX(100%);
                        opacity: 0;
                    }
                }
            `;
            document.head.appendChild(style);
        }
        
        // Reset Stats Functions
        function confirmResetStats() {
            const modal = new bootstrap.Modal(document.getElementById('resetStatsModal'));
            modal.show();
        }
        
        function executeResetStats() {
            // Hiển thị loading
            const executeBtn = document.querySelector('#resetStatsModal .btn-danger');
            const originalText = executeBtn.innerHTML;
            executeBtn.innerHTML = '<i class="bi bi-hourglass-split"></i> Đang xóa...';
            executeBtn.disabled = true;
            
            fetch('./index.php?controller=order&action=resetStats', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                }
            })
            .then(response => response.json())
            .then(data => {
                // Restore button
                executeBtn.innerHTML = originalText;
                executeBtn.disabled = false;
                
                if (data.success) {
                    showNotification('🗑️ Reset thành công! Tất cả dữ liệu đã được xóa.', 'success');
                    
                    // Close modal
                    const modal = bootstrap.Modal.getInstance(document.getElementById('resetStatsModal'));
                    modal.hide();
                    
                    // Refresh dashboard để hiển thị stats = 0
                    setTimeout(() => {
                        refreshDashboard();
                        loadOrdersFromAPI(); // Clear orders display
                    }, 500);
                    
                } else {
                    showNotification('❌ Lỗi reset dữ liệu: ' + (data.message || 'Unknown error'), 'error');
                }
            })
            .catch(error => {
                console.error('Reset stats error:', error);
                
                // Restore button
                executeBtn.innerHTML = originalText;
                executeBtn.disabled = false;
                
                showNotification('❌ Lỗi kết nối: ' + error.message, 'error');
            });
        }
        
        // Filter orders by status
        function filterOrders() {
            const filterValue = document.getElementById('orderStatusFilter').value;
            const orderCards = document.querySelectorAll('[data-order-id]');
            
            orderCards.forEach(card => {
                const orderStatus = card.getAttribute('data-status');
                let shouldShow = false;
                
                if (filterValue === 'active') {
                    // Active orders = pending + preparing
                    shouldShow = (orderStatus === 'pending' || orderStatus === 'preparing');
                } else if (filterValue === orderStatus) {
                    // Specific status match
                    shouldShow = true;
                }
                
                if (shouldShow) {
                    card.style.display = 'block';
                } else {
                    card.style.display = 'none';
                }
            });
            
            // Update visible count
            const visibleCards = document.querySelectorAll('[data-order-id]:not([style*="display: none"])');
            console.log(`Filtered orders: ${visibleCards.length} visible out of ${orderCards.length} total`);
        }
        
        // Search orders by text
        function searchOrders() {
            const searchValue = document.getElementById('orderSearchInput').value.toLowerCase();
            const orderCards = document.querySelectorAll('[data-order-id]');
            
            orderCards.forEach(card => {
                const orderText = card.textContent.toLowerCase();
                
                if (searchValue === '' || orderText.includes(searchValue)) {
                    // Only show if also passes status filter
                    const filterValue = document.getElementById('orderStatusFilter').value;
                    const orderStatus = card.getAttribute('data-status');
                    
                    if (filterValue === '' || orderStatus === filterValue) {
                        card.style.display = 'block';
                    }
                } else {
                    card.style.display = 'none';
                }
            });
        }

        // Theme Toggle Functionality
        function toggleTheme() {
            const html = document.documentElement;
            const themeIcon = document.getElementById('themeIcon');
            const currentTheme = html.getAttribute('data-theme') || 'dark';
            
            if (currentTheme === 'dark') {
                html.setAttribute('data-theme', 'light');
                themeIcon.className = 'bi bi-sun-fill';
                localStorage.setItem('theme', 'light');
            } else {
                html.setAttribute('data-theme', 'dark');
                themeIcon.className = 'bi bi-moon-fill';
                localStorage.setItem('theme', 'dark');
            }
        }

        // Initialize theme from localStorage
        function initializeTheme() {
            const savedTheme = localStorage.getItem('theme') || 'dark';
            const html = document.documentElement;
            const themeIcon = document.getElementById('themeIcon');
            
            html.setAttribute('data-theme', savedTheme);
            if (savedTheme === 'light') {
                themeIcon.className = 'bi bi-sun-fill';
            } else {
                themeIcon.className = 'bi bi-moon-fill';
            }
        }

        // Global Search Functionality
        function performGlobalSearch(searchTerm) {
            const term = searchTerm.toLowerCase().trim();
            
            if (term === '') {
                clearSearchHighlights();
                return;
            }

            // Search in different sections
            searchInMenuItems(term);
            searchInOrders(term);
            searchInSidebar(term);
            
            // Show search info
            showSearchInfo(term);
        }

        function searchInMenuItems(term) {
            const menuItems = document.querySelectorAll('.menu-item-row');
            let found = 0;
            
            menuItems.forEach(item => {
                const text = item.textContent.toLowerCase();
                if (text.includes(term)) {
                    item.style.display = '';
                    highlightText(item, term);
                    found++;
                } else {
                    item.style.display = 'none';
                }
            });
            
            return found;
        }

        function searchInOrders(term) {
            const orders = document.querySelectorAll('[data-order-id]');
            let found = 0;
            
            orders.forEach(order => {
                const text = order.textContent.toLowerCase();
                if (text.includes(term)) {
                    order.style.display = '';
                    highlightText(order, term);
                    found++;
                } else {
                    order.style.display = 'none';
                }
            });
            
            return found;
        }

        function searchInSidebar(term) {
            const navLinks = document.querySelectorAll('.nav-link .nav-text');
            
            navLinks.forEach(link => {
                const text = link.textContent.toLowerCase();
                if (text.includes(term)) {
                    link.closest('.nav-item').style.backgroundColor = 'rgba(99, 102, 241, 0.1)';
                    highlightText(link, term);
                } else {
                    link.closest('.nav-item').style.backgroundColor = '';
                    clearHighlightInElement(link);
                }
            });
        }

        function highlightText(element, term) {
            const walker = document.createTreeWalker(
                element,
                NodeFilter.SHOW_TEXT,
                null,
                false
            );

            const textNodes = [];
            let node;
            while (node = walker.nextNode()) {
                textNodes.push(node);
            }

            textNodes.forEach(textNode => {
                const text = textNode.textContent;
                const regex = new RegExp(`(${term})`, 'gi');
                if (regex.test(text)) {
                    const highlightedText = text.replace(regex, '<span class="search-highlight">$1</span>');
                    const wrapper = document.createElement('span');
                    wrapper.innerHTML = highlightedText;
                    textNode.parentNode.replaceChild(wrapper, textNode);
                }
            });
        }

        function clearSearchHighlights() {
            const highlights = document.querySelectorAll('.search-highlight');
            highlights.forEach(highlight => {
                const parent = highlight.parentNode;
                parent.replaceChild(document.createTextNode(highlight.textContent), highlight);
                parent.normalize();
            });

            // Reset all hidden elements
            const hiddenElements = document.querySelectorAll('[style*="display: none"]');
            hiddenElements.forEach(el => {
                if (el.classList.contains('menu-item-row') || el.hasAttribute('data-order-id')) {
                    el.style.display = '';
                }
            });

            // Clear sidebar highlights
            const navItems = document.querySelectorAll('.nav-item');
            navItems.forEach(item => {
                item.style.backgroundColor = '';
            });

            hideSearchInfo();
        }

        function clearHighlightInElement(element) {
            const highlights = element.querySelectorAll('.search-highlight');
            highlights.forEach(highlight => {
                const parent = highlight.parentNode;
                parent.replaceChild(document.createTextNode(highlight.textContent), highlight);
                parent.normalize();
            });
        }

        function showSearchInfo(term) {
            const existingInfo = document.querySelector('.search-results-info');
            if (existingInfo) {
                existingInfo.remove();
            }

            const info = document.createElement('div');
            info.className = 'search-results-info';
            info.innerHTML = `
                <i class="bi bi-search me-2"></i>
                Searching for: "<strong>${term}</strong>"
                <button onclick="clearSearchHighlights()" class="btn btn-sm btn-outline-secondary ms-3">
                    <i class="bi bi-x"></i> Clear
                </button>
            `;

            const dashboardContent = document.querySelector('.dashboard-content');
            if (dashboardContent) {
                dashboardContent.insertBefore(info, dashboardContent.firstChild);
            }
        }

        function hideSearchInfo() {
            const existingInfo = document.querySelector('.search-results-info');
            if (existingInfo) {
                existingInfo.remove();
            }
        }

        // Notification function
        function showNotification(message, type = 'info') {
            // Create notification if it doesn't exist
            let notification = document.querySelector('.notification-toast');
            if (!notification) {
                notification = document.createElement('div');
                notification.className = 'notification-toast';
                notification.style.cssText = `
                    position: fixed;
                    top: 20px;
                    right: 20px;
                    padding: 12px 20px;
                    border-radius: 8px;
                    color: white;
                    font-weight: 500;
                    z-index: 9999;
                    transform: translateX(100%);
                    transition: transform 0.3s ease;
                `;
                document.body.appendChild(notification);
            }

            // Set color based on type
            const colors = {
                success: '#10b981',
                error: '#ef4444',
                warning: '#f59e0b',
                info: '#06b6d4'
            };

            notification.style.background = colors[type] || colors.info;
            notification.innerHTML = `<i class="bi bi-check-circle me-2"></i>${message}`;
            
            // Show notification
            setTimeout(() => {
                notification.style.transform = 'translateX(0)';
            }, 100);

            // Hide after 3 seconds
            setTimeout(() => {
                notification.style.transform = 'translateX(100%)';
                setTimeout(() => {
                    if (notification.parentNode) {
                        notification.parentNode.removeChild(notification);
                    }
                }, 300);
            }, 3000);
        }

        // Initialize on page load
        document.addEventListener('DOMContentLoaded', function() {
            initializeTheme();
            
            // Clear search when page loads
            const globalSearch = document.getElementById('globalSearch');
            if (globalSearch) {
                globalSearch.addEventListener('keyup', function(e) {
                    if (e.key === 'Escape') {
                        this.value = '';
                        clearSearchHighlights();
                    }
                });
            }

            // Start real-time updates
            startRealTimeUpdates();
        });

        // Real-time Order Updates
        let lastOrderCount = 0;
        let lastOrderUpdateTime = 0;
        let realTimeInterval;

        function startRealTimeUpdates() {
            // Check for updates every 5 seconds
            realTimeInterval = setInterval(checkForOrderUpdates, 5000);
            console.log('Real-time order updates started');
        }

        function stopRealTimeUpdates() {
            if (realTimeInterval) {
                clearInterval(realTimeInterval);
                console.log('Real-time order updates stopped');
            }
        }

        async function checkForOrderUpdates() {
            try {
                const response = await fetch('index.php?action=getOrderUpdates&ajax=1');
                const data = await response.json();
                
                if (data.success) {
                    const currentOrderCount = data.orderCount;
                    const currentUpdateTime = data.lastUpdate;
                    
                    // Check if there are new orders
                    if (lastOrderCount > 0 && currentOrderCount > lastOrderCount) {
                        const newOrdersCount = currentOrderCount - lastOrderCount;
                        showNotification(`${newOrdersCount} new order(s) received!`, 'success');
                        playNotificationSound();
                        
                        // Update order badge if exists
                        updateOrderBadge(currentOrderCount);
                    }
                    
                    // Check if orders were updated
                    if (lastOrderUpdateTime > 0 && currentUpdateTime > lastOrderUpdateTime) {
                        // Refresh orders list if we're on orders tab
                        if (isOrdersTabActive()) {
                            refreshOrdersList();
                        }
                    }
                    
                    // Update counters
                    lastOrderCount = currentOrderCount;
                    lastOrderUpdateTime = currentUpdateTime;
                    
                    // Update dashboard stats
                    if (data.stats) {
                        updateDashboardStats(data.stats);
                    }
                }
            } catch (error) {
                console.error('Error checking order updates:', error);
            }
        }

        function isOrdersTabActive() {
            const ordersSection = document.getElementById('orders');
            return ordersSection && ordersSection.style.display !== 'none';
        }

        async function refreshOrdersList() {
            try {
                const response = await fetch('index.php?action=getOrders&ajax=1');
                const data = await response.json();
                
                if (data.success && data.orders) {
                    updateOrdersDisplay(data.orders);
                    showNotification('Orders updated', 'info');
                }
            } catch (error) {
                console.error('Error refreshing orders:', error);
            }
        }

        function updateOrdersDisplay(orders) {
            const ordersContainer = document.querySelector('#orders .row');
            if (!ordersContainer) return;
            
            // Clear existing orders
            ordersContainer.innerHTML = '';
            
            // Add updated orders
            orders.forEach(order => {
                const orderCard = createOrderCard(order);
                ordersContainer.appendChild(orderCard);
            });
        }

        function createOrderCard(order) {
            const card = document.createElement('div');
            card.className = 'col-md-6 col-lg-4 mb-4';
            card.setAttribute('data-order-id', order.id);
            card.setAttribute('data-status', order.status);
            
            const statusClass = getStatusBadgeClass(order.status);
            const orderDate = new Date(order.created_at).toLocaleString();
            
            card.innerHTML = `
                <div class="card" style="background: var(--card-bg); border: 1px solid var(--border-color);">
                    <div class="card-header d-flex justify-content-between align-items-center" style="background: var(--dark-bg); border-bottom: 1px solid var(--border-color);">
                        <h6 class="mb-0" style="color: var(--text-light);">Order #${order.id}</h6>
                        <span class="badge ${statusClass}">${order.status}</span>
                    </div>
                    <div class="card-body">
                        <p style="color: var(--text-light);"><strong>Table:</strong> ${order.table_number || 'N/A'}</p>
                        <p style="color: var(--text-light);"><strong>Total:</strong> ${parseInt(order.total_amount).toLocaleString()}đ</p>
                        <p style="color: var(--text-muted);"><small>Ordered: ${orderDate}</small></p>
                        <div class="btn-group w-100">
                            <button class="btn btn-outline-primary btn-sm" onclick="viewOrderDetails(${order.id})">
                                <i class="bi bi-eye"></i> View
                            </button>
                            <button class="btn btn-outline-success btn-sm" onclick="updateOrderStatus(${order.id}, 'completed')">
                                <i class="bi bi-check"></i> Complete
                            </button>
                        </div>
                    </div>
                </div>
            `;
            
            return card;
        }

        function updateOrderBadge(count) {
            const badge = document.querySelector('.notification-badge');
            if (badge) {
                badge.textContent = count;
                badge.style.display = count > 0 ? 'block' : 'none';
            }
        }

        function updateDashboardStats(stats) {
            // Update total orders
            const totalOrdersElement = document.getElementById('ordersStatsTotal');
            if (totalOrdersElement) {
                totalOrdersElement.textContent = stats.totalOrders || 0;
            }
            
            // Update pending orders
            const pendingOrdersElement = document.getElementById('ordersStatsPending');
            if (pendingOrdersElement) {
                pendingOrdersElement.textContent = stats.pendingOrders || 0;
            }
            
            // Update total revenue
            const revenueElement = document.getElementById('revenueToday');
            if (revenueElement) {
                revenueElement.textContent = (stats.totalRevenue || 0).toLocaleString() + 'đ';
            }
        }

        function playNotificationSound() {
            // Create audio notification
            const audio = new Audio('data:audio/wav;base64,UklGRnoGAABXQVZFZm10IBAAAAABAAEAQB8AAEAfAAABAAgAZGF0YQoGAACBhYqFbF1fdJivrJBhNjVgodDbq2EcBj+a2/LDciUFLIHO8tiJNwgZaLvt559NEAxQp+PwtmMcBjiR1/LMeSwFJHfH8N2QQAoUXrTp66hVFApGn+DyvmEaBS+D0fPReS8FJH3N8dyKPAoYabfr4Z1KDgxOqOPUvmoaAzaH3O3FciYELIfN89V1LgUpcr3r5Z5NEAxPpuTwtWMaBDgAAAAABAAAAAAUQAA=');
            audio.volume = 0.3;
            audio.play().catch(e => console.log('Audio notification failed:', e));
        }

        // Handle broken images - tự động clear URL trong database
        async function handleBrokenImage(itemId) {
            try {
                console.log(`Broken image detected for item ${itemId}, clearing URL...`);
                
                const response = await fetch('index.php?controller=admin&action=clearBrokenImage', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ id: itemId })
                });
                
                const result = await response.json();
                if (result.success) {
                    console.log(`Cleared broken image URL for item ${itemId}`);
                    // Update local menuItems array
                    const item = menuItems.find(i => i.id == itemId);
                    if (item) item.image = null;
                } else {
                    console.error('Failed to clear broken image URL:', result.message);
                }
            } catch (error) {
                console.error('Error clearing broken image:', error);
            }
        }

        // Stop real-time updates when page is hidden
        document.addEventListener('visibilitychange', function() {
            if (document.hidden) {
                stopRealTimeUpdates();
            } else {
                startRealTimeUpdates();
            }
        });

        // Cleanup on page unload
        window.addEventListener('beforeunload', function() {
            stopRealTimeUpdates();
        });
    </script>
</body>
</html>
