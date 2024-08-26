<?php
require_once 'db.php';
require_once 'cors.php';

function get_tasks($pdo, $id = 0)
{
    try {
        $query = "SELECT * FROM tasks";
        if ($id != 0) {
            $query .= " WHERE id=" . $id . " LIMIT 1";
        }
        $stmt = $pdo->prepare($query);
        $stmt->execute();
        $response = $stmt->fetchAll(PDO::FETCH_ASSOC);
        header('Content-Type: application/json');
        echo json_encode($response);
    } catch (\Throwable $th) {
        echo $th->getMessage();
    } 
    finally {
        $pdo = null;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (!empty($_GET["id"])) {
        get_tasks($pdo, $_GET["id"]);
    } else {
        get_tasks($pdo);
    }
    return;
}
