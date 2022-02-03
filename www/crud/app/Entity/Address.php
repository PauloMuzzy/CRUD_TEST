<?php

namespace App\Entity;

use \App\Db\Database;
use Exception;

class Address
{
    private $id;
    private $street;
    private $number;
    private $district;
    private $zipCode;
    private $city;
    private $state;
    private $active;

    public function __construct(
        $id             = NULL,
        $cpfCustomer    = NULL,
        $street         = NULL,
        $number         = NULL,
        $district       = NULL,
        $zipCode        = NULL,
        $city           = NULL,
        $state          = NULL,
        $active         = NULL
    ) {
        try {
            $this->id           = $id;
            $this->cpfCustomer  = $cpfCustomer;
            $this->street       = $street;
            $this->number       = $number;
            $this->district     = $district;
            $this->zipCode      = $zipCode;
            $this->city         = $city;
            $this->state        = $state;
            $this->active       = $active;
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    public function create()
    {
        try {
            $db = new Database('address');
            return $db->insert([
                'cpf_customer'  => $this->cpfCustomer,
                'street'        => $this->street,
                'number'        => $this->number,
                'district'      => $this->district,
                'zip_code'      => $this->zipCode,
                'city'          => $this->city,
                'state'         => $this->state,
                'active'        => 1,
            ]);
        } catch (Exception $e) {
            print $e->getMessage();
            echo "Error: " . $e->getMessage();
        }
    }

    public static function getAddress($id)
    {
        return (new Database('address'))->select('id = ' . $id)
            ->fetchObject();
    }

    public function update()
    {
        $where = 'id = ' . $this->id;
        $values = [
            'cpf_customer'  => $this->cpfCustomer,
            'street'        => $this->street,
            'number'        => $this->number,
            'district'      => $this->district,
            'zip_code'      => $this->zipCode,
            'city'          => $this->city,
            'state'         => $this->state,
        ];
        try {
            return (new Database('address'))->update($where, $values);
        } catch (Exception $e) {
            print $e->getMessage();
            echo "Error: " . $e->getMessage();
        }
    }

    public function erase()
    {
        return (new DataBase('addresses'))->delete('id = ' . $this->id);
    }
}
