<?php
require_once 'db.php';
require_once 'cors.php';
function add_task($pdo)
{
    $data = json_decode(file_get_contents('php://input'), true);
    $title = $data['title'];
    $description = $data['description'];
    //$done = $data['done'] ?? 0; // Default to 0 if 'done' is not provided

    $stmt = $pdo->prepare("INSERT INTO tasks (title, description) VALUES (?, ?)");
    $stmt->execute([$title, $description]);

    $response = ['message' => 'Task added successfully', 'id' => $pdo->lastInsertId()];
    header('Content-Type: application/json');
    echo json_encode($response);
}  

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    add_task($pdo);
    return;
}

?>