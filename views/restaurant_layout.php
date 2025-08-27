<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($pageTitle ?? 'Ramen Kimura - Menu điện tử') ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-color: #FF6B35;
            --secondary-color: #2E86AB;
            --accent-color: #F7931E;
            --dark-color: #1A1A2E;
            --light-color: #F8F9FA;
            --gradient-1: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --gradient-2: linear-gradient(135deg, #FF6B35 0%, #F7931E 100%);
            --gradient-3: linear-gradient(135deg, #2E86AB 0%, #A23B72 100%);
            --shadow-soft: 0 8px 32px rgba(0,0,0,0.1);
            --shadow-hover: 0 12px 40px rgba(0,0,0,0.15);
        }
        
        * {
            font-family: 'Poppins', sans-serif;
            box-sizing: border-box;
        }
        
        body {
            background: var(--gradient-1);
            margin: 0;
            padding: 0;
            min-height: 100vh;
            overflow-x: hidden;
        }
        
        .glass-effect {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        
        .liquid-glass {
            background: rgba(255, 255, 255, 0.08);
            backdrop-filter: blur(40px) saturate(180%);
            border: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow: 
                0 8px 32px rgba(0, 0, 0, 0.1),
                inset 0 1px 0 rgba(255, 255, 255, 0.25),
                inset 0 -1px 0 rgba(255, 255, 255, 0.15);
            position: relative;
            overflow: hidden;
        }
        
        .liquid-glass::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(
                90deg,
                transparent,
                rgba(255, 255, 255, 0.1),
                transparent
            );
            animation: shimmer 3s infinite;
        }
        
        @keyframes shimmer {
            0% { left: -100%; }
            100% { left: 100%; }
        }
        
        .glass-icon {
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }
        
        .glass-btn {
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            color: #000000ff;
            font-weight: 600;
            padding: 12px 24px;
            border-radius: 15px;
            transition: all 0.3s ease;
            border: 1px solid grey;
        }
        
        .glass-btn:hover {
            background: rgba(255, 255, 255, 0.4);
            color: #333;
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        }
        
        .cart-preview {
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .cart-preview:hover {
            transform: translateY(-2px);
            background: rgba(255, 255, 255, 0.15) !important;
        }
        
        /* Item Detail Hover Effects */
        .item-image-wrapper:hover .view-detail-overlay .btn {
            opacity: 1;
            transform: scale(1.1);
        }
        
        .item-image-wrapper::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.3);
            opacity: 0;
            transition: opacity 0.3s ease;
            z-index: 1;
        }
        
        .item-image-wrapper:hover::before {
            opacity: 1;
        }
        
        .view-detail-overlay {
            z-index: 2;
        }
        
        /* Order Button Styling */
        .btn-success:hover {
            background: linear-gradient(135deg, #218838, #1e7e34) !important;
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(40, 167, 69, 0.4);
        }
        
        /* Cart Detail Modal */
        .cart-detail-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(10px);
            z-index: 9999;
            display: flex;
            align-items: center;
            justify-content: center;
            animation: fadeIn 0.3s ease-out;
        }
        
        .cart-detail-modal {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(30px);
            border-radius: 20px;
            width: 90%;
            max-width: 500px;
            max-height: 80vh;
            animation: slideUpModal 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            border: 1px solid rgba(255, 255, 255, 0.3);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
            overflow: hidden;
        }
        
        .cart-detail-header {
            display: flex;
            justify-content: between;
            align-items: center;
            padding: 20px 25px;
            border-bottom: 1px solid rgba(0, 0, 0, 0.1);
            position: relative;
        }
        
        .btn-close-cart {
            position: absolute;
            right: 20px;
            top: 50%;
            transform: translateY(-50%);
            background: rgba(0, 0, 0, 0.1);
            border: none;
            border-radius: 50%;
            width: 35px;
            height: 35px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
        }
        
        .btn-close-cart:hover {
            background: rgba(0, 0, 0, 0.2);
            transform: translateY(-50%) scale(1.1);
        }
        
        .cart-detail-body {
            padding: 20px 25px;
            max-height: 50vh;
            overflow-y: auto;
        }
        
        .cart-items-list {
            margin-bottom: 20px;
        }
        
        .cart-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 15px;
            margin-bottom: 10px;
            background: rgba(255, 255, 255, 0.5);
            border: 1px solid rgba(0, 0, 0, 0.1);
            border-radius: 12px;
            animation: slideInItem 0.3s ease-out;
            transition: all 0.3s ease;
        }
        
        .cart-item:hover {
            background: rgba(255, 255, 255, 0.7);
            transform: translateX(5px);
        }
        
        .cart-item:last-child {
            margin-bottom: 0;
        }
        
        .cart-item-info {
            flex: 1;
        }
        
        .cart-item-info h6 {
            margin: 0 0 5px 0;
            font-weight: 600;
            color: #333;
        }
        
        .cart-item-controls {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .cart-item-controls .btn {
            border-radius: 8px;
            width: 35px;
            height: 35px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.8rem;
            transition: all 0.3s ease;
            padding: 0;
        }
        
        .cart-item-controls .btn:hover {
            transform: scale(1.1);
        }
        
        .cart-summary-section {
            border-top: 1px solid rgba(0, 0, 0, 0.1);
            padding: 20px 25px;
            background: rgba(255, 255, 255, 0.3);
            margin: 0 -25px -25px -25px;
            border-radius: 0 0 25px 25px;
        }
        
        .cart-summary-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
            font-size: 0.95rem;
        }
        
        .cart-summary-row.total {
            font-weight: 700;
            font-size: 1.1rem;
            padding-top: 10px;
            border-top: 1px solid rgba(0, 0, 0, 0.1);
            margin-top: 10px;
        }
        
        .order-actions {
            display: flex;
            gap: 15px;
            margin-top: 20px;
        }
        
        .order-actions .btn {
            flex: 1;
            padding: 12px;
            border-radius: 12px;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        
        .btn-order-now {
            background: linear-gradient(135deg, #ff6b6b, #ff8e8e);
            border: none;
            color: white;
        }
        
        .btn-order-now:hover {
            background: linear-gradient(135deg, #ff5252, #ff7979);
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(255, 107, 107, 0.4);
            color: white;
        }
        
        .btn-clear-cart {
            background: rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(0, 0, 0, 0.2);
            color: #333;
        }
        
        .btn-clear-cart:hover {
            background: rgba(0, 0, 0, 0.2);
            color: #333;
        }
        
        /* Custom scrollbar for cart detail */
        .cart-detail-body::-webkit-scrollbar {
            width: 6px;
        }
        
        .cart-detail-body::-webkit-scrollbar-track {
            background: rgba(0, 0, 0, 0.1);
            border-radius: 10px;
        }
        
        .cart-detail-body::-webkit-scrollbar-thumb {
            background: rgba(0, 0, 0, 0.3);
            border-radius: 10px;
        }
        
        .cart-detail-body::-webkit-scrollbar-thumb:hover {
            background: rgba(0, 0, 0, 0.5);
        }
        
        .cart-item-controls {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .cart-summary-section {
            background: rgba(0, 0, 0, 0.03);
            padding: 15px;
            border-radius: 15px;
            margin-top: 15px;
        }
        
        .cart-detail-footer {
            padding: 20px 25px;
            border-top: 1px solid rgba(0, 0, 0, 0.1);
            display: flex;
            gap: 15px;
        }
        
        .cart-preview {
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .cart-preview:hover {
            transform: translateY(-5px);
            background: rgba(255, 255, 255, 0.12);
        }
        
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        
        @keyframes slideUpModal {
            from { 
                transform: translateY(30px) scale(0.95);
                opacity: 0;
            }
            to { 
                transform: translateY(0) scale(1);
                opacity: 1;
            }
        }
        
        @keyframes slideInItem {
            from { 
                transform: translateX(-20px);
                opacity: 0;
            }
            to { 
                transform: translateX(0);
                opacity: 1;
            }
        }
        
        .floating-animation {
            animation: floating 6s ease-in-out infinite;
        }
        
        @keyframes floating {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
        }
        
        .slide-in-left {
            animation: slideInLeft 0.8s ease-out;
        }
        
        .slide-in-right {
            animation: slideInRight 0.8s ease-out;
        }
        
        @keyframes slideInLeft {
            from { transform: translateX(-100px); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }
        
        @keyframes slideInRight {
            from { transform: translateX(100px); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }
        
        .fade-in-up {
            animation: fadeInUp 1s ease-out;
        }
        
        @keyframes fadeInUp {
            from { transform: translateY(50px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }
        
        .btn-modern {
            border: none;
            border-radius: 15px;
            padding: 12px 24px;
            font-weight: 600;
            font-size: 14px;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            position: relative;
            overflow: hidden;
        }
        
        .btn-modern::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
            transition: left 0.6s;
        }
        
        .btn-modern:hover::before {
            left: 100%;
        }
        
        .btn-modern:hover {
            transform: translateY(-5px) scale(1.05);
            box-shadow: var(--shadow-hover);
        }
        
        .card-modern {
            border: none;
            border-radius: 25px;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            box-shadow: var(--shadow-soft);
            transition: all 0.4s ease;
            overflow: hidden;
        }
        
        .card-modern:hover {
            transform: translateY(-10px);
            box-shadow: var(--shadow-hover);
        }
        
        .text-gradient {
            background: var(--gradient-2);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        .bg-pattern {
            background-image: 
                radial-gradient(circle at 20% 50%, rgba(255, 107, 53, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 80% 20%, rgba(46, 134, 171, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 40% 80%, rgba(247, 147, 30, 0.1) 0%, transparent 50%);
        }
        
        .icon-bounce {
            transition: transform 0.3s ease;
        }
        
        .icon-bounce:hover {
            transform: scale(1.2) rotate(10deg);
        }
        
        /* Particles animation */
        .particles {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            overflow: hidden;
            z-index: -1;
        }
        
        .particle {
            position: absolute;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            animation: particleFloat 8s infinite linear;
        }
        
        @keyframes particleFloat {
            0% { transform: translateY(100vh) rotate(0deg); opacity: 0; }
            10% { opacity: 1; }
            90% { opacity: 1; }
            100% { transform: translateY(-100px) rotate(360deg); opacity: 0; }
        }
        
        .main-container {
            max-width: 1000px;
            margin: 0 auto;
            padding: 15px;
            position: relative;
        }
        
        /* Responsive adjustments */
        @media (max-width: 768px) {
            .main-container {
                padding: 10px;
            }
        }
    </style>
</head>
<body class="bg-pattern">
    <!-- Animated particles background -->
    <div class="particles">
        <div class="particle" style="left: 10%; width: 8px; height: 8px; animation-delay: 0s;"></div>
        <div class="particle" style="left: 20%; width: 12px; height: 12px; animation-delay: 2s;"></div>
        <div class="particle" style="left: 30%; width: 6px; height: 6px; animation-delay: 4s;"></div>
        <div class="particle" style="left: 40%; width: 10px; height: 10px; animation-delay: 6s;"></div>
        <div class="particle" style="left: 50%; width: 8px; height: 8px; animation-delay: 1s;"></div>
        <div class="particle" style="left: 60%; width: 14px; height: 14px; animation-delay: 3s;"></div>
        <div class="particle" style="left: 70%; width: 7px; height: 7px; animation-delay: 5s;"></div>
        <div class="particle" style="left: 80%; width: 11px; height: 11px; animation-delay: 7s;"></div>
        <div class="particle" style="left: 90%; width: 9px; height: 9px; animation-delay: 2.5s;"></div>
    </div>
    
    <div class="main-container">
        <?= $content ?>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Add smooth scroll behavior
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                document.querySelector(this.getAttribute('href')).scrollIntoView({
                    behavior: 'smooth'
                });
            });
        });
        
        // Add loading animation
        window.addEventListener('load', function() {
            document.body.style.opacity = '0';
            document.body.style.transition = 'opacity 0.5s ease-in-out';
            setTimeout(() => {
                document.body.style.opacity = '1';
            }, 100);
        });
    </script>
</body>
</html>
