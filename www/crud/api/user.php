<?php

use App\Entity\User;

require '../vendor/autoload.php';

$data = json_decode(file_get_contents('php://input'), true);
header("Content-Type: application/json");

switch ($_SERVER['REQUEST_METHOD']) {

    case 'POST':
        $name       = $data['name'];
        $email      = $data['email'];
        $password   = $data['password'];

        print_r($password);

        if (isset(
            $name,
            $email,
            $password
        )) {
            $user = new User(
                $name,
                $email,
                $password
            );
            $user->create();
        }
        break;

    case 'GET':

        $id = $_GET['id'];

        if (isset($id)) {
            $user = User::getUser($_GET['id']);
            print json_encode($user);
        }
        break;

    case 'PUT':

        $id         = $data['id'];
        $name       = $data['name'];
        $login      = $data['login'];
        $email      = $data['email'];
        $password   = $data['password'];
        $access     = $data['access'];

        if (isset(
            $id,
            $name,
            $login,
            $email,
            $password,
            $access
        )) {
            $user = new User(
                $id,
                $name,
                $login,
                $email,
                $password,
                $access
            );
            $user->update();
        }
        break;

    case 'DELETE':

        $id = $data['id'];
        $action = $data['action'];

        if ($action == 'delete') {

            if (isset($id)) {
                $user = new User(
                    $id
                );
                $user->delete($id);
            }
        } else if ($action == 'disable') {

            if (isset($id)) {
                $user = new User(
                    $id
                );
                $user->disable($id);
            }
        }
}
