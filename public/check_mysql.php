<?php
$conn = new mysqli('localhost', 'root', '');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$result = $conn->query("SHOW FULL PROCESSLIST");
$processes = [];
while ($row = $result->fetch_assoc()) {
    $processes[] = $row;
}
echo json_encode($processes, JSON_PRETTY_PRINT);
