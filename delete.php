<?php
$response = ["code" => 400, "msg" => "failed"];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    if (isset($data['filename'])) {
        $filename = basename($data['filename']); // Ensure the filename is safe

        // Define file paths
        $imagePath = 'img/' . $filename;
        $videoPath = 'videos/' . $filename;

        // Check if the file exists in the image directory
        if (file_exists($imagePath)) {
            if (unlink($imagePath)) {
                $response['code'] = 200;
                $response['msg'] = 'Image deleted successfully';
            } else {
                $response['msg'] = 'Failed to delete image';
            }
        } 
        // Check if the file exists in the video directory
        elseif (file_exists($videoPath)) {
            if (unlink($videoPath)) {
                $response['code'] = 200;
                $response['msg'] = 'Video deleted successfully';
            } else {
                $response['msg'] = 'Failed to delete video';
            }
        } 
        else {
            $response['msg'] = 'File not found';
        }
    } else {
        $response['msg'] = 'Filename not provided';
    }
}

echo json_encode($response);
?>
