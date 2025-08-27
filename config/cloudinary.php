<?php
/**
 * Cloudinary Configuration
 * 
 * Để sử dụng:
 * 1. Đăng ký tài khoản tại https://cloudinary.com/
 * 2. Lấy Cloud Name, API Key, API Secret từ Dashboard
 * 3. Cập nhật các thông tin bên dưới
 */

return [
    // Thay thế bằng thông tin thực từ Cloudinary Dashboard
    'cloud_name' => getenv('CLOUDINARY_CLOUD_NAME') ?: 'dx9ngssmo', // Ví dụ: 'my-restaurant'
    'api_key' => getenv('CLOUDINARY_API_KEY') ?: '736777414926498', // Ví dụ: '123456789012345'
    'api_secret' => getenv('CLOUDINARY_API_SECRET') ?: 'cm7W85qwo9xv_3-99WtquEX_e6Y', // Ví dụ: 'abcd...'
    'secure' => true,
    
    // Upload presets
    'upload_preset' => 'restaurant_menu', // Tạo preset này trong Cloudinary Dashboard
    
    // Image transformations
    'transformations' => [
        'menu_thumb' => [
            'width' => 300,
            'height' => 200,
            'crop' => 'fill',
            'quality' => 'auto',
            'format' => 'auto'
        ],
        'menu_large' => [
            'width' => 800,
            'height' => 600,
            'crop' => 'fill',
            'quality' => 'auto',
            'format' => 'auto'
        ]
    ]
];
