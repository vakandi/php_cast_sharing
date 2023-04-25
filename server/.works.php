<?php
$files = [];
$publicFolderPath = 'public'; // Update this with your actual folder path
foreach (scandir($publicFolderPath) as $filename) {
    $file_path = $publicFolderPath . '/' . $filename;
    if (is_file($file_path)) {
        $size = filesize($file_path);
        $size_in_mb = round($size / (1024 * 1024), 2); // Convert bytes to MB
        $files[] = ['filename' => $filename, 'size' => $size_in_mb . ' MB']; // Update the 'size' value with MB
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>File List</title>
    <style>
        .result-box {
            margin-top: 10px;
            padding: 10px;
            border: 1px solid #ccc;
            background-color: #f9f9f9;
        }
    </style>
    <script>

// Update the callAPI() function
function callAPI(apiType, filename) {
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        if (xhr.readyState == 4 && xhr.status == 200) {
            var resultBox = document.getElementById('result-box');
            resultBox.textContent = xhr.responseText;
            resultBox.style.display = 'block';
            
            // Display the video player if the file is a video
            var videoPlayer = document.getElementById('video-player');
            var isVideo = filename.endsWith('.mp4') || filename.endsWith('.mkv');
            if (isVideo) {
                videoPlayer.style.display = 'block';
                videoPlayer.getElementsByTagName('source')[0].src = 'public/' + filename;
                videoPlayer.load();
            } else {
                videoPlayer.style.display = 'none';
            }
        }
    };
    xhr.open('GET', 'api.php?apiType=' + apiType + '&filename=' + filename, true); // Update the URL to point to the PHP API file
    xhr.send();
}

function CopyToClipboard(containerid) {
  var resultBox = document.getElementById(containerid);
  var textToCopy = resultBox.textContent; // Get the text content of the result box

  // Create a temporary textarea element to copy the text to clipboard
  var tempTextarea = document.createElement("textarea");
  tempTextarea.value = textToCopy;
  document.body.appendChild(tempTextarea);
  tempTextarea.select();
  document.execCommand("copy");
  document.body.removeChild(tempTextarea);

  alert("Text has been copied!");
}
    
</script>
</head>
<body>
    <h1>Vakandi Movies PHP Server for local sharing</h1>
    <table>
        <tr>
            <th>Filename</th>
            <th>Size (megaoctets)</th>
            <th>Links</th>
        </tr>
        <?php foreach ($files as $file): ?>
        <tr>
            <td><?php echo $file['filename']; ?></td>
            <td><?php echo $file['size']; ?></td>
            <td>
                <button onclick="callAPI('ftp', '<?php echo $file['filename']; ?>')">Show FTP Link</button>
                <button onclick="callAPI('http', '<?php echo $file['filename']; ?>')">Show HTML Link</button>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
    <div id="result-box" class="result-box"></div>
<button id="button1" onclick="CopyToClipboard('result-box')">Click to copy</button>

<td>
    <!-- Add the video player element with an id -->
    <video id="video-player" style="display: none; max-width: 100%; height: auto;">
        <source src="" type="video/mp4">
        <!-- Add other source types if needed -->
    </video>
</td>

</body>
</html
