<?php
header('Content-Type: application/json');

$servername = "localhost"; 
$username = "root"; 
$password = ""; 
$dbname = "tinkerbellDb"; 

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die(json_encode(['error' => 'Database connection failed']));
}

$sql = "SELECT first_name, middle_name, last_name FROM drivers";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $drivers = [];
    while ($row = $result->fetch_assoc()) {
        $drivers[] = $row;
    }
    echo json_encode($drivers);
} else {
    echo json_encode([]);
}

$conn->close();
?>
