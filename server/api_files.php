<?php
$publicFolderPath = 'public'; // Update this with your actual folder path
$allowedExtensions = ['.mp3', '.mp4', '.mkv', '.srt', '.mo3']; // Allowed file extensions

if (isset($_GET['foldername'])) {
    $foldername = $_GET['foldername'];
    $files = [];
    $folders = [];

    // Fetch the files and folders in the given foldername
    $folder_path = $publicFolderPath . '/' . $foldername;
    foreach (scandir($folder_path) as $filename) {
        $file_path = $folder_path . '/' . $filename;
        $file_extension = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
        if (is_file($file_path) && in_array('.' . $file_extension, $allowedExtensions)) {
            $size = filesize($file_path);
            $size_in_mb = round($size / (1024 * 1024), 2); // Convert bytes to MB
            $files[] = ['filename' => $filename, 'size' => $size_in_mb . ' MB']; // Update the 'size' value with MB
        } elseif (is_dir($file_path)) {
            $folders[] = ['foldername' => $filename];
        }
    }

    // Prepare JSON response
    $response = ['files' => $files, 'folders' => $folders];
    header('Content-Type: application/json');
    echo json_encode($response);
} else {
    // Invalid request
    header('HTTP/1.1 400 Bad Request');
    echo 'Error: foldername parameter is required';
}
?>

