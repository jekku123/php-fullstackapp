<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: *');
header('Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS');

include_once 'Database.php';
include_once 'Datastorage.php';

$db = new Database();

$storage = new Datastorage($db);

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {

    case "GET":
        $path = explode('/', $_SERVER['REQUEST_URI']);
        if (isset($path[4]) && is_numeric($path[4])) {
            $data = $storage->get($path[4]);
        } else {
            $data = $storage->get_all();
        }
        echo json_encode($data);
        break;


    case 'POST':
        $user = json_decode(file_get_contents('php://input'));

        $username = $db->sanitize_input($user->username);
        $email = $db->sanitize_input($user->email);
        $mobile = $db->sanitize_input($user->mobile);

        if ($db->is_valid($username, 'text') && $db->is_valid($email, 'email') && $db->is_valid($mobile, 'mobile')) {
            try {
                $storage->add($username, $email, $mobile);
                echo $db->jsonResponse(1, 'User created successfully!');
            } catch (\PDOException $e) {
                http_response_code(400);
                echo $db->jsonResponse(0, $e->getMessage());
            }
        } else {
            http_response_code(400);
            echo $db->jsonResponse(0, 'Invalid input values');
        }

        break;

    case "PUT":
        $user = json_decode(file_get_contents('php://input'));

        $id = $user->id;
        $username = $db->sanitize_input($user->username);
        $email = $db->sanitize_input($user->email);
        $mobile = $db->sanitize_input($user->mobile);

        if ($db->is_valid($username, 'text') && $db->is_valid($email, 'email') && $db->is_valid($mobile, 'mobile')) {
            try {
                $storage->update($id, $username, $email, $mobile);
                echo $db->jsonResponse(1, 'User updated successfully.');
            } catch (\PDOException $e) {
                http_response_code(400);
                echo $db->jsonResponse(0, $e->getMessage());
            }
        } else {
            http_response_code(400);
            echo $db->jsonResponse(0, 'Invalid input valueas');
        }

        break;

    case "DELETE":
        $path = explode('/', $_SERVER['REQUEST_URI']);

        try {
            $storage->delete($path[4]);
            echo $db->jsonResponse(1, 'User deleted successfully!');
        } catch (\PDOException $e) {
            http_response_code(400);
            echo $db->jsonResponse(0, $e->getMessage());
        }

        break;

    default:
        break;
}
