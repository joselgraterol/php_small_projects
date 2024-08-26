<?php
require_once 'db.php';
require_once 'cors.php';

function edit_task($pdo) {
    $data = json_decode(file_get_contents('php://input'), true);
    $id = $_GET['id'];
    $title = $data['title'];
    $description = $data['description'];
    //$done = $data['done'] ?? 0; // Default to 0 if 'done' is not provided

    $stmt = $pdo->prepare("UPDATE tasks SET title=?, description=? WHERE id=?");
    $stmt->execute([$title, $description, $id]);

    $response = ['message' => 'Task updated successfully'];
    header('Content-Type: application/json');
    echo json_encode($response);
}


if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    edit_task($pdo);
    return;
}

?>