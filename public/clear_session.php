<?php
$dir = __DIR__ . '/../writable/session/';
if (is_dir($dir)) {
    $files = scandir($dir);
    foreach ($files as $file) {
        if ($file != '.' && $file != '..' && $file != 'index.html') {
            unlink($dir . $file);
            echo "Deleted session file: $file<br>";
        }
    }
    echo "<b>All session locks cleared!</b>";
} else {
    echo "Session directory not found.";
}
