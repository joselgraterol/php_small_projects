<?php
// require_once 'db.php';
// require_once 'cors.php';




// $request_method = $_SERVER["REQUEST_METHOD"];

// switch($request_method)
// {
//     case 'GET':
//         if(!empty($_GET["id"]))
//             get_tasks($pdo,$_GET["id"]);
//         else
//             get_tasks($pdo);
//         break;

//     // case 'POST':
//     //     add_task($pdo);
//     //     break;

//     // case 'PUT':
//     //     edit_task($pdo);
//     //     break;

//     // case 'DELETE':
//     //     delete_task($pdo);
//     //     break;

//     default:
//         header("HTTP/1.0 405 Method Not Allowed");
//         break;
// }

function get_tasks($pdo,$id=0)
{
    $query="SELECT * FROM tasks";
    if($id != 0)
    {
        $query.=" WHERE id=".$id." LIMIT 1";
    }
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    $response = $stmt->fetchAll(PDO::FETCH_ASSOC);
    header('Content-Type: application/json');
    echo json_encode($response);
}

function add_task($pdo)
{
    $data = json_decode(file_get_contents('php://input'), true);
    $title = $data['title'];
    $description = $data['description'];
    $done = $data['done'] ?? 0; // Default to 0 if 'done' is not provided

    $stmt = $pdo->prepare("INSERT INTO tasks (title, description, done) VALUES (?, ?, ?)");
    $stmt->execute([$title, $description, $done]);

    $response = ['message' => 'Task added successfully', 'id' => $pdo->lastInsertId()];
    header('Content-Type: application/json');
    echo json_encode($response);
}

// function edit_task($pdo) {
//     $data = json_decode(file_get_contents('php://input'), true);
//     $id = $_GET['id'];
//     $title = $data['title'];
//     $description = $data['description'];
//     $done = $data['done'] ?? 0; // Default to 0 if 'done' is not provided

//     $stmt = $pdo->prepare("UPDATE tasks SET title=?, description=?, done=? WHERE id=?");
//     $stmt->execute([$title, $description, $done, $id]);

//     $response = ['message' => 'Task updated successfully'];
//     header('Content-Type: application/json');
//     echo json_encode($response);
// }


// function delete_task($pdo) {
//     $id = $_GET['id']; // Assuming you're sending the ID in the query string

//     $stmt = $pdo->prepare("DELETE FROM tasks WHERE id=?");
//     $stmt->execute([$id]);

//     $response = ['message' => 'Task deleted successfully'];
//     header('Content-Type: application/json');
//     echo json_encode($response);
// }




?>
