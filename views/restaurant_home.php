<!DOCTYPE html>
<html lang="vi" data-bs-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restaurant - Nhà hàng của chúng tôi</title>
    
    <!-- Bootstrap 5.3 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --primary-color: #6366f1;
            --primary-dark: #4f46e5;
            --success-color: #10b981;
            --warning-color: #f59e0b;
            --danger-color: #ef4444;
            --dark-bg: #0f172a;
            --card-bg: #1e293b;
            --border-color: #334155;
            --text-light: #cbd5e1;
            --text-muted: #64748b;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, var(--dark-bg) 0%, #1a1a2e 100%);
            color: var(--text-light);
            min-height: 100vh;
        }

        .hero-section {
            background: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)), url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 600"><rect fill="%23334155" width="1200" height="600"/><path fill="%236366f1" opacity="0.1" d="M0,300 Q300,200 600,300 T1200,300 V600 H0 Z"/></svg>');
            background-size: cover;
            background-position: center;
            padding: 80px 0;
            text-align: center;
        }

        .hero-title {
            font-size: 3.5rem;
            font-weight: 800;
            margin-bottom: 1rem;
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .hero-subtitle {
            font-size: 1.25rem;
            color: var(--text-muted);
            margin-bottom: 2rem;
        }

        .action-btn {
            background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
            border: none;
            padding: 1rem 2rem;
            border-radius: 50px;
            color: white;
            font-weight: 600;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(99, 102, 241, 0.4);
        }

        .action-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(99, 102, 241, 0.6);
            color: white;
        }

        .feature-card {
            background: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 20px;
            padding: 2rem;
            text-align: center;
            transition: all 0.3s ease;
            height: 100%;
        }

        .feature-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
            border-color: var(--primary-color);
        }

        .feature-icon {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1rem;
            font-size: 2rem;
            color: white;
        }

        .navbar-custom {
            background: rgba(15, 23, 42, 0.95);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid var(--border-color);
        }

        .navbar-brand {
            font-weight: 700;
            font-size: 1.5rem;
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .staff-link {
            background: rgba(99, 102, 241, 0.1);
            border: 1px solid var(--primary-color);
            border-radius: 25px;
            padding: 0.5rem 1rem;
            color: var(--primary-color);
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .staff-link:hover {
            background: var(--primary-color);
            color: white;
        }

        .stats-section {
            background: var(--card-bg);
            border-radius: 20px;
            padding: 3rem;
            margin: 4rem 0;
        }

        .stat-item {
            text-align: center;
        }

        .stat-number {
            font-size: 3rem;
            font-weight: 800;
            color: var(--primary-color);
            display: block;
        }

        .stat-label {
            color: var(--text-muted);
            font-weight: 500;
        }

        .footer {
            background: var(--dark-bg);
            border-top: 1px solid var(--border-color);
            padding: 3rem 0;
            margin-top: 4rem;
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-custom fixed-top">
        <div class="container">
            <a class="navbar-brand" href="#">
                <i class="bi bi-shop"></i> Restaurant
            </a>
            
            <div class="navbar-nav ms-auto">
                <a href="index.php?controller=restaurant&action=menu" class="nav-link me-3">
                    <i class="bi bi-menu-button-wide"></i> Thực đơn
                </a>
                <a href="index.php?controller=order&action=dashboard" class="staff-link">
                    <i class="bi bi-person-badge"></i> Nhân viên
                </a>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container">
            <h1 class="hero-title">Chào mừng đến nhà hàng</h1>
            <p class="hero-subtitle">Trải nghiệm ẩm thực tuyệt vời với hệ thống đặt hàng hiện đại</p>
            
            <div class="d-flex justify-content-center gap-3 flex-wrap">
                <a href="index.php?controller=restaurant&action=menu" class="action-btn">
                    <i class="bi bi-menu-button-wide"></i>
                    Xem thực đơn
                </a>
                <a href="#features" class="action-btn" style="background: rgba(99, 102, 241, 0.2); box-shadow: none;">
                    <i class="bi bi-info-circle"></i>
                    Tìm hiểu thêm
                </a>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="py-5">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="display-5 fw-bold mb-3">Tại sao chọn chúng tôi?</h2>
                <p class="lead text-muted">Hệ thống đặt hàng hiện đại với nhiều tính năng ưu việt</p>
            </div>
            
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="bi bi-lightning-charge"></i>
                        </div>
                        <h4 class="mb-3">Đặt hàng nhanh chóng</h4>
                        <p class="text-muted">Giao diện đơn giản, dễ sử dụng. Đặt hàng chỉ với vài cú click.</p>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="bi bi-shield-check"></i>
                        </div>
                        <h4 class="mb-3">An toàn & Đáng tin cậy</h4>
                        <p class="text-muted">Hệ thống bảo mật cao, đảm bảo thông tin khách hàng được bảo vệ.</p>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="bi bi-headset"></i>
                        </div>
                        <h4 class="mb-3">Hỗ trợ 24/7</h4>
                        <p class="text-muted">Đội ngũ nhân viên nhiệt tình, sẵn sàng hỗ trợ bạn mọi lúc.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Quick Actions -->
    <section class="py-5">
        <div class="container">
            <div class="row g-4">
                <div class="col-md-6">
                    <div class="feature-card">
                        <h3 class="mb-3">
                            <i class="bi bi-people text-primary"></i>
                            Khách hàng
                        </h3>
                        <p class="text-muted mb-4">Xem thực đơn và đặt hàng trực tuyến một cách dễ dàng</p>
                        <a href="index.php?controller=restaurant&action=menu" class="action-btn">
                            <i class="bi bi-arrow-right"></i>
                            Bắt đầu đặt hàng
                        </a>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="feature-card">
                        <h3 class="mb-3">
                            <i class="bi bi-person-badge text-warning"></i>
                            Nhân viên
                        </h3>
                        <p class="text-muted mb-4">Truy cập hệ thống quản lý đơn hàng và menu nhà hàng</p>
                        <a href="?controller=auth&action=login" class="action-btn" style="background: linear-gradient(135deg, var(--warning-color), #d97706);">
                            <i class="bi bi-box-arrow-in-right"></i>
                            Đăng nhập làm việc
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h5 class="mb-3">
                        <i class="bi bi-shop"></i> Restaurant
                    </h5>
                    <p class="text-muted">Hệ thống đặt hàng hiện đại, mang đến trải nghiệm ẩm thực tuyệt vời cho khách hàng.</p>
                </div>
                <div class="col-md-3">
                    <h6 class="mb-3">Liên kết</h6>
                    <ul class="list-unstyled">
                        <li><a href="index.php?controller=restaurant&action=menu" class="text-muted text-decoration-none">Thực đơn</a></li>
                        <li><a href="index.php?controller=order&action=dashboard" class="text-muted text-decoration-none">Nhân viên</a></li>
                    </ul>
                </div>
                <div class="col-md-3">
                    <h6 class="mb-3">Liên hệ</h6>
                    <p class="text-muted small">
                        <i class="bi bi-envelope"></i> info@restaurant.com<br>
                        <i class="bi bi-phone"></i> (84) 123 456 789
                    </p>
                </div>
            </div>
            <hr class="my-4" style="border-color: var(--border-color);">
            <div class="text-center text-muted">
                <small>&copy; 2025 Restaurant Management System. All rights reserved.</small>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
