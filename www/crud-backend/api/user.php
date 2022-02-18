<?php

header("Content-Type: application/json");

use App\Entity\User;

require '../vendor/autoload.php';

$data = json_decode(file_get_contents('php://input'), true);

switch ($_SERVER['REQUEST_METHOD']) {

    case 'POST':

        $name       = $data['name'];
        $email      = $data['email'];
        $password   = $data['password'];

        if ($name != null) {
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
        } else {
            if (isset(
                $email,
                $password
            )) {
                $user = new User(
                    $id,
                    $name,
                    $email,
                    $password
                );
                print json_encode($user->login($email, $password));
            }
            break;
        }

    case 'GET':

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

    case 'PUT':

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

    case 'DELETE':

        $id = $data['id'];
        if (isset($id)) {
            $user = new User($id);
            print json_encode($user->delete($id));
        }
        break;
}
