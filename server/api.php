<?php
$files = [];
$publicFolderPath = 'public'; // Update this with your actual folder path
foreach (scandir($publicFolderPath) as $filename) {
    $file_path = $publicFolderPath . '/' . $filename;
    if (is_file($file_path)) {
        $size = filesize($file_path);
        $files[] = ['filename' => $filename, 'size' => $size];
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['apiType']) && isset($_GET['filename'])) {
    $apiType = $_GET['apiType'];
    $filename = $_GET['filename'];
    if ($apiType === 'ftp') {
        $ftp_link = 'ftp://' . $_SERVER['REMOTE_ADDR'] . ':' . $_SERVER['SERVER_PORT'] . '/' . $filename;
        echo $ftp_link;
    } elseif ($apiType === 'http') {
        $http_link = 'http://' . $_SERVER['REMOTE_ADDR'] . ':' . $_SERVER['SERVER_PORT'] . '/' . 'public/' . $filename;
        echo $http_link;
    }
    exit;
}
?>

