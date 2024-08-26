<?php
require_once 'db.php';
require_once 'cors.php';

function done($pdo) {
    $data = json_decode(file_get_contents('php://input'), true);
    $id = $_GET['id'];
    $done = $data['done']; // Default to 0 if 'done' is not provided

    $stmt = $pdo->prepare("UPDATE tasks SET done=? WHERE id=?");
    $stmt->execute([$done, $id]);

    $response = ['message' => 'Task updated successfully'];
    header('Content-Type: application/json');
    echo json_encode($response);
}

done($pdo);

if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    done($pdo);
    return;
}

?>