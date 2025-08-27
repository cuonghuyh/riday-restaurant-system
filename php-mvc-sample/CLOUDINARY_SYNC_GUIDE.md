# SETUP ĐỒNG BỘ CLOUDINARY - HƯỚNG DẪN HOÀN CHỈNH

## 🎯 Mục tiêu
Khi xóa ảnh trên Cloudinary → Ảnh tự động biến mất khỏi menu (đồng bộ 100%)

## 🔧 Cách 1: Webhook Cloudinary (Tự động - Recommended)

### Bước 1: Setup webhook trên Cloudinary Dashboard
1. Đăng nhập Cloudinary console: https://console.cloudinary.com
2. Vào **Settings** → **Webhooks**
3. Tạo webhook mới:
   - **Notification URL**: `https://yourdomain.com/webhook_cloudinary.php`
   - **Events**: Chọn `delete` và `upload`
   - **Security**: Tạo webhook signature secret (optional)

### Bước 2: Deploy webhook file
File `webhook_cloudinary.php` đã được tạo sẵn. Cần:
1. Upload lên server production
2. Đảm bảo URL public accessible
3. Test webhook bằng cách xóa ảnh trên Cloudinary

## 🔧 Cách 2: Auto-cleanup Frontend (Đã implement)

### Tính năng đã có:
✅ **Auto-detect broken images**: Khi ảnh lỗi 404 → tự động thay placeholder
✅ **Auto-clear database**: Gọi API để xóa URL lỗi khỏi database  
✅ **Instant UI update**: Menu update ngay lập tức không cần refresh

### Hoạt động như thế nào:
```javascript
// Trong riday_dashboard.php
<img onerror="this.style.display='none'; 
              this.parentElement.innerHTML='<i class=\"bi bi-camera text-muted\"></i>'; 
              handleBrokenImage(${item.id});">

// Function handleBrokenImage sẽ:
// 1. Gọi API clearBrokenImage 
// 2. Xóa URL khỏi database
// 3. Update local menuItems array
```

## 🧪 Test thử:

### Test Cách 2 (Frontend auto-cleanup):
1. Vào Cloudinary console
2. Xóa 1 ảnh bất kỳ của món ăn
3. Refresh trang admin dashboard
4. **Kết quả mong đợi**: Ảnh tự động thay thành icon camera và URL bị xóa khỏi database

### Kiểm tra database:
```bash
php check_image_urls.php
```

## 🎉 Kết quả cuối cùng:
- ✅ Xóa ảnh trên Cloudinary = Ảnh biến mất khỏi menu
- ✅ Database luôn clean (không còn broken URLs)  
- ✅ UI luôn consistent (hiện placeholder thay vì ảnh lỗi)
- ✅ Performance tối ưu (không load ảnh 404)

## 📝 Notes:
- Cách 1 (Webhook) = Real-time, cần setup server
- Cách 2 (Frontend) = Lazy loading, work everywhere
- Recommend: Dùng cả 2 cách để đảm bảo 100% sync
