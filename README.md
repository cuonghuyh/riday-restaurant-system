# 🍜 Restaurant Ordering System

## 📋 Mô tả
Hệ thống đặt món ăn online cho nhà hàng được xây dựng bằng PHP MVC pattern với tích hợp Cloudinary để lưu trữ hình ảnh trên cloud.

## 🏗️ Cấu trúc dự án

```
php-mvc-sample/
├── 📄 index.php              # Entry point và routing chính
├── 📄 config.php             # Cấu hình database và timezone
├── 📄 .htaccess              # URL rewriting cho clean URLs
├── 📄 composer.json          # Dependencies và autoload
├── 📄 PROJECT_OVERVIEW.md    # Tài liệu chi tiết dự án
│
├── 📁 config/
│   └── cloudinary.php        # Cấu hình Cloudinary API
│
├── 📁 controllers/           # Business logic controllers
│   ├── AdminController.php   # Quản lý admin (CRUD menu, upload ảnh)
│   ├── OrderController.php   # Xử lý đơn hàng và dashboard
│   └── RestaurantController.php # Trang chủ và menu khách hàng
│
├── 📁 models/                # Data access layer
│   ├── DB.php                # Database connection singleton
│   ├── MenuModel.php         # CRUD operations cho menu
│   ├── OrderModel.php        # CRUD operations cho orders
│   ├── RestaurantModel.php   # Thông tin nhà hàng
│   └── CloudinaryAPI.php     # Wrapper cho Cloudinary API
│
├── 📁 views/                 # Presentation layer
│   ├── restaurant_layout.php # Layout chính với Bootstrap 5
│   ├── restaurant_home.php   # Trang chủ khách hàng
│   ├── menu_view.php         # Hiển thị menu cho khách
│   ├── menu_dynamic.php      # Menu với dynamic loading
│   ├── admin_menu.php        # Quản lý menu cho admin
│   └── order_dashboard.php   # Dashboard realtime cho nhà bếp
│
└── 📁 assets/                # Static resources
    ├── css/
    │   └── style.css         # Custom styles
    └── images/               # Local image storage (fallback)
```

## ⚙️ Tính năng chính

### 👥 **Khách hàng:**
- ✅ Xem menu với hình ảnh cloud
- ✅ Đặt món theo số bàn
- ✅ Responsive design (mobile-friendly)
- ✅ Real-time order tracking

### 👨‍💼 **Admin:**
- ✅ CRUD menu items
- ✅ Upload/quản lý hình ảnh (Cloudinary)
- ✅ Quản lý trạng thái món ăn
- ✅ Thống kê đơn hàng

### 👨‍🍳 **Nhà bếp:**
- ✅ Dashboard realtime orders
- ✅ Cập nhật trạng thái đơn hàng
- ✅ Thông báo âm thanh
- ✅ Auto-refresh

## 🛠️ Tech Stack

- **Backend:** PHP 8.0+ với MVC pattern
- **Database:** MySQL với foreign key constraints
- **Frontend:** Bootstrap 5 + Vanilla JavaScript
- **Cloud Storage:** Cloudinary API
- **Styling:** CSS3 với glass morphism effects

## 🚀 Setup

1. **Database:** Import schema vào MySQL
2. **Config:** Cập nhật `config.php` với DB credentials
3. **Cloudinary:** Cấu hình `config/cloudinary.php` (optional)
4. **Permissions:** Set quyền ghi cho `assets/images/`
5. **Web Server:** Point document root tới thư mục project

## 🔗 URLs

- `/` - Trang chủ khách hàng
- `/index.php?controller=admin&action=menu` - Admin panel
- `/index.php?controller=order&action=dashboard` - Kitchen dashboard

## 📝 Notes

- Timezone: Asia/Ho_Chi_Minh (UTC+7)
- Image storage: Cloudinary với fallback local
- Responsive: Bootstrap 5 mobile-first
- Real-time: JavaScript polling cho orders

---
**Version:** 1.0 | **Author:** Restaurant Team | **License:** MIT
