<?php

header("Content-Type: application/json");

use App\Entity\Customer;
use \Exception;

require '../vendor/autoload.php';

require '../utils/dataValidator.php';

$data = json_decode(file_get_contents('php://input'), true);

try {
    switch ($_SERVER['REQUEST_METHOD']) {

        case 'POST':
            $name       = validateData('name',      $data['name']);
            $birthDate  = validateData('birthDate', $data['birthDate']);
            $cpf        = validateData('cpf',       $data['cpf']);
            $document   = validateData('doc',       $data['doc']);
            $phone      = validateData('phone',     $data['phone']);
            $address    = $data['address'];
            $street     = validateData('street',    $address['street']);
            $number     = validateData('number',    $address['number']);
            $distric    = validateData('distric',   $address['distric']);
            $zipCode    = validateData('zipCode',   $address['zipCode']);
            $city       = validateData('city',      $address['city']);
            $state      = validateData('state',     $address['state']);

            try {
                $customer = new Customer(
                    NULL,
                    $name,
                    $birthDate,
                    $cpf,
                    $document,
                    $phone,
                    $address
                );
                print json_encode($customer->create());
                break;
            } catch (Exception $e) {
                print json_encode([
                    'status' => 'error',
                    'message' => ($e->getMessage())
                ]);
            }

        case 'GET':

            $id = $_GET['id'];

            if ($id == NULL) {
                try {
                    $customer = new Customer();
                    print json_encode($customer->getCustomers());
                    break;
                } catch (Exception $e) {
                    print json_encode([
                        'status' => 'error',
                        'message' => ($e->getMessage())
                    ]);
                }
            } else {
                try {
                    $customers = new Customer($id);
                    print json_encode($customers->getCustomer($id));
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
            $name       = validateData('name',      $data['name']);
            $birthDate  = validateData('birthDate', $data['birthDate']);
            $cpf        = validateData('cpf',       $data['cpf']);
            $document   = validateData('doc',       $data['doc']);
            $phone      = validateData('phone',     $data['phone']);

            try {
                $customer = new Customer(
                    $id,
                    $name,
                    $birthDate,
                    $cpf,
                    $document,
                    $phone
                );
                print json_encode($customer->update());
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
                $customer = new Customer($id);
                print json_encode($customer->delete($id));
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
