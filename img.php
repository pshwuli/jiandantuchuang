<?php
$directory = 'img';
$images = [];

// 支持的图片扩展名
$imageExtensions = ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'webp', 'tiff', 'svg'];

// 打开目录并读取图片文件
if (is_dir($directory)) {
    if ($dh = opendir($directory)) {
        while (($file = readdir($dh)) !== false) {
            $filePath = $directory . '/' . $file;
            // 获取文件扩展名并检查是否为图片
            $fileExtension = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));
            if (is_file($filePath) && in_array($fileExtension, $imageExtensions)) {
                $images[] = $file;
            }
        }
        closedir($dh);
    }
}

// 随机选择一张图片
if (!empty($images)) {
    $image = $images[array_rand($images)];
    $imagePath = $directory . '/' . $image;
    
    // 获取图片的MIME类型
    $imageInfo = getimagesize($imagePath);
    $mimeType = $imageInfo['mime'];
    
    // 设置HTTP头部
    header('Content-Type: ' . $mimeType);
    header('Content-Length: ' . filesize($imagePath));
    
    // 输出图片内容
    readfile($imagePath);
    exit;
} else {
    // 如果没有找到图片，则返回404错误
    header("HTTP/1.0 404 Not Found");
    echo 'No images found in the directory.';
    exit;
}
?>
