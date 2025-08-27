<?php
/**
 * QR Code Generator for Restaurant Tables
 * Tạo QR code cho từng bàn sau khi deploy lên Render
 */

// Lấy URL hiện tại (sẽ là URL Render sau khi deploy)
$protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http';
$host = $_SERVER['HTTP_HOST'];
$base_url = $protocol . '://' . $host;

// Số lượng bàn tối đa
$max_tables = 20;

// Xử lý tạo QR code
if (isset($_POST['generate']) && isset($_POST['table_number'])) {
    $table_number = (int)$_POST['table_number'];
    if ($table_number >= 1 && $table_number <= $max_tables) {
        $table_url = $base_url . '/?table=' . $table_number;
        // Sử dụng QR Server API để tạo QR code
        $qr_api_url = 'https://api.qrserver.com/v1/create-qr-code/?size=300x300&data=' . urlencode($table_url);
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QR Generator - Riday Restaurant</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        .qr-container {
            max-width: 800px;
            margin: 0 auto;
        }
        .qr-preview {
            border: 2px dashed #ddd;
            border-radius: 10px;
            padding: 30px;
            text-align: center;
            background-color: #f8f9fa;
        }
        .table-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 20px;
            margin-top: 30px;
        }
        .table-card {
            border: 1px solid #ddd;
            border-radius: 10px;
            padding: 20px;
            text-align: center;
            background: white;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        .qr-code-img {
            border: 1px solid #ddd;
            border-radius: 5px;
            margin: 10px 0;
        }
        .url-display {
            font-family: 'Courier New', monospace;
            background-color: #f8f9fa;
            padding: 5px 10px;
            border-radius: 5px;
            font-size: 12px;
            word-break: break-all;
            margin: 10px 0;
        }
        @media print {
            .no-print { display: none; }
            .table-card { break-inside: avoid; }
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <div class="qr-container">
            <div class="text-center mb-5">
                <h1><i class="bi bi-qr-code-scan text-primary"></i> QR Generator</h1>
                <p class="text-muted">Tạo QR code cho từng bàn trong nhà hàng</p>
                <div class="alert alert-info">
                    <i class="bi bi-info-circle"></i> 
                    <strong>URL hiện tại:</strong> <code><?php echo $base_url; ?></code>
                </div>
            </div>

            <!-- Single QR Generator -->
            <div class="card mb-5 no-print">
                <div class="card-header">
                    <h5><i class="bi bi-plus-circle"></i> Tạo QR cho một bàn</h5>
                </div>
                <div class="card-body">
                    <form method="POST" class="row g-3">
                        <div class="col-md-6">
                            <label for="table_number" class="form-label">Số bàn:</label>
                            <select name="table_number" id="table_number" class="form-select" required>
                                <option value="">Chọn số bàn...</option>
                                <?php for($i = 1; $i <= $max_tables; $i++): ?>
                                    <option value="<?php echo $i; ?>" <?php echo (isset($_POST['table_number']) && $_POST['table_number'] == $i) ? 'selected' : ''; ?>>
                                        Bàn <?php echo $i; ?>
                                    </option>
                                <?php endfor; ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">&nbsp;</label>
                            <button type="submit" name="generate" class="btn btn-primary d-block w-100">
                                <i class="bi bi-qr-code"></i> Tạo QR Code
                            </button>
                        </div>
                    </form>

                    <?php if (isset($qr_api_url)): ?>
                    <div class="qr-preview mt-4">
                        <h5>QR Code cho Bàn <?php echo $table_number; ?></h5>
                        <img src="<?php echo $qr_api_url; ?>" alt="QR Code Bàn <?php echo $table_number; ?>" class="qr-code-img">
                        <div class="url-display"><?php echo $table_url; ?></div>
                        <div class="mt-3">
                            <button onclick="downloadQR(<?php echo $table_number; ?>, '<?php echo $qr_api_url; ?>')" class="btn btn-success">
                                <i class="bi bi-download"></i> Tải về
                            </button>
                            <button onclick="printQR()" class="btn btn-outline-primary">
                                <i class="bi bi-printer"></i> In
                            </button>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Bulk Generator -->
            <div class="card no-print">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5><i class="bi bi-grid-3x3"></i> Tạo QR cho tất cả bàn</h5>
                    <div>
                        <button onclick="generateAllQR()" class="btn btn-primary me-2">
                            <i class="bi bi-qr-code"></i> Tạo tất cả
                        </button>
                        <button onclick="printAllQR()" class="btn btn-outline-primary">
                            <i class="bi bi-printer"></i> In tất cả
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div id="all-qr-container" class="table-grid">
                        <!-- QR codes sẽ được tạo ở đây bằng JavaScript -->
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const baseUrl = '<?php echo $base_url; ?>';
        const maxTables = <?php echo $max_tables; ?>;

        function downloadQR(tableNumber, qrUrl) {
            const link = document.createElement('a');
            link.href = qrUrl;
            link.download = `qr-ban-${tableNumber}.png`;
            link.click();
        }

        function printQR() {
            window.print();
        }

        function generateAllQR() {
            const container = document.getElementById('all-qr-container');
            container.innerHTML = '<div class="col-12 text-center"><div class="spinner-border text-primary" role="status"></div><p>Đang tạo QR codes...</p></div>';
            
            setTimeout(() => {
                let html = '';
                for (let i = 1; i <= maxTables; i++) {
                    const tableUrl = baseUrl + '/?table=' + i;
                    const qrUrl = 'https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=' + encodeURIComponent(tableUrl);
                    
                    html += `
                        <div class="table-card">
                            <h6 class="text-primary">BÀN ${i}</h6>
                            <img src="${qrUrl}" alt="QR Code Bàn ${i}" class="qr-code-img" style="width: 150px; height: 150px;">
                            <div class="url-display">${tableUrl}</div>
                            <button onclick="downloadQR(${i}, '${qrUrl}')" class="btn btn-sm btn-success no-print">
                                <i class="bi bi-download"></i> Tải
                            </button>
                        </div>
                    `;
                }
                container.innerHTML = html;
            }, 1000);
        }

        function printAllQR() {
            if (document.getElementById('all-qr-container').children.length === 0) {
                alert('Vui lòng tạo QR codes trước khi in!');
                return;
            }
            window.print();
        }

        // Auto generate all QR codes on page load (optional)
        // generateAllQR();
    </script>
</body>
</html>
