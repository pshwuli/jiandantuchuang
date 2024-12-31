<?php
// 设置Content-Type为application/json
header('Content-Type: application/json');

// 禁止缓存的HTTP头
header('Cache-Control: no-cache, no-store, must-revalidate'); // HTTP 1.1
header('Pragma: no-cache'); // HTTP 1.0
header('Expires: 0'); // Proxies

// 定义视频文件夹的路径
$videoDir = 'videos';

// 获取视频文件列表
$videos = glob($videoDir . '/*.mp4');

// 检查是否有视频文件
if ($videos === false || count($videos) === 0) {
    $response = [
        "code" => 500,
        "msg" => "No videos found",
        "videos" => null
    ];
} else {
    // 随机选择一个视频文件
    $randomVideo = $videos[array_rand($videos)];
    $videoUrl = 'http://' . $_SERVER['HTTP_HOST'] . '/' . $randomVideo;

    // 构建响应数组
    $response = [
        "code" => 200,
        "msg" => "success",
        "videos" => $videoUrl
    ];
}

// 将响应数组编码为JSON
$jsonResponse = json_encode($response);

// 替换JSON字符串中的反斜杠
$jsonResponse = str_replace('\/', '/', $jsonResponse);

// 输出JSON响应
echo $jsonResponse;
?>
