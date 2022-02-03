<?php

use App\Entity\Address;

require '../vendor/autoload.php';

$data = json_decode(file_get_contents('php://input'), true);

switch ($_SERVER['REQUEST_METHOD']) {

    case 'POST':
        $cpfCustomer    = $data['cpfCustomer'];
        $street         = $data['street'];
        $number         = $data['number'];
        $district       = $data['district'];
        $zipCode        = $data['zipCode'];
        $city           = $data['city'];
        $state          = $data['state'];

        if (isset(
            $cpfCustomer,
            $street,
            $number,
            $district,
            $zipCode,
            $city,
            $state
        )) {
            $address = new Address(
                $cpfCustomer,
                $street,
                $number,
                $district,
                $zipCode,
                $city,
                $state,
                $active
            );
            $address->create();
        }
        break;

    case 'GET':

        $id = $_GET['id'];

        if (isset($id)) {
            $address = new Address($id);
            print json_encode($address);
        }
        break;

    case 'PUT':

        $id = $data['id'];
        $cpfCustomer = $data['cpfCustomer'];
        $street = $data['street'];
        $number = $data['number'];
        $district = $data['district'];
        $zipCode = $data['zipCode'];
        $city = $data['city'];
        $state = $data['state'];

        if (isset(
            $id,
            $cpfCustomer,
            $street,
            $number,
            $district,
            $zipCode,
            $city,
            $state
        )) {
            $address = new Address(
                $id,
                $cpfCustomer,
                $street,
                $number,
                $district,
                $zipCode,
                $city,
                $state
            );
            $customer->update();
        }
        break;
}


        // case 'DELETE':
        //     echo '$_DELETE';
        //     break;

 
// {"cpfCustomer":"12312312312","street":"rua teste","number":"123","district":"centro","zipCode":"13481466","city":"limeira","state":"sao paulo"}
// {"id":"1","cpfCustomer":"12312312312","street":"rua teste","number":"123","district":"barroca","zipCode":"13481466","city":"limeira","state":"sao paulo"}