<?php

namespace App\Entity;

use \App\Db\Database;

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
        $idCustomer     = NULL,
        $street         = NULL,
        $number         = NULL,
        $district       = NULL,
        $zipCode        = NULL,
        $city           = NULL,
        $state          = NULL,
        $active         = NULL
    ) {
        $this->id           = $id;
        $this->idCustomer  = $idCustomer;
        $this->street       = $street;
        $this->number       = $number;
        $this->district     = $district;
        $this->zipCode      = $zipCode;
        $this->city         = $city;
        $this->state        = $state;
        $this->active       = $active;
    }

    public function create() // OK
    {
        $address = (new Database('address'))->create([
            'id_customer'   => $this->idCustomer,
            'street'        => $this->street,
            'number'        => $this->number,
            'district'      => $this->district,
            'zip_code'      => $this->zipCode,
            'city'          => $this->city,
            'state'         => $this->state,
            'active'        => 1
        ]);
        if ($address != 0) {
            return true;
        } else {
            return false;
        }
    }

    public function getAddress($id) // OK
    {
        return (new Database('address'))->select('id = ' . $id);
    }

    public function getAddressCustomer($idCustomer) // OK
    {
        return (new Database('address'))->select('id_customer = ' . $idCustomer);
    }

    public function getAddresses() // OK
    {
        return (new Database('address'))->select();
    }

    public function update() // OK
    {
        $where = 'id = ' . $this->id;
        $values = [
            'street'        => $this->street,
            'number'        => $this->number,
            'district'      => $this->district,
            'zip_code'      => $this->zipCode,
            'city'          => $this->city,
            'state'         => $this->state
        ];
        $address = (new Database('address'))->update($where, $values);
        if ($address == 1) {
            return true;
        } else {
            return false;
        }
    }

    public function delete($id) // OK
    {
        $where = 'id = ' . $id;
        $values = ['active' => 0];
        $address = (new Database('address'))->update($where, $values);
        if ($address == 1) {
            return true;
        } else {
            return false;
        }
    }
}
