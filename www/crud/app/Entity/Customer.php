<?php

namespace App\Entity;

use Exception;
use \App\Db\Database;
use PDOException;

class Customer
{
    private $id;
    private $name;
    private $birthDate;
    private $cpf;
    private $document;
    private $phone;
    private $active;
    private $address;

    public function __construct(
        $id         = NULL,
        $name       = NULL,
        $birthDate  = NULL,
        $cpf        = NULL,
        $document   = NULL,
        $phone      = NULL,
        $address    = NULL,
        $active     = NULL

    ) {
        try {
            $this->id           = $id;
            $this->name         = $name;
            $this->birthDate    = $birthDate;
            $this->cpf          = $cpf;
            $this->document     = $document;
            $this->phone        = $phone;
            $this->active       = $active;
            $this->address      = $address;
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    public function create()
    {
        $customer = new Database('customers');
        $address = new Database('address');
        $addressCustomer = $this->address;
        $resultAddressCreated = [];

        try {
            $customerCreated = $customer->create([
                'name'          => $this->name,
                'birth_date'    => $this->birthDate,
                'cpf'           => $this->cpf,
                'document'      => $this->document,
                'phone'         => $this->phone,
                'active'        => 1
            ]);

            $resultCustomerCreated = array('customerCreated' => $customerCreated);

            if ($customerCreated > 0) {
                for ($i = 0; $i < count($addressCustomer); $i++) {
                    $addressCreated = $address->create([
                        'id_customer'   => $customerCreated,
                        'street'        => $this->address[$i]['street'],
                        'number'        => $this->address[$i]['number'],
                        'district'      => $this->address[$i]['district'],
                        'zip_code'      => $this->address[$i]['zipCode'],
                        'city'          => $this->address[$i]['city'],
                        'state'         => $this->address[$i]['state'],
                        'active'        => 1
                    ]);
                    array_push($resultAddressCreated, $addressCreated);
                }
                $resultCustomerCreated['addressCreated'] = $resultAddressCreated;
            }
            print_r($resultCustomerCreated);
            return $resultCustomerCreated;
        } catch (Exception $e) {
            print $e->getMessage();
            echo "Error: " . $e->getMessage();
        }
    }

    public function getCustomer($id)
    {
        try {
            return (new Database('customers'))->select('id = ' . $id)->fetchObject();
        } catch (PDOException $e) {
            print $e->getMessage();
            echo "Error: " . $e->getMessage();
        }
    }

    public function getCustomers()
    {
        try {
            return (new Database('customers'))->select()->fetchAll();
        } catch (PDOException $e) {
            print $e->getMessage();
            echo "Error: " . $e->getMessage();
        }
    }

    public function update()
    {
        $where = 'id = ' . $this->id;
        $values = [
            'name'          => $this->name,
            'birth_date'    => $this->birthDate,
            'cpf'           => $this->cpf,
            'document'      => $this->document,
            'phone'         => $this->phone
        ];

        try {
            return (new Database('customers'))->update($where, $values);
        } catch (PDOException $e) {
            print $e->getMessage();
            echo "Error: " . $e->getMessage();
        }
    }

    public function delete($id, $active)
    {
        try {
            $whereCustomer = 'id = ' . $id;
            $values = ['active' => $active];
            $customer = (new Database('customers'))->update($whereCustomer, $values);
            $resultCustomer = $customer->rowCount();
            $resultDeleteCustomerAndAddress = array('customerDeleted' => $resultCustomer);

            if ($customer == 1) {
                $whereAddress = 'id_customer = ' . $id;
                $address = (new Database('address'))->update($whereAddress, $values);
                $resultAddress = $address->rowCount();
                $resultDeleteCustomerAndAddress['addressDeleted'] = $resultAddress;
                return ($resultDeleteCustomerAndAddress);
            } else {
                return false;
            }
        } catch (PDOException $e) {
            print $e->getMessage();
            echo "Error: " . $e->getMessage();
        }
    }
}
