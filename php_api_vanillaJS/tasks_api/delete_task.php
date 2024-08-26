<?php
require_once 'db.php';
require_once 'cors.php';



function delete_task($pdo) {
    $id = $_GET['id']; // Assuming you're sending the ID in the query string

    $stmt = $pdo->prepare("DELETE FROM tasks WHERE id=?");
    $stmt->execute([$id]);

    $response = ['message' => 'Task deleted successfully'];
    header('Content-Type: application/json');
    echo json_encode($response);
}


if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    delete_task($pdo);
    return;
}

?>