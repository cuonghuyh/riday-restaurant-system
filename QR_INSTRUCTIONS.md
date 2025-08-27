# QR Code Generator cho Restaurant

Sau khi deploy lên Render, bạn có thể tạo QR code theo cách sau:

## Cách 1: Truy cập QR Generator
- URL: `https://your-domain.onrender.com/?qr_generator=1`
- Hoặc: `https://your-domain.onrender.com/qr_generator.php`

## Cách 2: Tạo QR thủ công
Sử dụng các trang web tạo QR code miễn phí:
- [QR Code Generator](https://www.qr-code-generator.com/)
- [QR Code Monkey](https://www.qrcode-monkey.com/)

### URL cho từng bàn:
- Bàn 1: `https://your-domain.onrender.com/?table=1`
- Bàn 2: `https://your-domain.onrender.com/?table=2`
- Bàn 3: `https://your-domain.onrender.com/?table=3`
- ...và cứ thế

## Lưu ý khi deploy lên Render:
1. Thay `your-domain` bằng tên domain thực tế từ Render
2. Test URL trước khi tạo QR code
3. In QR code với kích thước đủ lớn để dễ quét (ít nhất 3x3cm)
4. Dán QR code lên từng bàn tương ứng

## Cách sử dụng:
1. Khách hàng quét QR code
2. Tự động chuyển đến menu với số bàn đã được set
3. Khách hàng chọn món và đặt hàng
