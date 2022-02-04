<?php

use App\Entity\Address;

require '../vendor/autoload.php';

$data = json_decode(file_get_contents('php://input'), true);

switch ($_SERVER['REQUEST_METHOD']) {

    case 'POST': // OK
        $idCustomer    = $data['idCustomer'];
        $street         = $data['street'];
        $number         = $data['number'];
        $district       = $data['district'];
        $zipCode        = $data['zipCode'];
        $city           = $data['city'];
        $state          = $data['state'];

        if (isset(
            $idCustomer,
            $street,
            $number,
            $district,
            $zipCode,
            $city,
            $state
        )) {
            $address = new Address(
                $idCustomer,
                $street,
                $number,
                $district,
                $zipCode,
                $city,
                $state,
                $active
            );
            print json_encode($address->create());
        }
        break;

    case 'GET': // OK

        $id = $_GET['id'];
        $idCustomer = $_GET['idCustomer'];

        if ($id != null) {
            if (isset($id)) {
                $address = new Address();
                print json_encode($address->getAddress($id));
                break;
            }
        } else if ($idCustomer != null) {
            if (isset($idCustomer)) {
                $address = new Address();
                print json_encode($address->getAddressCustomer($idCustomer));
                break;
            }
        } else {
            $address = new Address();
            print json_encode($address->getAddresses());
            break;
        }

    case 'PUT': // OK

        $id = $data['id'];
        $street = $data['street'];
        $number = $data['number'];
        $district = $data['district'];
        $zipCode = $data['zipCode'];
        $city = $data['city'];
        $state = $data['state'];

        if (isset(
            $id,
            $street,
            $number,
            $district,
            $zipCode,
            $city,
            $state
        )) {
            $address = new Address(
                $id,
                $idCustomer,
                $street,
                $number,
                $district,
                $zipCode,
                $city,
                $state
            );
            print json_encode($address->update());
        }
        break;

    case 'DELETE': // OK

        $id     = $data['id'];
        $active = $data['active'];

        if (isset($id)) {
            $address = new Address($id, $active);
            print json_encode($address->delete($id, $active));
        }
        break;
}
