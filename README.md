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

**Admin Dashboard:** [https://your-app.render.com/index.php?controller=restaurant&action=ridayDashboard](https://your-app.render.com/index.php?controller=restaurant&action=ridayDashboard)

**Customer Menu:** [https://your-app.render.com/index.php?controller=restaurant&action=menu](https://your-app.render.com/index.php?controller=restaurant&action=menu)

## 🛠️ Tech Stack

- **Backend:** PHP 8.1+, PDO
- **Database:** PostgreSQL (Render) / MySQL (Local)
- **Frontend:** Bootstrap 5.3, Vanilla JS
- **Images:** Cloudinary API
- **Deployment:** Render.com

## 📦 Quick Deploy to Render

1. **Fork this repository**
2. **Connect to Render:**
   - Go to [Render.com](https://render.com)
   - Create new Web Service
   - Connect your GitHub repository
   - Render will auto-detect PHP and use `render.yaml` config

3. **Add Environment Variables in Render Dashboard:**
   ```
   CLOUDINARY_CLOUD_NAME=your_cloud_name
   CLOUDINARY_API_KEY=your_api_key
   CLOUDINARY_API_SECRET=your_api_secret
   ```

4. **Database will be auto-created** via `render.yaml`
5. **Deploy!** - Render will automatically run migrations

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
   - Admin Dashboard: http://localhost:8000/index.php?controller=restaurant&action=ridayDashboard

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

### Database (Auto-configured on Render):
```env
DATABASE_URL=postgres://user:pass@host:port/dbname
```

## 🚀 Deployment

### Render.com (Recommended)
1. Connect GitHub repository
2. Set environment variables
3. Deploy automatically

### Other Platforms
- See `DEPLOYMENT_GUIDE.md` for detailed instructions
- Supports any PHP hosting with database

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
