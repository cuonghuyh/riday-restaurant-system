<?php

class CloudinaryAPI {
    private $cloudName;
    private $apiKey;
    private $apiSecret;
    private $config;
    
    public function __construct() {
        $this->config = require_once __DIR__ . '/../config/cloudinary.php';
        $this->cloudName = $this->config['cloud_name'];
        $this->apiKey = $this->config['api_key'];
        $this->apiSecret = $this->config['api_secret'];
        
        if (empty($this->cloudName) || empty($this->apiKey) || empty($this->apiSecret)) {
            throw new Exception('Cloudinary credentials not configured properly');
        }
    }
    
    /**
     * Upload ảnh lên Cloudinary
     * 
     * @param string $filePath Đường dẫn file cần upload
     * @param array $options Tùy chọn upload
     * @return array Response từ Cloudinary
     */
    public function uploadImage($filePath, $options = []) {
        if (!file_exists($filePath)) {
            throw new Exception("File not found: $filePath");
        }
        
        // Validate file type
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
        $fileType = mime_content_type($filePath);
        
        if (!in_array($fileType, $allowedTypes)) {
            throw new Exception("Invalid file type: $fileType");
        }
        
        // Prepare upload data (without api_key and signature first)
        $uploadData = [
            'file' => new CURLFile($filePath),
            'timestamp' => time(),
        ];
        
        // Add options
        if (isset($options['folder'])) {
            $uploadData['folder'] = $options['folder'];
        } else {
            $uploadData['folder'] = 'restaurant/menu';
        }
        
        if (isset($options['public_id'])) {
            $uploadData['public_id'] = $options['public_id'];
        }
        
        if (isset($options['tags'])) {
            $uploadData['tags'] = is_array($options['tags']) ? implode(',', $options['tags']) : $options['tags'];
        }
        
        // Generate signature BEFORE adding api_key
        $uploadData['signature'] = $this->generateSignature($uploadData);
        
        // Now add api_key
        $uploadData['api_key'] = $this->apiKey;
        
        // Upload to Cloudinary
        $ch = curl_init();
        curl_setopt_array($ch, [
            CURLOPT_URL => "https://api.cloudinary.com/v1_1/{$this->cloudName}/image/upload",
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => $uploadData,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_TIMEOUT => 60
        ]);
        
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_error($ch);
        curl_close($ch);
        
        if ($error) {
            throw new Exception("CURL Error: $error");
        }
        
        $result = json_decode($response, true);
        
        if ($httpCode !== 200) {
            $errorMsg = isset($result['error']['message']) ? $result['error']['message'] : 'Upload failed';
            throw new Exception("Cloudinary Error: $errorMsg");
        }
        
        return $result;
    }
    
    /**
     * Xóa ảnh từ Cloudinary
     * 
     * @param string $publicId Public ID của ảnh cần xóa
     * @return array Response từ Cloudinary
     */
    public function deleteImage($publicId) {
        $deleteData = [
            'api_key' => $this->apiKey,
            'public_id' => $publicId,
            'timestamp' => time(),
        ];
        
        $deleteData['signature'] = $this->generateSignature($deleteData);
        
        $ch = curl_init();
        curl_setopt_array($ch, [
            CURLOPT_URL => "https://api.cloudinary.com/v1_1/{$this->cloudName}/image/destroy",
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => $deleteData,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_TIMEOUT => 30
        ]);
        
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch);
        $error = curl_error($ch);
        curl_close($ch);
        
        if ($error) {
            throw new Exception("CURL Error: $error");
        }
        
        return json_decode($response, true);
    }
    
    /**
     * Tạo URL ảnh với transformation
     * 
     * @param string $publicId Public ID của ảnh
     * @param string $transformation Tên transformation từ config
     * @return string URL ảnh
     */
    public function getImageUrl($publicId, $transformation = 'menu_thumb') {
        if (empty($publicId)) {
            return null;
        }
        
        $baseUrl = "https://res.cloudinary.com/{$this->cloudName}/image/upload";
        
        if (isset($this->config['transformations'][$transformation])) {
            $trans = $this->config['transformations'][$transformation];
            $transformString = $this->buildTransformationString($trans);
            return "$baseUrl/$transformString/$publicId";
        }
        
        return "$baseUrl/$publicId";
    }
    
    /**
     * Lấy thông tin ảnh từ Cloudinary
     * 
     * @param string $publicId Public ID của ảnh
     * @return array Thông tin ảnh
     */
    public function getImageInfo($publicId) {
        $url = "https://api.cloudinary.com/v1_1/{$this->cloudName}/resources/image/upload/$publicId";
        
        $timestamp = time();
        $signature = $this->generateSignature([
            'public_id' => $publicId,
            'timestamp' => $timestamp
        ]);
        
        $ch = curl_init();
        curl_setopt_array($ch, [
            CURLOPT_URL => $url . "?api_key={$this->apiKey}&timestamp=$timestamp&signature=$signature",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_TIMEOUT => 30
        ]);
        
        $response = curl_exec($ch);
        curl_close($ch);
        
        return json_decode($response, true);
    }
    
    /**
     * Generate signature cho Cloudinary API
     * 
     * @param array $params Parameters cần sign
     * @return string Signature
     */
    private function generateSignature($params) {
        // Remove file, signature, and api_key from params for signature generation
        unset($params['file'], $params['signature'], $params['api_key']);
        
        // Sort params
        ksort($params);
        
        // Build query string
        $queryString = '';
        foreach ($params as $key => $value) {
            if ($value !== null && $value !== '') {
                $queryString .= $key . '=' . $value . '&';
            }
        }
        
        // Remove trailing &
        $queryString = rtrim($queryString, '&');
        
        // Add secret and hash
        $queryString .= $this->apiSecret;
        
        return sha1($queryString);
    }
    
    /**
     * Build transformation string từ array
     * 
     * @param array $transformation
     * @return string
     */
    private function buildTransformationString($transformation) {
        $parts = [];
        
        foreach ($transformation as $key => $value) {
            $parts[] = $key . '_' . $value;
        }
        
        return implode(',', $parts);
    }
    
    /**
     * Test connection với Cloudinary
     * 
     * @return array Test result
     */
    public function testConnection() {
        try {
            $ch = curl_init();
            curl_setopt_array($ch, [
                CURLOPT_URL => "https://api.cloudinary.com/v1_1/{$this->cloudName}/resources/image",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_TIMEOUT => 10
            ]);
            
            $response = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);
            
            return [
                'success' => $httpCode === 200,
                'http_code' => $httpCode,
                'response' => json_decode($response, true)
            ];
            
        } catch (Exception $e) {
            return [
                'success' => false,
                'error' => $e->getMessage()
            ];
        }
    }
}
