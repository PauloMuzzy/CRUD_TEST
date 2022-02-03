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
        print_r($this);
        $address = $this->address;
        $db         = new Database('customers');
        $db2        = new Database('address');
        try {
            $db->create([
                'name'          => $this->name,
                'birth_date'    => $this->birthDate,
                'cpf'           => $this->cpf,
                'document'      => $this->document,
                'phone'         => $this->phone,
                'active'        => 1
            ]);
            for ($i = 0; $i < count($address); $i++) {
                $db2->create([
                    'cpf_customer'  => $this->cpf,
                    'street'        => $this->address[$i]['street'],
                    'number'        => $this->address[$i]['number'],
                    'district'      => $this->address[$i]['district'],
                    'zip_code'      => $this->address[$i]['zipCode'],
                    'city'          => $this->address[$i]['city'],
                    'state'         => $this->address[$i]['state'],
                    'active'        => 1
                ]);
            }
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

    public static function delete($id)
    {
        $customer = (new Database('customers'))->delete('id = ' . $id);
    }

    public function disable($id)
    {
        $where = 'id = ' . $id;
        $values = [
            'active' => 0
        ];

        try {
            return (new Database('customer'))->update($where, $values);
        } catch (PDOException $e) {
            print $e->getMessage();
            echo "Error: " . $e->getMessage();
        }
    }
}
