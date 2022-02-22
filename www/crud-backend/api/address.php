<?php

header("Content-Type: application/json");

use App\Entity\Address;
use \Exception;

require '../vendor/autoload.php';
require '../utils/dataValidator.php';

$data = json_decode(file_get_contents('php://input'), true);

try {
    switch ($_SERVER['REQUEST_METHOD']) {

        case 'POST':

            $idCustomer = validateData('id',        $data['idCustomer']);
            $street     = validateData('street',    $data['street']);
            $number     = validateData('number',    $data['number']);
            $district   = validateData('district',  $data['district']);
            $zipCode    = validateData('zipCode',   $data['zipCode']);
            $city       = validateData('city',      $data['city']);
            $state      = validateData('state',     $data['state']);

            try {
                $address = new Address(
                    $id,
                    $street,
                    $number,
                    $district,
                    $zipCode,
                    $city,
                    $state,
                    $idCustomer
                );
                print json_encode($address->create());
                break;
            } catch (Exception $e) {
                print json_encode([
                    'status' => 'error',
                    'message' => ($e->getMessage())
                ]);
            }

        case 'GET':

            $id = $_GET['id'];
            $idCustomer = $_GET['idCustomer'];

            if ($id != null) {
                try {
                    $address = new Address();
                    print json_encode($address->getAddress($id));
                    break;
                } catch (Exception $e) {
                    print json_encode([
                        'status' => 'error',
                        'message' => ($e->getMessage())
                    ]);
                }
            } else if ($idCustomer != null) {
                try {
                    $address = new Address();
                    print json_encode($address->getAddressCustomer($idCustomer));
                    break;
                } catch (Exception $e) {
                    print json_encode([
                        'status' => 'error',
                        'message' => ($e->getMessage())
                    ]);
                }
            } else {
                try {
                    $address = new Address();
                    print json_encode($address->getAddresses());
                    break;
                } catch (Exception $e) {
                    print json_encode([
                        'status' => 'error',
                        'message' => ($e->getMessage())
                    ]);
                }
            }

        case 'PUT':

            $id         = validateData('id',        $data['id']);
            $street     = validateData('street',    $data['street']);
            $number     = validateData('number',    $data['number']);
            $district   = validateData('district',  $data['district']);
            $zipCode    = validateData('zipCode',   $data['zipCode']);
            $city       = validateData('city',      $data['city']);
            $state      = validateData('state',     $data['state']);

            try {
                $address = new Address(
                    $id,
                    $street,
                    $number,
                    $district,
                    $zipCode,
                    $city,
                    $state,
                    NULL
                );
                print json_encode($address->update());
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
                $address = new Address($id);
                print json_encode($address->delete($id));
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
