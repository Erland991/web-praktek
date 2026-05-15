<?php

$source = "C:\\Users\\erlan\\.gemini\\antigravity\\brain\\e0198684-8760-4084-923a-3a295abde96c\\default_profile_photo_1778570972832.png";
$destDir = "c:\\Users\\erlan\\Downloads\\CodeIgniter4-develop\\CodeIgniter4-develop\\public\\uploads\\profile";
$destFile = $destDir . "\\default.png";

if (!is_dir($destDir)) {
    mkdir($destDir, 0777, true);
}

if (copy($source, $destFile)) {
    echo "Default photo copied successfully!";
} else {
    echo "Failed to copy photo.";
}
