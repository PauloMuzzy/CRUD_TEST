<?php

header("Content-Type: application/json");

use App\Entity\User;
use \Exception;

require '../vendor/autoload.php';
require '../utils/dataValidator.php';

$data = json_decode(file_get_contents('php://input'), true);

try {
    switch ($_SERVER['REQUEST_METHOD']) {

        case 'POST':

            $name       =  $data['name'];
            $email      =  $data['email'];
            $password   =  $data['password'];

            if ($name != null) {
                $name       = validateData('name',  $data['name']);
                $email      = validateData('email', $data['email']);
                try {
                    $user = new User(
                        $id,
                        $name,
                        $email,
                        $password
                    );
                    print json_encode($user->create());
                    break;
                } catch (Exception $e) {
                    print json_encode([
                        'status' => 'error',
                        'message' => ($e->getMessage())
                    ]);
                }
            }

            try {
                $email = validateData('email', $data['email']);
                $user = new User(
                    NULL,
                    NULL,
                    $email,
                    $password
                );
                print json_encode($user->login($email, $password));
                break;
            } catch (Exception $e) {
                print json_encode([
                    'status' => 'error',
                    'message' => ($e->getMessage())
                ]);
            }

        case 'GET':

            $id = $_GET['id'];

            if ($id != null) {
                try {
                    $user = new User($id);
                    print json_encode($user->getUser($id));
                    break;
                } catch (Exception $e) {
                    print json_encode([
                        'status' => 'error',
                        'message' => ($e->getMessage())
                    ]);
                }
            }

            try {
                $users = new User();
                print json_encode($users->getUsers());
                break;
            } catch (Exception $e) {
                print json_encode([
                    'status' => 'error',
                    'message' => ($e->getMessage())
                ]);
            }

        case 'PUT':

            $id         = validateData('id',    $data['id']);
            $name       = validateData('name',  $data['name']);
            $email      = validateData('email', $data['email']);
            $access     = $data['access'];

            try {
                $user = new User(
                    $id,
                    $name,
                    $email,
                    $password,
                    $access
                );
                print json_encode($user->update());
                break;
            } catch (Exception $e) {
                print json_encode([
                    'status' => 'error',
                    'message' => ($e->getMessage())
                ]);
            }

        case 'DELETE':

            $id = $data['id'];
            try {
                $user = new User($id);
                print json_encode($user->delete($id));
                break;
            } catch (Exception $e) {
                print json_encode([
                    'status' => 'error',
                    'message' => ($e->getMessage())
                ]);
            }
    }
} catch (Exception $e) {
    print json_encode([
        'status' => 'error',
        'message' => ($e->getMessage())
    ]);
}
