# 🍽️ Restaurant Ordering System

Modern restaurant ordering system with beautiful Riday admin dashboard, real-time updates, and Cloudinary image management.

## ✨ Features

- 🎨 **Beautiful Riday Dashboard** - Modern admin interface with dark/light theme
- 📱 **Responsive Design** - Works perfectly on mobile and desktop
- 🖼️ **Cloudinary Integration** - Professional image management
- ⚡ **Real-time Updates** - Live order tracking and notifications
- 🔍 **Global Search** - Find menu items instantly
- 📊 **Analytics Dashboard** - Order statistics and insights
- 🛡️ **Production Ready** - Secure, optimized for deployment

## 🚀 Live Demo

**Admin Dashboard:** [https://ridayrestaurant.byethost7.com/?controller=auth&action=login](https://ridayrestaurant.byethost7.com/?controller=auth&action=login)

**Customer Menu:** [https://ridayrestaurant.byethost7.com/index.php?controller=restaurant&action=menu](https://ridayrestaurant.byethost7.com/index.php?controller=restaurant&action=menu)

## 🛠️ Tech Stack

- **Backend:** PHP 8.1+, PDO
- **Database:** MySQL (ByetHost / Local)
- **Frontend:** Bootstrap 5.3, Vanilla JS
- **Images:** Cloudinary API
- **Deployment:** ByetHost (recommended)

## 📦 Quick Deploy to ByetHost

1. **Fork or download this repository**
2. **Create a free hosting account on ByetHost:**
   - Visit https://byet.host and sign up for a free hosting account
3. **Create a MySQL database in the ByetHost control panel:**
   - Note the provided DB host, DB name, username and password
4. **Upload project files:**
   - Use FTP (FileZilla) or the ByetHost File Manager to upload the repository files to your account's web root (e.g. `htdocs` or `public_html`)
5. **Configure database credentials:**
   - Edit `config.php` and set the `DB_HOST`, `DB_NAME`, `DB_USER`, `DB_PASS` values (or use environment variables if your host supports them)
6. **Import database schema:**
   - Use phpMyAdmin (available in ByetHost control panel) to import `restaurant_ordering.sql` or run the provided migration script
7. **Verify PHP version and permissions:**
   - Ensure PHP >= 8.1 is selected in the control panel and `uploads/` is writable
8. **Visit your site:**
   - Open the ByetHost URL assigned to your account or your custom domain

## 🔧 Local Development

### Prerequisites
- PHP 8.1+
- MySQL 5.7+
- Composer (optional)

### Setup
1. **Clone repository:**
   ```bash
   git clone https://github.com/yourusername/restaurant-ordering-system.git
   cd restaurant-ordering-system
   ```

2. **Configure database:**
   - Create MySQL database `restaurant_ordering`
   - Update credentials in `config.php`

3. **Setup database:**
   ```bash
   php migrate_database.php
   ```

4. **Run development server:**
   ```bash
   php -S localhost:8000
   ```

5. **Access application:**
   - Customer Menu: http://localhost:8000/index.php?controller=restaurant&action=menu
   - Admin Dashboard: https://ridayrestaurant.byethost7.com/?controller=auth&action=login

## 📁 Project Structure

```
Restaurant_Ordering/
├── 📁 config/                   # Global configuration files
│   ├── cloudinary.php          # Cloudinary API configuration
│   └── table_config.php        # Table management settings
├── 📁 controllers/              # Main application controllers
│   ├── AdminController.php     # Admin functionality
│   ├── OrderController.php     # Order processing
│   └── RestaurantController.php # Restaurant operations
├── 📁 database/                 # Database files
│   └── restaurant.db           # SQLite database
├── 📁 models/                   # Data models and API handlers
│   ├── CloudinaryAPI.php       # Cloudinary integration
│   ├── DB.php                   # Database connection
│   ├── MenuModel.php           # Menu data operations
│   ├── OrderModel.php          # Order data operations
│   └── TableHelper.php         # Table management utilities
├── 📁 views/                    # UI templates and pages
│   ├── admin_menu.php          # Admin menu management
│   ├── menu_dynamic.php        # Dynamic customer menu
│   ├── menu_view.php           # Static menu view
│   ├── order_dashboard.php     # Order management dashboard
│   ├── restaurant_home.php     # Restaurant homepage
│   ├── restaurant_layout.php   # Base layout template
│   ├── riday_dashboard.php     # Modern Riday admin dashboard
│   └── table_management.php    # Table management interface
├── 📁 restaurant-ordering-system/  # Complete modular system
│   ├── 📁 backend/             # API backend
│   │   ├── 📁 api/             # REST API endpoints
│   │   │   ├── auth.php        # Authentication API
│   │   │   ├── menu.php        # Menu API
│   │   │   ├── orders.php      # Orders API
│   │   │   └── tables.php      # Tables API
│   │   ├── 📁 config/          # Backend configuration
│   │   │   ├── app.php         # Application settings
│   │   │   └── database.php    # Database configuration
│   │   ├── 📁 controllers/     # Backend controllers
│   │   │   ├── AuthController.php    # User authentication
│   │   │   ├── MenuController.php    # Menu management
│   │   │   ├── OrderController.php   # Order processing
│   │   │   └── TableController.php   # Table management
│   │   ├── 📁 middleware/      # Request middleware
│   │   │   ├── Auth.php        # Authentication middleware
│   │   │   └── CORS.php        # Cross-origin requests
│   │   ├── 📁 models/          # Data models
│   │   │   ├── Menu.php        # Menu model
│   │   │   ├── Order.php       # Order model
│   │   │   ├── Table.php       # Table model
│   │   │   └── User.php        # User model
│   │   └── 📁 uploads/         # File uploads directory
│   ├── 📁 admin-dashboard/     # Admin web interface
│   │   ├── 📁 assets/          # Admin dashboard assets
│   │   │   ├── css/            # Stylesheets
│   │   │   ├── js/             # JavaScript files
│   │   │   └── images/         # Admin images
│   │   ├── � views/           # Admin dashboard views
│   │   │   ├── dashboard.php           # Main dashboard
│   │   │   ├── menu-management.php     # Menu management
│   │   │   ├── order-management.php    # Order management
│   │   │   └── table-management.php    # Table management
│   │   └── index.php           # Admin dashboard entry point
│   ├── � customer-app/        # Customer web application
│   │   ├── 📁 assets/          # Customer app assets
│   │   │   ├── css/            # Customer stylesheets
│   │   │   ├── js/             # Customer JavaScript
│   │   │   └── images/         # Customer images
│   │   ├── 📁 views/           # Customer app views
│   │   │   ├── menu.php        # Menu browsing
│   │   │   ├── cart.php        # Shopping cart
│   │   │   ├── checkout.php    # Order checkout
│   │   │   └── order-status.php # Order tracking
│   │   └── index.php           # Customer app entry point
│   ├── 📁 database/            # Database management
│   │   ├── � migrations/      # Database schema migrations
│   │   │   ├── create_menu.sql      # Menu table schema
│   │   │   ├── create_orders.sql    # Orders table schema
│   │   │   └── create_tables.sql    # Tables schema
│   │   └── 📁 seeds/           # Sample data
│   │       ├── menu_items.sql       # Sample menu items
│   │       └── sample_data.sql      # Other sample data
│   ├── 📁 public/              # Public web assets
│   │   ├── 📁 uploads/         # User uploaded files
│   │   │   └── menu-images/    # Menu item images
│   │   └── 📁 qr-codes/        # Generated QR codes
│   ├── � qr-generator/        # QR code generation system
│   │   ├── generate.php        # QR generation script
│   │   ├── table-qr-template.html   # QR code template
│   │   └── 📁 qr-codes/        # Generated QR codes storage
│   └── 📁 shared/              # Shared utilities and constants
│       ├── 📁 constants/       # Application constants
│       └── 📁 utils/           # Utility functions
├── 📄 index.php                # Main application entry point
├── 📄 config.php               # Global configuration
├── 📄 qr_generator.php         # QR code generator utility
├── 📄 restaurant_ordering.sql  # Database schema
├── 📄 composer.json            # PHP dependencies
├── 📄 README.md               # Project documentation
├── 📄 .env.example            # Environment variables template
├── 📄 .htaccess               # Apache configuration
└── 📄 .gitignore              # Git ignore rules
```

### 🏗️ Architecture Overview

**Dual System Architecture:**
- **Legacy System** (root level): Original monolithic application with MVC pattern
- **Modern System** (`restaurant-ordering-system/`): Modular, API-driven architecture

**Key Components:**
- **Backend API**: RESTful services for all operations
- **Admin Dashboard**: Management interface for restaurant staff  
- **Customer App**: Public ordering interface
- **QR System**: Table-specific QR code generation
- **Database**: Flexible schema supporting both systems

## 🎯 Key Features

### Admin Dashboard
- 📊 Real-time order statistics
- 🍽️ Menu management with image upload
- 🌓 Dark/Light theme toggle
- 🔍 Global search functionality
- 📱 Mobile-responsive design

### Customer Interface
- 📖 Interactive menu browsing
- 🛒 Easy order placement
- 📱 Mobile-optimized experience

### Technical
- 🔐 Production-ready security
- 🚀 Optimized performance
- 🐳 Easy deployment
- 🔧 Environment-based configuration

## 🌐 Environment Variables

### Required for Cloudinary:
```env
CLOUDINARY_CLOUD_NAME=your_cloud_name
CLOUDINARY_API_KEY=your_api_key
CLOUDINARY_API_SECRET=your_api_secret
```

### Database (ByetHost / MySQL example):
```env
DB_HOST=sql110.byethost7.com
DB_NAME=b7_39805051_restaurant_ordering
DB_USER=b7_39805051
DB_PASS=your_db_password
```

## 🚀 Deployment

### ByetHost (Recommended)
1. Create a ByetHost account at https://byet.host
2. Create a MySQL database from the control panel and note credentials
3. Upload the project files to your account's web root using FTP or File Manager
4. Update `config.php` (or environment variables) with your DB credentials
5. Import `restaurant_ordering.sql` via phpMyAdmin
6. Select PHP >= 8.1 and test the site URL provided by ByetHost

### Other Platforms
- See `DEPLOYMENT_GUIDE.md` for detailed instructions
- Supports any PHP hosting with a MySQL database

## 🤝 Contributing

1. Fork the repository
2. Create feature branch
3. Make changes
4. Submit pull request

## 📄 License

MIT License - feel free to use for personal or commercial projects.

## 🆘 Support

- 📧 **Issues:** Use GitHub Issues
- 📖 **Documentation:** Check `DEPLOYMENT_GUIDE.md`
- 🔍 **Health Check:** Visit `/system_check.php`

---

⭐ **Star this repository if it helped you!**
