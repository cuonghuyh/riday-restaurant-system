<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>🍜 QR Code Generator - Riday Restaurant</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        body { 
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .container { padding-top: 2rem; }
        .qr-card { 
            background: white; 
            border-radius: 20px; 
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
            margin-bottom: 2rem;
            overflow: hidden;
            transition: transform 0.3s ease;
        }
        .qr-card:hover { transform: translateY(-5px); }
        .qr-code { text-align: center; padding: 2rem; }
        .table-info { 
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white; 
            padding: 2rem; 
            text-align: center;
        }
        .table-info h2 { margin: 0; font-weight: bold; }
        .table-info p { margin: 0.5rem 0 0 0; opacity: 0.9; }
        .download-btn { margin-top: 1.5rem; }
        .settings-card {
            background: white;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
            margin-bottom: 2rem;
        }
        .btn { border-radius: 50px; padding: 0.75rem 2rem; }
        @media print {
            body { background: white !important; }
            .no-print { display: none !important; }
            .qr-card { 
                break-inside: avoid; 
                page-break-inside: avoid; 
                margin-bottom: 3cm; 
                box-shadow: none;
                border: 2px solid #333;
            }
        }
        .hero-title {
            color: white;
            text-align: center;
            margin-bottom: 2rem;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
        }
        .qr-preview {
            max-width: 250px;
            border: 3px solid #f8f9fa;
            border-radius: 15px;
            padding: 10px;
            background: white;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="hero-title">
            <h1><i class="fas fa-utensils"></i> Riday Restaurant</h1>
            <h3>🍜 QR Code Generator cho các bàn</h3>
        </div>
        
        <!-- Settings Panel -->
        <div class="settings-card no-print">
            <div class="card-header bg-primary text-white text-center py-3">
                <h4 class="mb-0"><i class="fas fa-cog"></i> Cài đặt QR Code</h4>
            </div>
            <div class="card-body p-4">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label"><i class="fas fa-globe"></i> Domain của bạn:</label>
                        <input type="text" id="domainInput" class="form-control" 
                               value="https://riday-restaurant.onrender.com" 
                               placeholder="https://your-app.onrender.com">
                    </div>
                    <div class="col-md-3 mb-3">
                        <label class="form-label"><i class="fas fa-play"></i> Bàn bắt đầu:</label>
                        <input type="number" id="startTable" class="form-control" value="1" min="1">
                    </div>
                    <div class="col-md-3 mb-3">
                        <label class="form-label"><i class="fas fa-stop"></i> Bàn kết thúc:</label>
                        <input type="number" id="endTable" class="form-control" value="10" min="1">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label"><i class="fas fa-store"></i> Tên nhà hàng:</label>
                        <input type="text" id="restaurantName" class="form-control" value="Riday Restaurant">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label"><i class="fas fa-expand-alt"></i> Kích thước QR:</label>
                        <select id="qrSize" class="form-select">
                            <option value="200">200x200 (Nhỏ)</option>
                            <option value="300" selected>300x300 (Trung bình)</option>
                            <option value="400">400x400 (Lớn)</option>
                        </select>
                    </div>
                </div>
                <div class="text-center mt-4">
                    <button class="btn btn-primary btn-lg me-2" onclick="generateQRCodes()">
                        <i class="fas fa-magic"></i> Tạo QR Codes
                    </button>
                    <button class="btn btn-success btn-lg me-2" onclick="printQRCodes()">
                        <i class="fas fa-print"></i> In tất cả
                    </button>
                    <button class="btn btn-info btn-lg" onclick="downloadAllQR()">
                        <i class="fas fa-download"></i> Tải về tất cả
                    </button>
                </div>
            </div>
        </div>

        <!-- QR Codes Display -->
        <div id="qrCodesContainer" class="row">
            <!-- QR codes sẽ được tạo ở đây -->
        </div>
        
        <div class="text-center text-white mt-4 no-print">
            <p><i class="fas fa-info-circle"></i> Sau khi tạo QR codes, in và dán lên từng bàn để khách hàng quét đặt món!</p>
        </div>
    </div>

    <script>
        function generateQRCodes() {
            const domain = document.getElementById('domainInput').value.trim();
            const startTable = parseInt(document.getElementById('startTable').value);
            const endTable = parseInt(document.getElementById('endTable').value);
            const restaurantName = document.getElementById('restaurantName').value.trim();
            const qrSize = document.getElementById('qrSize').value;
            
            if (!domain) {
                alert('❌ Vui lòng nhập domain của bạn!');
                return;
            }
            
            if (startTable > endTable) {
                alert('❌ Bàn bắt đầu phải nhỏ hơn bàn kết thúc!');
                return;
            }
            
            const container = document.getElementById('qrCodesContainer');
            container.innerHTML = '';
            
            for (let tableNum = startTable; tableNum <= endTable; tableNum++) {
                const qrURL = `${domain}/index.php?table=${tableNum}`;
                const qrImageURL = `https://api.qrserver.com/v1/create-qr-code/?size=${qrSize}x${qrSize}&data=${encodeURIComponent(qrURL)}&format=PNG&margin=20&bgcolor=FFFFFF&color=000000`;
                
                const qrCard = `
                    <div class="col-lg-4 col-md-6">
                        <div class="qr-card">
                            <div class="table-info">
                                <h2><i class="fas fa-utensils"></i> ${restaurantName}</h2>
                                <h1><i class="fas fa-chair"></i> BÀN SỐ ${tableNum}</h1>
                                <p><i class="fas fa-qrcode"></i> Quét mã để đặt món ngay</p>
                            </div>
                            <div class="qr-code">
                                <img src="${qrImageURL}" alt="QR Code Table ${tableNum}" class="img-fluid qr-preview">
                                <div class="mt-3">
                                    <p class="mb-2"><strong><i class="fas fa-mobile-alt"></i> Hướng dẫn:</strong></p>
                                    <small class="text-muted">
                                        1. Mở camera điện thoại<br>
                                        2. Quét mã QR này<br>
                                        3. Chọn món và đặt hàng
                                    </small>
                                </div>
                                <div class="download-btn no-print">
                                    <a href="${qrImageURL}" download="riday_table_${tableNum}_qr.png" class="btn btn-primary btn-sm">
                                        <i class="fas fa-download"></i> Tải QR này
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                `;
                
                container.insertAdjacentHTML('beforeend', qrCard);
            }
            
            // Smooth scroll to results
            container.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }
        
        function printQRCodes() {
            if (document.getElementById('qrCodesContainer').innerHTML === '') {
                alert('❌ Vui lòng tạo QR codes trước khi in!');
                return;
            }
            window.print();
        }
        
        async function downloadAllQR() {
            const startTable = parseInt(document.getElementById('startTable').value);
            const endTable = parseInt(document.getElementById('endTable').value);
            const qrSize = document.getElementById('qrSize').value;
            const domain = document.getElementById('domainInput').value.trim();
            
            if (!domain) {
                alert('❌ Vui lòng nhập domain trước!');
                return;
            }
            
            if (document.getElementById('qrCodesContainer').innerHTML === '') {
                alert('❌ Vui lòng tạo QR codes trước!');
                return;
            }
            
            const totalTables = endTable - startTable + 1;
            let downloaded = 0;
            
            for (let tableNum = startTable; tableNum <= endTable; tableNum++) {
                const qrURL = `${domain}/index.php?table=${tableNum}`;
                const qrImageURL = `https://api.qrserver.com/v1/create-qr-code/?size=${qrSize}x${qrSize}&data=${encodeURIComponent(qrURL)}&format=PNG&margin=20&bgcolor=FFFFFF&color=000000`;
                
                try {
                    const link = document.createElement('a');
                    link.href = qrImageURL;
                    link.download = `riday_table_${tableNum}_qr.png`;
                    document.body.appendChild(link);
                    link.click();
                    document.body.removeChild(link);
                    
                    downloaded++;
                    
                    // Delay để tránh spam download
                    await new Promise(resolve => setTimeout(resolve, 800));
                } catch (error) {
                    console.error(`Error downloading QR for table ${tableNum}:`, error);
                }
            }
            
            alert(`✅ Đã tải xuống ${downloaded}/${totalTables} QR codes thành công!`);
        }
        
        // Auto-generate sample QR codes when page loads
        window.onload = function() {
            // Set default domain based on current URL if localhost
            const currentDomain = window.location.origin;
            if (currentDomain.includes('localhost') || currentDomain.includes('127.0.0.1')) {
                document.getElementById('domainInput').value = 'https://riday-restaurant.onrender.com';
            } else {
                document.getElementById('domainInput').value = currentDomain;
            }
            
            // Generate 3 sample QR codes
            document.getElementById('endTable').value = 3;
            generateQRCodes();
        };
    </script>
</body>
</html>
