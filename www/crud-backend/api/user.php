<?php

use App\Entity\User;

require '../vendor/autoload.php';

$data = json_decode(file_get_contents('php://input'), true);
header("Content-Type: application/json");

print_r($data);

switch ($_SERVER['REQUEST_METHOD']) {

    case 'POST': // OK

        $name       = $data['name'];
        $email      = $data['email'];
        $password   = $data['password'];
        if (isset(
            $name,
            $email,
            $password
        )) {
            $user = new User(
                $id,
                $name,
                $email,
                $password
            );
            print json_encode($user->create());
        }
        break;

    case 'GET': // OK

        $id = $_GET['id'];

        if ($id != null) {
            if (isset($id)) {
                $user = new User($id);
                print json_encode($user->getUser($id));
                break;
            }
        } else {
            $users = new User();
            print json_encode($users->getUsers());
            break;
        }

    case 'PUT': // OK

        $id         = $data['id'];
        $name       = $data['name'];
        $email      = $data['email'];
        $access     = $data['access'];

        if (isset(
            $id,
            $name,
            $email,
            $access
        )) {
            $user = new User(
                $id,
                $name,
                $email,
                $password,
                $access
            );
            print json_encode($user->update());
        }
        break;

    case 'DELETE': // OK

        $id     = $data['id'];

        if (isset($id)) {
            $user = new User($id);
            print json_encode($user->delete($id));
        }
        break;
}
