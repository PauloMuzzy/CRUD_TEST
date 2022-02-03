<?php

header("Content-Type: application/json");

use App\Entity\Customer;

require '../vendor/autoload.php';

$data = json_decode(file_get_contents('php://input'), true);

switch ($_SERVER['REQUEST_METHOD']) {

    case 'POST':
        $name       = $data['name'];
        $birthDate  = $data['birthDate'];
        $cpf        = $data['cpf'];
        $document   = $data['document'];
        $phone      = $data['phone'];
        $address    = $data['address'];

        if (isset(
            $name,
            $birthDate,
            $cpf,
            $document,
            $phone,
            $address
        )) {
            $customer = new Customer(
                NULL,
                $name,
                $birthDate,
                $cpf,
                $document,
                $phone,
                $address
            );
            $customer->create();
        }
        break;

    case 'GET':

        $id = $_GET['id'];
        if ($id == NULL) {
            $customer = new Customer();
            print json_encode($customer->getCustomers());
            break;
        } else {
            if (isset(
                $id
            )) {
                $customer = new Customer(
                    $id
                );
                print json_encode($customer->getCustomer($id));
            }
            break;
        }
        break;

    case 'PUT':
        $id         = $data['id'];
        $name       = $data['name'];
        $birthDate  = $data['birthDate'];
        $cpf        = $data['cpf'];
        $document   = $data['document'];
        $phone      = $data['phone'];

        if (isset(
            $id,
            $name,
            $birthDate,
            $cpf,
            $document,
            $phone
        )) {
            $customer = new Customer(
                $id,
                $name,
                $birthDate,
                $cpf,
                $document,
                $phone
            );
            $customer->update();
        }
        break;

    case 'DELETE':
        $id = $data['id'];
        $action = ['action'];

        if ($action == 'delete') {

            if (isset($id)) {
                $user = new Customer(
                    $id
                );
                $user->delete($id);
            }
        } else if ($action == 'disable') {

            if (isset($id)) {
                $user = new Customer(
                    $id
                );
                $user->disable($id);
            }
        }
        break;
}
