<?php
echo "<h3>Current Project Directory:</h3> " . __DIR__ . "<br><br>";

$targetFolder = 'C:\wamp64\www\PHPMailer';

echo "<h3>Checking target folder:</h3>";
if (is_dir($targetFolder)) {
    echo " Found folder: $targetFolder <br><br>";
    echo "<strong>Files inside this folder:</strong><br>";
    
    // List everything inside that folder
    $files = scandir($targetFolder);
    foreach ($files as $file) {
        if ($file !== '.' && $file !== '..') {
            echo "- " . $file . "<br>";
        }
    }
} else {
    echo "Folder NOT found at: $targetFolder <br>";
    echo "Please double-check your WampServer installation path.";
}
?>