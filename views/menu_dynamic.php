<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu Nhà Hàng - Bàn <?= $tableNumber ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
    <style>
        /* Elegant and sophisticated design with dark theme like dashboard */
        body {
            background: linear-gradient(135deg, #1a1d29 0%, #2d3436 100%);
            font-family: 'Poppins', sans-serif;
            min-height: 100vh;
            color: #e1e5e9;
        }

        .menu-container {
            padding: 15px 10px;
            max-width: 1200px;
            margin: 0 auto;
        }

        .menu-header {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(20px);
            border-radius: 15px;
            padding: 20px;
            margin-bottom: 20px;
            text-align: center;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
            border: 1px solid rgba(255, 255, 255, 0.1);
            animation: slideInDown 0.8s ease-out;
        }

        @keyframes slideInDown {
            from {
                opacity: 0;
                transform: translateY(-30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .menu-header h2 {
            color: #ffffff;
            font-weight: 700;
            margin-bottom: 10px;
            font-size: 2rem;
            text-shadow: 0 2px 8px rgba(0, 0, 0, 0.5);
        }

        .table-info {
            background: linear-gradient(135deg, #00b4db, #0083b0);
            color: white;
            padding: 8px 20px;
            border-radius: 20px;
            display: inline-block;
            font-weight: 600;
            font-size: 1rem;
            box-shadow: 0 4px 15px rgba(0, 180, 219, 0.3);
        }

        .menu-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 300px));
            gap: 15px;
            padding: 0;
            justify-content: center;
            max-width: 1400px;
            margin: 0 auto;
        }

        .menu-card {
            background: rgba(255, 255, 255, 0.08);
            backdrop-filter: blur(20px);
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
            border: 1px solid rgba(255, 255, 255, 0.1);
            transition: all 0.3s ease;
            position: relative;
            animation: fadeInUp 0.6s ease-out forwards;
            opacity: 0;
            width: 100%;
            max-width: 300px;
            min-width: 250px;
        }

        .menu-card:nth-child(1) { animation-delay: 0.1s; }
        .menu-card:nth-child(2) { animation-delay: 0.2s; }
        .menu-card:nth-child(3) { animation-delay: 0.3s; }
        .menu-card:nth-child(4) { animation-delay: 0.4s; }
        .menu-card:nth-child(5) { animation-delay: 0.5s; }
        .menu-card:nth-child(6) { animation-delay: 0.6s; }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .menu-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 40px rgba(0, 0, 0, 0.4);
            border-color: rgba(0, 180, 219, 0.5);
        }

        .menu-image {
            height: 150px;
            background: rgba(0, 0, 0, 0.2);
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .menu-image .emoji {
            font-size: 2.5rem;
            opacity: 0.6;
            color: #6c757d;
        }

        .menu-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.3s ease;
        }

        .menu-card:hover .menu-image img {
            transform: scale(1.05);
        }

        .menu-content {
            padding: 15px;
        }

        .menu-title {
            color: #ffffff;
            font-weight: 700;
            font-size: 1.1em;
            margin-bottom: 8px;
            line-height: 1.3;
        }

        .menu-description {
            color: #b2bec3;
            font-size: 0.8em;
            margin-bottom: 12px;
            line-height: 1.4;
            min-height: 35px;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .menu-price {
            color: #00b4db;
            font-size: 1.3em;
            font-weight: 700;
            margin-bottom: 15px;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
        }

        .quantity-section {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            margin-bottom: 12px;
            padding: 8px;
            background: rgba(0, 0, 0, 0.2);
            border-radius: 8px;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .qty-btn {
            width: 28px;
            height: 28px;
            border-radius: 6px;
            border: 1px solid rgba(255, 255, 255, 0.2);
            font-size: 14px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            background: rgba(255, 255, 255, 0.1);
            color: #ffffff;
        }

        .qty-minus:hover {
            background: #e74c3c;
            color: white;
            border-color: #e74c3c;
            transform: scale(1.1);
        }

        .qty-plus:hover {
            background: #00b4db;
            color: white;
            border-color: #00b4db;
            transform: scale(1.1);
        }

        .qty-btn:active {
            transform: scale(0.95);
        }

        .qty-display {
            font-size: 1rem;
            font-weight: 700;
            color: #ffffff;
            min-width: 35px;
            text-align: center;
            background: rgba(0, 180, 219, 0.2);
            padding: 4px 8px;
            border-radius: 6px;
            border: 1px solid rgba(0, 180, 219, 0.3);
        }

        .add-btn {
            width: 100%;
            padding: 8px 15px;
            background: linear-gradient(135deg, #00b4db, #0083b0);
            color: white;
            border: none;
            border-radius: 6px;
            font-size: 0.9rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .add-btn:hover {
            background: linear-gradient(135deg, #0083b0, #006080);
            transform: translateY(-1px);
            box-shadow: 0 4px 15px rgba(0, 180, 219, 0.4);
        }

        .add-btn:active {
            transform: translateY(0);
        }

        /* Category Filter Buttons */
        .category-filters {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            justify-content: center;
            margin-bottom: 20px;
            padding: 0 15px;
        }

        .category-btn {
            background: rgba(255, 255, 255, 0.08);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 20px;
            padding: 8px 16px;
            font-size: 0.9rem;
            font-weight: 600;
            color: #e1e5e9;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 6px;
            position: relative;
            overflow: hidden;
            font-family: 'Poppins', sans-serif;
            outline: none;
        }

        .category-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(0, 180, 219, 0.2), transparent);
            transition: left 0.5s;
        }

        .category-btn:hover::before {
            left: 100%;
        }

        .category-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.3);
            border-color: rgba(0, 180, 219, 0.5);
        }

        .category-btn.active {
            background: linear-gradient(135deg, #00b4db, #0083b0);
            color: white;
            border-color: #00b4db;
            transform: translateY(-1px);
            box-shadow: 0 6px 20px rgba(0, 180, 219, 0.4);
        }

        .category-btn .icon {
            font-size: 1.1em;
        }

        .category-btn .count {
            background: rgba(255, 255, 255, 0.2);
            padding: 1px 6px;
            border-radius: 10px;
            font-size: 0.8em;
            margin-left: 3px;
        }

        .category-btn.active .count {
            background: rgba(255, 255, 255, 0.3);
        }
        /* Cart Button - Small floating cart button */
        .cart-btn:hover {
            transform: scale(1.1);
            box-shadow: 0 12px 40px rgba(0, 180, 219, 0.6);
        }

        .cart-btn:active {
            transform: scale(0.95);
        }

        .cart-badge {
            position: absolute;
            top: -5px;
            right: -5px;
            background: #e74c3c;
            color: white;
            border-radius: 50%;
            width: 25px;
            height: 25px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.8rem;
            font-weight: 700;
            box-shadow: 0 2px 8px rgba(231, 76, 60, 0.4);
            animation: pulse 1.5s infinite;
        }

        @keyframes bounce {
            0%, 20%, 50%, 80%, 100% {
                transform: translateY(0);
            }
            40% {
                transform: translateY(-10px);
            }
            60% {
                transform: translateY(-5px);
            }
        }

        @keyframes pulse {
            0% {
                transform: scale(1);
            }
            50% {
                transform: scale(1.2);
            }
            100% {
                transform: scale(1);
            }
        }

        .cart-float {
            position: fixed !important;
            top: 20px !important;
            right: 20px !important;
            background: rgba(26, 29, 41, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 15px;
            padding: 18px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.4);
            border: 1px solid rgba(255, 255, 255, 0.1);
            z-index: 999;
            width: 320px !important;
            max-width: 350px !important;
            max-height: 80vh;
            transition: all 0.5s cubic-bezier(0.34, 1.56, 0.64, 1);
            transform: scale(0);
            opacity: 0;
            transform-origin: calc(100% - 30px) 30px; /* Top right - where cart button is */
            pointer-events: none;
            /* Start from circular shape like the button */
            border-radius: 50px;
        }

        .cart-float.show {
            transform: scale(1);
            opacity: 1;
            pointer-events: auto;
            border-radius: 15px; /* Animate to final rounded corners */
        }

        /* Cart button animation */
        .cart-btn {
            position: fixed;
            top: 20px;
            right: 20px;
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, #00b4db, #0083b0);
            border-radius: 50%;
            border: none;
            color: white;
            font-size: 1.5rem;
            cursor: pointer;
            z-index: 1001;
            box-shadow: 0 8px 32px rgba(0, 180, 219, 0.4);
            transition: all 0.4s cubic-bezier(0.68, -0.55, 0.265, 1.55);
            display: flex;
            align-items: center;
            justify-content: center;
            animation: bounce 2s infinite;
        }

        /* Smooth hiding animation for cart button */
        .cart-btn.hidden {
            transform: scale(0) rotate(180deg);
            opacity: 0;
            pointer-events: none;
        }

        @keyframes slideInRight {
            from {
                opacity: 0;
                transform: translateX(100%);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .cart-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 12px;
            padding-bottom: 10px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .cart-title {
            font-size: 1.1em;
            font-weight: 700;
            color: #ffffff;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .cart-close {
            background: none;
            border: none;
            font-size: 1.3rem;
            color: #b2bec3;
            cursor: pointer;
            padding: 4px;
            border-radius: 50%;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 26px;
            height: 26px;
        }

        .cart-close:hover {
            background: #e74c3c;
            color: white;
            transform: rotate(90deg);
        }

        .cart-items {
            max-height: 280px;
            overflow-y: auto;
            margin-bottom: 12px;
            padding-right: 5px;
        }

        .cart-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 8px;
            margin-bottom: 8px;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 8px;
            font-size: 0.9rem;
            color: #e1e5e9;
            transition: all 0.3s ease;
            border: 1px solid rgba(255, 255, 255, 0.05);
        }

        .cart-item:hover {
            background: rgba(0, 180, 219, 0.1);
            border-color: rgba(0, 180, 219, 0.3);
            transform: translateX(2px);
        }

        .cart-item:last-child {
            margin-bottom: 0;
        }

        .cart-item-info {
            flex: 1;
            margin-right: 10px;
        }

        .cart-item-name {
            font-weight: 600;
            margin-bottom: 2px;
            color: #ffffff;
            font-size: 0.95rem;
        }

        .cart-item-price {
            font-weight: 500;
            color: #00b4db;
            font-size: 0.85rem;
        }

        .cart-item-controls {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .cart-qty-btn {
            width: 24px;
            height: 24px;
            border-radius: 4px;
            border: 1px solid rgba(255, 255, 255, 0.2);
            font-size: 12px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            background: rgba(255, 255, 255, 0.1);
            color: #ffffff;
        }

        .cart-qty-minus:hover {
            background: #e74c3c;
            color: white;
            border-color: #e74c3c;
            transform: scale(1.1);
        }

        .cart-qty-plus:hover {
            background: #00b4db;
            color: white;
            border-color: #00b4db;
            transform: scale(1.1);
        }

        .cart-qty-btn:active {
            transform: scale(0.9);
        }

        .cart-qty-display {
            font-size: 0.9rem;
            font-weight: 700;
            color: #ffffff;
            min-width: 25px;
            text-align: center;
            background: rgba(0, 180, 219, 0.2);
            padding: 2px 6px;
            border-radius: 4px;
            border: 1px solid rgba(0, 180, 219, 0.3);
        }

        .cart-remove-btn {
            width: 20px;
            height: 20px;
            border-radius: 50%;
            border: none;
            background: #e74c3c;
            color: white;
            font-size: 10px;
            cursor: pointer;
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-left: 5px;
        }

        .cart-remove-btn:hover {
            background: #c0392b;
            transform: scale(1.1);
        }

        .cart-remove-btn:active {
            transform: scale(0.9);
        }

        .cart-total {
            text-align: center;
            padding: 10px 0;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            font-size: 1.2em;
            font-weight: 700;
            color: #ffffff;
        }

        .order-btn {
            width: 100%;
            padding: 10px;
            background: linear-gradient(135deg, #00b4db, #0083b0);
            color: white;
            border: none;
            border-radius: 6px;
            font-size: 0.95rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .order-btn:hover {
            background: linear-gradient(135deg, #0083b0, #006080);
            transform: translateY(-1px);
            box-shadow: 0 4px 15px rgba(0, 180, 219, 0.4);
        }

        .order-btn:disabled {
            background: #6c757d;
            cursor: not-allowed;
            transform: none;
        }

        /* Responsive Design */
        @media (max-width: 1024px) {
            .cart-btn {
                bottom: 20px !important;
                top: auto !important;
            }
            
            .cart-float {
                position: fixed !important;
                bottom: 20px !important;
                right: 20px !important;
                top: auto !important;
                width: 300px !important;
                max-width: 320px !important;
                transform-origin: calc(100% - 30px) calc(100% - 30px); /* Bottom right relative to button */
            }
        }

        @media (max-width: 768px) {
            .cart-btn {
                width: 55px;
                height: 55px;
                font-size: 1.3rem;
                bottom: 15px !important;
                right: 15px !important;
                top: auto !important;
            }
            
            .cart-badge {
                width: 22px;
                height: 22px;
                font-size: 0.7rem;
                top: -3px;
                right: -3px;
            }
            
            .menu-container {
                padding: 12px 8px;
            }
            
            .menu-header {
                padding: 18px 15px;
                margin-bottom: 18px;
            }
            
            .menu-header h2 {
                font-size: 1.7rem;
            }
            
            .category-filters {
                padding: 0 8px;
                gap: 8px;
                margin-bottom: 18px;
            }
            
            .category-btn {
                padding: 6px 12px;
                font-size: 0.85rem;
            }
            
            .menu-grid {
                grid-template-columns: repeat(auto-fit, minmax(220px, 280px));
                gap: 12px;
                padding: 0 8px;
            }
            
            .menu-content {
                padding: 12px;
            }
            
            .menu-title {
                font-size: 1rem;
            }
            
            .menu-description {
                font-size: 0.75em;
                min-height: 30px;
            }
            
            .menu-price {
                font-size: 1.1em;
                margin-bottom: 10px;
            }
            
            .quantity-section {
                gap: 6px;
                padding: 6px;
                margin-bottom: 8px;
            }
            
            .qty-btn {
                width: 24px;
                height: 24px;
                font-size: 12px;
            }
            
            .qty-display {
                font-size: 0.9rem;
                min-width: 30px;
                padding: 3px 6px;
            }
            
            .add-btn {
                padding: 6px 12px;
                font-size: 0.8rem;
            }
            
            .cart-float {
                bottom: 15px !important;
                right: 15px !important;
                width: 280px !important;
                max-width: 300px !important;
                padding: 15px;
                transform-origin: calc(100% - 27px) calc(100% - 27px);
            }
        }

        @media (max-width: 480px) {
            .cart-btn {
                width: 50px;
                height: 50px;
                font-size: 1.2rem;
                bottom: 10px !important;
                right: 10px !important;
                top: auto !important;
            }
            
            .cart-badge {
                width: 20px;
                height: 20px;
                font-size: 0.65rem;
            }
            
            .menu-grid {
                grid-template-columns: 1fr;
                gap: 10px;
                padding: 0 5px;
            }
            
            .menu-card {
                min-width: auto;
                max-width: none;
            }
            
            .category-filters {
                gap: 6px;
            }
            
            .category-btn {
                padding: 5px 10px;
                font-size: 0.8rem;
            }
            
            .cart-float {
                bottom: 10px !important;
                right: 10px !important;
                width: 260px !important;
                max-width: 280px !important;
                padding: 12px;
                transform-origin: calc(100% - 25px) calc(100% - 25px);
            }
            
            .cart-items {
                max-height: 220px;
            }
        }

        /* Loading and Alert Styles */
        .loading {
            text-align: center;
            padding: 40px;
            color: #b2bec3;
            font-size: 1.1rem;
        }

        .alert {
            background: rgba(255, 193, 7, 0.1);
            backdrop-filter: blur(10px);
            border-radius: 10px;
            border: 1px solid rgba(255, 193, 7, 0.3);
            margin-bottom: 15px;
            padding: 12px;
            color: #fff3cd;
        }

        /* Custom Scrollbar */
        .cart-items::-webkit-scrollbar {
            width: 5px;
        }

        .cart-items::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.05);
            border-radius: 10px;
        }

        .cart-items::-webkit-scrollbar-thumb {
            background: #00b4db;
            border-radius: 10px;
        }

        .cart-items::-webkit-scrollbar-thumb:hover {
            background: #0083b0;
        }

        /* Sophisticated hover effects */
        .menu-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 2px;
            background: linear-gradient(90deg, #00b4db, #0083b0);
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .menu-card:hover::before {
            opacity: 1;
        }

        /* Floating number animation */
        @keyframes floatUpSmooth {
            0% {
                opacity: 0;
                transform: translateY(0) scale(0.8);
            }
            20% {
                opacity: 1;
                transform: translateY(-15px) scale(1.1);
            }
            100% {
                opacity: 0;
                transform: translateY(-50px) scale(0.9);
            }
        }

        @keyframes floatUp {
            0% {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
            50% {
                opacity: 1;
                transform: translateY(-30px) scale(1.2);
            }
            100% {
                opacity: 0;
                transform: translateY(-60px) scale(0.8);
            }
        }

        /* Enhanced quantity display animations */
        .qty-display {
            position: relative;
            transition: all 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94);
            overflow: hidden;
        }

        .qty-display::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.4), transparent);
            transition: left 0.5s;
        }

        .qty-display:hover::before {
            left: 100%;
        }

        .qty-btn {
            transition: all 0.3s cubic-bezier(0.25, 0.46, 0.45, 0.94);
            position: relative;
            overflow: hidden;
        }

        .qty-btn::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            background: rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            transform: translate(-50%, -50%);
            transition: width 0.3s, height 0.3s;
        }

        .qty-btn:active::after {
            width: 120%;
            height: 120%;
        }

        /* Smooth number change animation */
        @keyframes numberChange {
            0% {
                transform: translateY(0);
                opacity: 1;
            }
            50% {
                transform: translateY(-10px);
                opacity: 0.7;
            }
            100% {
                transform: translateY(0);
                opacity: 1;
            }
        }

        /* Glow pulse animation */
        @keyframes glowPulse {
            0%, 100% {
                box-shadow: 0 0 5px rgba(0, 180, 219, 0.3);
            }
            50% {
                box-shadow: 0 0 20px rgba(0, 180, 219, 0.8), 0 0 30px rgba(0, 180, 219, 0.4);
            }
        }

        /* Subtle shake animation for invalid actions */
        @keyframes subtleShake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-2px); }
            75% { transform: translateX(2px); }
        }
    </style>
</head>
<body>
    <div class="menu-container">
        <!-- Header -->
        <div class="menu-header">
            <h2><i class="bi bi-shop me-2"></i>Menu Nhà Hàng</h2>
            <div class="table-info">
                <i class="bi bi-geo-alt-fill me-2"></i>Bàn số <?= $tableNumber ?>
            </div>
        </div>

        <!-- Category Filters -->
        <div class="category-filters">
            <?php 
            $currentCategory = $_GET['category'] ?? 'all';
            
            // Lấy tất cả menu items để đếm
            require_once 'models/MenuModel.php';
            $tempModel = new MenuModel();
            $allMenuItems = $tempModel->getMenuItems();
            $allCount = count($allMenuItems);
            
            // Đếm món ăn theo từng category
            $categoryCounts = [];
            foreach ($allMenuItems as $item) {
                $catId = $item['category_id'] ?? 'uncategorized';
                $categoryCounts[$catId] = ($categoryCounts[$catId] ?? 0) + 1;
            }
            ?>
            <button onclick="filterCategory('all')" 
               class="category-btn active" data-category="all">
                <span class="icon">🍽️</span>
                <span>Tất cả</span>
                <span class="count"><?= $allCount ?></span>
            </button>
            
            <?php if (isset($categories) && !empty($categories)): ?>
                <?php foreach ($categories as $category): ?>
                    <?php $categoryCount = $categoryCounts[$category['id']] ?? 0; ?>
                    <button onclick="filterCategory('<?= $category['id'] ?>')" 
                       class="category-btn" data-category="<?= $category['id'] ?>">
                        <span class="icon"><?= htmlspecialchars($category['icon']) ?></span>
                        <span><?= htmlspecialchars($category['name']) ?></span>
                        <span class="count"><?= $categoryCount ?></span>
                    </button>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

        <!-- Menu Items -->
        <div class="menu-grid" id="menuGrid">
            <?php if (isset($allMenuItems) && !empty($allMenuItems)): ?>
                <?php foreach ($allMenuItems as $item): ?>
                <div class="menu-card" data-item-id="<?= $item['id'] ?>" data-category="<?= $item['category_id'] ?? 'uncategorized' ?>">
                    <div class="menu-image">
                        <?php 
                        $hasValidImage = false;
                        $imageSrc = '';
                        
                        if (!empty($item['image'])) {
                            // Check if it's a Cloudinary URL (starts with http)
                            if (strpos($item['image'], 'http') === 0) {
                                // For Cloudinary URLs, we'll let the browser handle validation via onerror
                                // This is more efficient than server-side HTTP requests
                                $hasValidImage = true;
                                $imageSrc = $item['image'];
                            } else {
                                // Check if it's a local file that exists
                                $imagePath = 'assets/' . $item['image'];
                                if (file_exists($imagePath)) {
                                    $hasValidImage = true;
                                    $imageSrc = $imagePath;
                                }
                            }
                        }
                        ?>
                        
                        <?php if ($hasValidImage): ?>
                            <img src="<?= htmlspecialchars($imageSrc) ?>" 
                                 alt="<?= htmlspecialchars($item['name']) ?>" 
                                 style="width: 100%; height: 100%; object-fit: cover; border-radius: 15px;"
                                 onload="handleImageLoad(this)"
                                 onerror="handleImageError(this, <?= $item['id'] ?>);"
                                 data-item-id="<?= $item['id'] ?>">
                            <div class="emoji fallback-emoji" style="display: none;">🍽️</div>
                        <?php else: ?>
                            <div class="emoji">🍽️</div>
                        <?php endif; ?>
                    </div>
                    <div class="menu-content">
                        <div class="menu-title"><?= htmlspecialchars($item['name']) ?></div>
                        <div class="menu-description"><?= htmlspecialchars($item['description'] ?? 'Món ăn ngon tại nhà hàng') ?></div>
                        <div class="menu-price"><?= number_format($item['price']) ?>đ</div>
                        
                        <div class="quantity-section">
                            <button class="qty-btn qty-minus" onclick="changeQuantity(this, -1)">−</button>
                            <div class="qty-display">0</div>
                            <button class="qty-btn qty-plus" onclick="changeQuantity(this, 1)">+</button>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12">
                    <div class="alert alert-warning">
                        <i class="bi bi-exclamation-triangle me-2"></i>
                        Hiện tại chưa có món ăn nào. Vui lòng thử lại sau!
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Small Cart Button -->
    <button class="cart-btn" onclick="toggleCart()" id="cartBtn" style="display: none;">
        <i class="bi bi-cart3"></i>
        <span class="cart-badge" id="cartBadge">0</span>
    </button>

    <!-- Floating Cart -->
    <div class="cart cart-float" id="cartFloat">
        <div class="cart-header">
            <div class="cart-title">
                <i class="bi bi-cart3 me-2"></i>Giỏ hàng của bạn
            </div>
            <button class="cart-close" onclick="closeCart()" title="Đóng giỏ hàng">
                <i class="bi bi-x"></i>
            </button>
        </div>
        <div class="cart-items" id="cartItems"></div>
        <div class="cart-total">
            <span>Tổng cộng:</span>
            <span id="totalAmount">0đ</span>
        </div>
        <button class="order-btn" onclick="submitOrder()">
            <i class="bi bi-send me-2"></i>Gửi đơn hàng
        </button>
    </div>

    <script>
        let cart = {};
        let tableNumber = <?= $tableNumber ?>;
        let cartWasEmpty = true; // Track if cart was previously empty

        console.log('Menu loaded for table:', tableNumber);

        function changeQuantity(btn, change) {
            const menuCard = btn.closest('.menu-card');
            const itemId = menuCard.getAttribute('data-item-id');
            const itemName = menuCard.querySelector('.menu-title').textContent;
            const itemPrice = parseInt(menuCard.querySelector('.menu-price').textContent.replace(/[^\d]/g, ''));
            const qtyDisplay = btn.parentElement.querySelector('.qty-display');
            let currentQty = parseInt(qtyDisplay.textContent);
            let newQty = Math.max(0, currentQty + change);
            
            // Create floating number animation
            createFloatingNumber(qtyDisplay, change);
            
            // Smooth glow and pulse effect
            qtyDisplay.style.transition = 'all 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94)';
            
            // Subtle effects based on change
            if (change > 0) {
                // Increase effect - subtle glow and gentle pulse
                qtyDisplay.style.backgroundColor = '#00b4db';
                qtyDisplay.style.color = 'white';
                qtyDisplay.style.boxShadow = '0 0 25px rgba(0, 180, 219, 0.8), inset 0 0 20px rgba(255, 255, 255, 0.2)';
                qtyDisplay.style.borderColor = '#00b4db';
                qtyDisplay.style.transform = 'scale(1.1)';
                
                // Button feedback - gentle highlight
                btn.style.transition = 'all 0.3s ease';
                btn.style.backgroundColor = '#00b4db';
                btn.style.color = 'white';
                btn.style.boxShadow = '0 0 15px rgba(0, 180, 219, 0.6)';
                btn.style.transform = 'scale(1.05)';
            } else {
                // Decrease effect - subtle red glow
                qtyDisplay.style.backgroundColor = '#e74c3c';
                qtyDisplay.style.color = 'white';
                qtyDisplay.style.boxShadow = '0 0 25px rgba(231, 76, 60, 0.8), inset 0 0 20px rgba(255, 255, 255, 0.2)';
                qtyDisplay.style.borderColor = '#e74c3c';
                qtyDisplay.style.transform = 'scale(1.1)';
                
                // Button feedback
                btn.style.transition = 'all 0.3s ease';
                btn.style.backgroundColor = '#e74c3c';
                btn.style.color = 'white';
                btn.style.boxShadow = '0 0 15px rgba(231, 76, 60, 0.6)';
                btn.style.transform = 'scale(1.05)';
            }
            
            // Update number after small delay for better visual effect
            setTimeout(() => {
                qtyDisplay.textContent = newQty;
                
                // Auto update cart
                if (newQty > 0) {
                    if (cart[itemName]) {
                        cart[itemName].quantity = newQty; // Set absolute quantity
                    } else {
                        cart[itemName] = { quantity: newQty, price: itemPrice };
                    }
                } else {
                    // Remove from cart if quantity is 0
                    if (cart[itemName]) {
                        delete cart[itemName];
                    }
                }
                
                updateCartDisplay();
            }, 150);
            
            // Reset styles with smooth transition
            setTimeout(() => {
                qtyDisplay.style.transform = 'scale(1)';
                qtyDisplay.style.backgroundColor = 'rgba(0, 180, 219, 0.2)';
                qtyDisplay.style.color = '#ffffff';
                qtyDisplay.style.boxShadow = 'none';
                qtyDisplay.style.borderColor = 'rgba(0, 180, 219, 0.3)';
                
                // Reset button
                btn.style.transform = 'scale(1)';
                btn.style.backgroundColor = 'rgba(255, 255, 255, 0.1)';
                btn.style.color = '#ffffff';
                btn.style.boxShadow = 'none';
            }, 600);
        }
        
        function createFloatingNumber(element, change) {
            const floatingNum = document.createElement('div');
            floatingNum.textContent = change > 0 ? '+1' : '-1';
            floatingNum.style.cssText = `
                position: absolute;
                font-size: 1.1rem;
                font-weight: 800;
                color: ${change > 0 ? '#00b4db' : '#e74c3c'};
                pointer-events: none;
                z-index: 1000;
                text-shadow: 0 2px 8px rgba(0,0,0,0.4);
                animation: floatUpSmooth 1s ease-out forwards;
                font-family: 'Poppins', sans-serif;
                letter-spacing: 0.5px;
            `;
            
            // Position relative to the quantity display
            const rect = element.getBoundingClientRect();
            floatingNum.style.left = (rect.left + rect.width / 2 - 8) + 'px';
            floatingNum.style.top = (rect.top - 5) + 'px';
            
            document.body.appendChild(floatingNum);
            
            // Remove after animation
            setTimeout(() => {
                if (floatingNum.parentNode) {
                    floatingNum.parentNode.removeChild(floatingNum);
                }
            }, 1000);
        }

        function addToCart(itemName, price, btn) {
            const menuCard = btn.closest('.menu-card');
            const qtyDisplay = menuCard.querySelector('.qty-display');
            const quantity = parseInt(qtyDisplay.textContent);
            
            if (quantity === 0) {
                alert('Vui lòng chọn số lượng trước khi thêm vào giỏ!');
                return;
            }

            // Add to cart
            if (cart[itemName]) {
                cart[itemName].quantity += quantity;
            } else {
                cart[itemName] = { quantity: quantity, price: price };
            }

            // Reset quantity
            qtyDisplay.textContent = '0';

            // Button feedback
            const originalText = btn.innerHTML;
            btn.innerHTML = '<i class="bi bi-check-lg me-2"></i>Đã thêm!';
            btn.style.backgroundColor = '#27ae60';
            
            setTimeout(() => {
                btn.innerHTML = originalText;
                btn.style.backgroundColor = '';
            }, 1500);

            updateCartDisplay();
        }

        function toggleCart() {
            const cartFloat = document.getElementById('cartFloat');
            const cartBtn = document.getElementById('cartBtn');
            
            if (cartFloat.classList.contains('show')) {
                // Close cart with smooth animation
                cartFloat.classList.remove('show');
                setTimeout(() => {
                    cartBtn.classList.remove('hidden');
                }, 300);
                cartWasEmpty = false; // Prevent auto-show until cart is empty again
            } else {
                // Open cart - first hide button, then expand cart from its position
                cartBtn.classList.add('hidden');
                setTimeout(() => {
                    cartFloat.classList.add('show');
                }, 150);
            }
        }

        function closeCart() {
            const cartFloat = document.getElementById('cartFloat');
            const cartBtn = document.getElementById('cartBtn');
            
            cartFloat.classList.remove('show');
            setTimeout(() => {
                cartBtn.classList.remove('hidden');
            }, 300);
            
            // Don't auto-show cart again until it's empty and refilled
            cartWasEmpty = false;
        }

        function updateCartDisplay() {
            const cartFloat = document.getElementById('cartFloat');
            const cartBtn = document.getElementById('cartBtn');
            const cartBadge = document.getElementById('cartBadge');
            const totalElement = document.getElementById('totalAmount');

            // Calculate total items in cart
            const totalItems = Object.values(cart).reduce((sum, item) => sum + item.quantity, 0);
            
            if (totalItems === 0) {
                cartBtn.style.display = 'none';
                cartFloat.classList.remove('show');
                cartWasEmpty = true;
                return;
            }

            // Show cart button and update badge
            cartBtn.style.display = 'flex';
            cartBadge.textContent = totalItems;

            // If cart was previously empty and now has items, show it automatically
            if (cartWasEmpty && totalItems > 0) {
                setTimeout(() => {
                    if (!cartFloat.classList.contains('show')) {
                        cartFloat.classList.add('show');
                        cartBtn.classList.add('hidden');
                    }
                }, 200);
                cartWasEmpty = false;
            }

            // Build cart content
            cartFloat.innerHTML = `
                <div class="cart-header">
                    <div class="cart-title">
                        <i class="bi bi-cart3 me-2"></i>Giỏ hàng của bạn
                    </div>
                    <button class="cart-close" onclick="closeCart()" title="Đóng giỏ hàng">
                        <i class="bi bi-x"></i>
                    </button>
                </div>
                <div class="cart-items" id="cartItems"></div>
                <div class="cart-total">
                    <span>Tổng cộng:</span>
                    <span id="totalAmount">0đ</span>
                </div>
                <button class="order-btn" onclick="submitOrder()">
                    <i class="bi bi-send me-2"></i>Gửi đơn hàng
                </button>
            `;

            const cartItems = document.getElementById('cartItems');
            let subtotal = 0;

            Object.entries(cart).forEach(([itemName, item]) => {
                const itemTotal = item.quantity * item.price;
                subtotal += itemTotal;

                const cartItem = document.createElement('div');
                cartItem.className = 'cart-item';
                cartItem.innerHTML = `
                    <div class="cart-item-info">
                        <div class="cart-item-name">${itemName}</div>
                        <div class="cart-item-price">${item.price.toLocaleString()}đ/phần</div>
                    </div>
                    <div class="cart-item-controls">
                        <button class="cart-qty-btn cart-qty-minus" onclick="updateCartQuantity('${itemName}', -1)">−</button>
                        <div class="cart-qty-display">${item.quantity}</div>
                        <button class="cart-qty-btn cart-qty-plus" onclick="updateCartQuantity('${itemName}', 1)">+</button>
                        <button class="cart-remove-btn" onclick="removeFromCart('${itemName}')" title="Xóa món">×</button>
                    </div>
                `;
                cartItems.appendChild(cartItem);
            });

            // Service fee
            const serviceFee = 10000;
            const serviceItem = document.createElement('div');
            serviceItem.className = 'cart-item';
            serviceItem.style.borderTop = '1px solid rgba(255,255,255,0.1)';
            serviceItem.style.marginTop = '10px';
            serviceItem.style.paddingTop = '10px';
            serviceItem.innerHTML = `
                <div class="cart-item-info">
                    <div class="cart-item-name">Phí phục vụ</div>
                </div>
                <div class="cart-item-controls">
                    <div style="color: #00b4db; font-weight: 600;">${serviceFee.toLocaleString()}đ</div>
                </div>
            `;
            cartItems.appendChild(serviceItem);

            const finalTotal = subtotal + serviceFee;
            document.getElementById('totalAmount').textContent = finalTotal.toLocaleString() + 'đ';
        }

        function updateCartQuantity(itemName, change) {
            if (!cart[itemName]) return;
            
            cart[itemName].quantity += change;
            
            if (cart[itemName].quantity <= 0) {
                delete cart[itemName];
            }
            
            // Update corresponding menu item display
            updateMenuItemQuantity(itemName);
            
            updateCartDisplay();
        }

        function removeFromCart(itemName) {
            if (cart[itemName]) {
                delete cart[itemName];
                
                // Reset menu item quantity display
                updateMenuItemQuantity(itemName);
                
                updateCartDisplay();
            }
        }

        function updateMenuItemQuantity(itemName) {
            // Find and update the corresponding menu item quantity display
            const menuCards = document.querySelectorAll('.menu-card');
            
            menuCards.forEach(card => {
                const cardItemName = card.querySelector('.menu-title').textContent;
                if (cardItemName === itemName) {
                    const qtyDisplay = card.querySelector('.qty-display');
                    const newQty = cart[itemName] ? cart[itemName].quantity : 0;
                    qtyDisplay.textContent = newQty;
                }
            });
        }

        function submitOrder() {
            if (Object.keys(cart).length === 0) {
                alert('Giỏ hàng trống! Vui lòng chọn món ăn.');
                return;
            }

            const totalAmount = Object.values(cart).reduce((sum, item) => sum + (item.quantity * item.price), 0);
            const serviceFee = 10000;
            const finalTotal = totalAmount + serviceFee;

            const orderData = {
                tableNumber: tableNumber,
                items: cart,
                totalAmount: totalAmount,
                serviceFee: serviceFee,
                finalTotal: finalTotal,
                note: ''
            };

            console.log('Submitting order:', orderData);

            const orderBtn = document.querySelector('.order-btn');
            orderBtn.disabled = true;
            orderBtn.innerHTML = '<i class="bi bi-hourglass-split me-2"></i>Đang gửi...';

            fetch('index.php?controller=order&action=create', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(orderData)
            })
            .then(response => {
                console.log('Response status:', response.status);
                return response.text().then(text => {
                    console.log('Response text:', text);
                    try {
                        return JSON.parse(text);
                    } catch (e) {
                        throw new Error('Server returned invalid response: ' + text);
                    }
                });
            })
            .then(data => {
                console.log('Order response:', data);
                if (data.success) {
                    alert(`✅ Đặt hàng thành công!\n\nMã đơn hàng: ${data.orderId || 'N/A'}\nĐơn hàng đã được gửi đến bếp và sẽ được chuẩn bị sớm nhất có thể.`);
                    cart = {};
                    
                    // Reset all quantity displays
                    document.querySelectorAll('.qty-display').forEach(display => {
                        display.textContent = '0';
                    });
                    
                    updateCartDisplay();
                } else {
                    throw new Error(data.message || 'Có lỗi xảy ra khi đặt hàng');
                }
            })
            .catch(error => {
                console.error('Error submitting order:', error);
                alert('❌ Có lỗi xảy ra khi gửi đơn hàng:\n' + error.message + '\n\nVui lòng thử lại hoặc gọi nhân viên hỗ trợ.');
            })
            .finally(() => {
                orderBtn.disabled = false;
                orderBtn.innerHTML = '<i class="bi bi-send me-2"></i>Gửi đơn hàng';
            });
        }

        // Initialize
        document.addEventListener('DOMContentLoaded', function() {
            console.log('Menu page initialized for table ' + tableNumber);
        });

        // Category filtering function
        function filterCategory(categoryId) {
            const menuCards = document.querySelectorAll('.menu-card');
            const categoryBtns = document.querySelectorAll('.category-btn');
            
            // Update active button
            categoryBtns.forEach(btn => {
                btn.classList.remove('active');
                if (btn.getAttribute('data-category') === categoryId) {
                    btn.classList.add('active');
                }
            });
            
            // Filter menu items with smooth animation
            menuCards.forEach((card, index) => {
                const cardCategory = card.getAttribute('data-category');
                const shouldShow = categoryId === 'all' || cardCategory === categoryId;
                
                if (shouldShow) {
                    card.style.display = 'block';
                    card.style.opacity = '0';
                    card.style.transform = 'translateY(20px)';
                    
                    // Staggered animation
                    setTimeout(() => {
                        card.style.transition = 'all 0.4s ease';
                        card.style.opacity = '1';
                        card.style.transform = 'translateY(0)';
                    }, index * 50);
                } else {
                    card.style.transition = 'all 0.3s ease';
                    card.style.opacity = '0';
                    card.style.transform = 'translateY(-20px)';
                    
                    setTimeout(() => {
                        card.style.display = 'none';
                    }, 300);
                }
            });
        }

        // Handle image loading errors
        function handleImageError(imgElement, itemId) {
            console.log('Image loading failed for item ID:', itemId, 'URL:', imgElement.src);
            
            // Hide the broken image and show fallback emoji
            imgElement.style.display = 'none';
            const fallbackEmoji = imgElement.nextElementSibling;
            if (fallbackEmoji && fallbackEmoji.classList.contains('fallback-emoji')) {
                fallbackEmoji.style.display = 'flex';
                fallbackEmoji.style.alignItems = 'center';
                fallbackEmoji.style.justifyContent = 'center';
                fallbackEmoji.style.fontSize = '2rem';
            }

            // Send request to server to clean up invalid image URL in database
            // This helps prevent future attempts to load the broken image
            fetch('?controller=admin&action=cleanupInvalidImage', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    itemId: itemId,
                    imageUrl: imgElement.src
                })
            }).then(response => response.json())
            .then(data => {
                if (data.success) {
                    console.log('✅ Invalid image URL cleaned from database for item', itemId);
                }
            }).catch(error => {
                console.log('Could not clean up invalid image URL:', error);
            });
        }

        // Handle successful image loads (for debugging)
        function handleImageLoad(imgElement) {
            const itemId = imgElement.getAttribute('data-item-id');
            console.log('✅ Image loaded successfully for item', itemId);
        }

        // Set timeout for images that take too long to load
        document.addEventListener('DOMContentLoaded', function() {
            const images = document.querySelectorAll('img[data-item-id]');
            images.forEach(img => {
                const timeout = setTimeout(() => {
                    if (!img.complete || img.naturalHeight === 0) {
                        console.log('Image timeout for item', img.getAttribute('data-item-id'));
                        handleImageError(img, img.getAttribute('data-item-id'));
                    }
                }, 10000); // 10 second timeout
                
                img.addEventListener('load', () => {
                    clearTimeout(timeout);
                });
                
                img.addEventListener('error', () => {
                    clearTimeout(timeout);
                });
            });
        });
    </script>
</body>
</html>
