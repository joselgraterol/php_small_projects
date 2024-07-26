<?php
include 'db.php';


header("Content-Type: application/json");

$method = $_SERVER['REQUEST_METHOD'];

$id = isset($_GET['id']) ? intval($_GET['id']) : null; // Convert to integer




switch ($method) {
    case 'GET':
        if ($id) {
            getPersona($conn, $id);
        } else {
            getPersonas($conn);
        }
        break;
    case 'POST':
        addPersona($conn);
        break;
    case 'PUT':
        updatePersona($conn, $id);
        break;
    case 'DELETE':
        if ($id) {
            deletePersona($conn, $id);
        } else {
            http_response_code(400); // Bad Request
            echo json_encode(['message' => 'Missing ID for DELETE request']);
        }
        break;
    default:
        header("HTTP/1.0 405 Method Not Allowed");
        break;
}


function getPersonas($conn)
{
    try {
        //global $pdo; la variable que viene de la base de datos
        $personas = $conn->prepare('SELECT * FROM personas');
        $personas->execute();
        $result = $personas->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($result);
    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(['message' => 'Something went wrong']);
    }
}

function getPersona($conn, $id)
{
    try {
        $persona = $conn->prepare('SELECT * FROM personas WHERE id = ?');
        $persona->execute([$id]);
        $result = $persona->fetch(PDO::FETCH_ASSOC);
        echo json_encode($result);
    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(['message' => 'Something went wrong']);
    }
}

function addPersona($conn)
{
    try {
        $data = json_decode(file_get_contents('php://input'), true);
        $name = $data['name'];
        $age = $data['age'];
        $persona = $conn->prepare('INSERT INTO personas (name, age) VALUES (?, ?)');
        $persona->execute([$name, $age]);
        echo json_encode(['message' => 'Persona added successfully']);
    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(['message' => 'Something went wrong']);
    }
}

function updatePersona($conn, $id)
{
    try {
        $data = json_decode(file_get_contents('php://input'), true);
        $name = $data['name'];
        $age = $data['age'];
        $persona = $conn->prepare('UPDATE personas SET name = ?, age = ? WHERE id = ?');
        $persona->execute([$name, $age, $id]);
        echo json_encode(['message' => 'Persona updated successfully']);
    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(['message' => 'Something went wrong']);
    }
}

function deletePersona($conn, $id)
{
    try {
        $persona = $conn->prepare('DELETE FROM personas WHERE id = ?');
        $persona->execute([$id]);
        echo json_encode(['message' => 'Persona deleted successfully']);
    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(['message' => 'Something went wrong']);
    }
}
