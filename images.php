<?php
$imageDir = 'img/';
$videoDir = 'videos/';
$images = [];
$videos = [];

// 获取图片文件列表
if (is_dir($imageDir)) {
    $imageFiles = array_diff(scandir($imageDir), ['..', '.']);
    foreach ($imageFiles as $file) {
        $images[] = $imageDir . $file;
    }
}

// 获取视频文件列表
if (is_dir($videoDir)) {
    $videoFiles = array_diff(scandir($videoDir), ['..', '.']);
    foreach ($videoFiles as $file) {
        $videos[] = $videoDir . $file;
    }
}

// 返回JSON响应
echo json_encode(['images' => $images, 'videos' => $videos]);
?>
