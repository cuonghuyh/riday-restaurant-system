# 🍜 Riday Restaurant - Deploy Guide

## 🚀 Deploy lên Render.com

### 📋 **Bước 1: Chuẩn bị**

1. **Tạo tài khoản GitHub** (nếu chưa có)
2. **Tạo tài khoản Render**: https://render.com
3. **Cài Docker Desktop** (nếu muốn test local): https://docker.com

---

### 📤 **Bước 2: Push code lên GitHub**

```bash
# 1. Initialize git repository
git init

# 2. Add all files
git add .

# 3. Commit
git commit -m "Initial commit: Riday Restaurant Ordering System"

# 4. Add remote repository (tạo repo trên GitHub trước)
git remote add origin https://github.com/YOUR_USERNAME/riday-restaurant.git

# 5. Push to GitHub
git push -u origin main
```

---

### 🌐 **Bước 3: Deploy trên Render**

1. **Đăng nhập Render** → Connect GitHub account

2. **Tạo Web Service**:
   - Click "New" → "Web Service"
   - Connect GitHub repo: `riday-restaurant`
   - Branch: `main`
   - Environment: `Docker`
   - Plan: `Free` (đủ để test)

3. **Environment Variables**:
   ```
   DB_HOST=dpg-xxxxx.oregon-postgres.render.com
   DB_NAME=riday_restaurant_db  
   DB_USER=riday_user
   DB_PASS=[auto-generated-password]
   APP_ENV=production
   APP_DEBUG=false
   ```

4. **Tạo Database**:
   - New → PostgreSQL
   - Name: `riday-restaurant-db`
   - Plan: Free
   - Copy connection details vào Environment Variables

---

### 🗄️ **Bước 4: Setup Database**

1. **Connect to PostgreSQL** (từ Render dashboard)
2. **Run SQL commands**:

```sql
-- Create menu table
CREATE TABLE menu (
    id SERIAL PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    description TEXT,
    image_url VARCHAR(500),
    category VARCHAR(100),
    is_available BOOLEAN DEFAULT true,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Create orders table  
CREATE TABLE orders (
    id SERIAL PRIMARY KEY,
    table_number INTEGER NOT NULL,
    customer_name VARCHAR(255),
    items TEXT NOT NULL, -- JSON format
    total_amount DECIMAL(10,2) NOT NULL,
    status VARCHAR(50) DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Insert sample menu items
INSERT INTO menu (name, price, description, category) VALUES
('Phở Bò', 65000, 'Phở bò truyền thống Hà Nội', 'Món chính'),
('Bún Chả', 55000, 'Bún chả nướng thơm ngon', 'Món chính'),
('Chả Cá Lã Vọng', 85000, 'Đặc sản Hà Nội', 'Món chính'),
('Bia Hơi', 15000, 'Bia tươi mát lạnh', 'Đồ uống'),
('Nước Chanh', 20000, 'Chanh tươi mát', 'Đồ uống');
```

---

### 🔧 **Bước 5: Cập nhật Database Connection**

Sau khi deploy, cập nhật `config.php` với thông tin database từ Render:

```php
// Update these values với thông tin từ Render Dashboard
define('DB_HOST', 'your-postgres-host.oregon-postgres.render.com');
define('DB_NAME', 'riday_restaurant_db');
define('DB_USER', 'riday_user');  
define('DB_PASS', 'your-generated-password');
```

---

### 📱 **Bước 6: Tạo QR Codes**

1. **Truy cập website deployed**: `https://riday-restaurant.onrender.com`

2. **Tạo QR codes**: 
   - Vào: `https://riday-restaurant.onrender.com/qr_generator.php`
   - Nhập domain của bạn
   - Chọn số bàn cần tạo
   - Click "Tạo QR Codes"
   - Download và in QR codes

3. **Test QR codes**:
   - Quét QR bằng điện thoại
   - Xem có vào đúng website + số bàn không

---

### 🎯 **Kết quả cuối cùng**

- **Website**: `https://riday-restaurant.onrender.com`
- **QR Bàn 1**: `https://riday-restaurant.onrender.com/index.php?table=1`  
- **QR Bàn 2**: `https://riday-restaurant.onrender.com/index.php?table=2`
- **Admin Panel**: `https://riday-restaurant.onrender.com/views/riday_dashboard.php`

---

### 🔧 **Troubleshooting**

**Lỗi Database Connection**:
- Kiểm tra Environment Variables trên Render
- Đảm bảo PostgreSQL service đang chạy

**Lỗi Deploy**:
- Check Build Logs trên Render Dashboard
- Đảm bảo Dockerfile syntax đúng

**QR Code không hoạt động**:
- Kiểm tra URL có đúng format không
- Test bằng cách vào trực tiếp URL

---

### 📞 **Support**

Nếu gặp lỗi, check:
1. **Render Dashboard** → Logs
2. **GitHub repo** → Issues
3. **Browser Console** → Errors

**Happy Coding!** 🎉🍜
