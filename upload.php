<?php
// 设置上传目录
$imageDir = 'img/';
$videoDir = 'videos/';

// 检查并创建目录
if (!is_dir($imageDir)) {
    mkdir($imageDir, 0777, true);
}
if (!is_dir($videoDir)) {
    mkdir($videoDir, 0777, true);
}

// 获取协议
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? 'https://' : 'http://';
// 获取客户端IP和端口
$host = $_SERVER['HTTP_HOST'];
$baseUrl = $protocol . $host . dirname($_SERVER['SCRIPT_NAME']) . '/';

// 准备响应数组
$response = ["code" => 400, "msg" => "failed"];

// 检查是否有文件上传
if ($_FILES) {
    // 获取文件信息
    $file = $_FILES['file'];
    $filename = basename($file['name']);
    $fileTmpPath = $file['tmp_name'];
    $fileSize = $file['size'];
    $fileType = $file['type'];

    // 设置文件名及上传路径
    if (strpos($fileType, 'image') !== false) {
        // 处理图片上传
        $ext = pathinfo($filename, PATHINFO_EXTENSION);
        $newFilename = 'Image_' . time() . '.' . $ext;
        $uploadFilePath = $imageDir . $newFilename;
        $urlPath = $baseUrl . $imageDir . $newFilename;
    } elseif (strpos($fileType, 'video') !== false) {
        // 处理视频上传
        $ext = pathinfo($filename, PATHINFO_EXTENSION);
        $newFilename = 'Video_' . time() . '.' . $ext;
        $uploadFilePath = $videoDir . $newFilename;
        $urlPath = $baseUrl . $videoDir . $newFilename;
    } else {
        // 无效的文件类型
        $response['msg'] = 'Invalid file type';
        echo json_encode($response);
        exit;
    }

    // 移动文件到指定目录
    if (move_uploaded_file($fileTmpPath, $uploadFilePath)) {
        $response['code'] = 200;
        $response['msg'] = 'success';
        if (strpos($fileType, 'image') !== false) {
            $response['img'] = $urlPath;
        } elseif (strpos($fileType, 'video') !== false) {
            $response['videos'] = $urlPath;
        }
    } else {
        $response['msg'] = 'File upload failed';
    }
} else {
    $response['msg'] = 'No file uploaded';
}

// 返回JSON响应并替换\/为/
echo str_replace('\/', '/', json_encode($response));
?>
