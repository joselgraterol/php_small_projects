<?php
// data.php

// Example data
$data = [
    "message" => "Hello from PHP!",
    "timestamp" => time()
];

// Set the content type to JSON
header('Content-Type: application/json');

// Return the data as JSON
echo json_encode($data);
?>