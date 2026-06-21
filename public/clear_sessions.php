<?php
$sessionDir = __DIR__ . '/../writable/session/';
$files = glob($sessionDir . '*');
foreach($files as $file) {
    if(is_file($file)) {
        unlink($file);
    }
}
echo "Sessions cleared.";
