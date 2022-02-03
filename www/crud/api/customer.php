<?php

header("Content-Type: application/json");

use App\Entity\Customer;

require '../vendor/autoload.php';

$data = json_decode(file_get_contents('php://input'), true);

switch ($_SERVER['REQUEST_METHOD']) {

    case 'POST': // OK
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
            $resultCustomerCreated = $customer->create();
            print json_encode($resultCustomerCreated);
        }
        break;

    case 'GET': // OK

        $id = $_GET['id'];
        if ($id == NULL) {
            $customer = new Customer();
            $resultGetCustomer = $customer->getCustomers();
            print json_encode($resultGetCustomer);
            break;
        } else {
            if (isset(
                $id
            )) {
                $customer = new Customer(
                    $id
                );
                $resultGetCustomers = $customer->getCustomer($id);
                print json_encode($resultGetCustomers);
                break;
            }
        }


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
            print_r($customer);
            $customer->update();
        }
        break;

    case 'DELETE': // OK
        $id = $data['id'];
        $active = $data['active'];

        if (isset($id)) {
            $customer = new Customer(
                $id,
                $active
            );
            $resultDeleteCustomerAndAddress =  $customer->delete($id, $active);
            print json_encode($resultCustomerAndAndAddressDelete);
        }
        break;
}
