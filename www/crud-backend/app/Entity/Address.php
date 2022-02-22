<?php

namespace App\Entity;

use \App\Db\Database;

class Address
{
    private int $id;
    private string $street;
    private int $number;
    private string $district;
    private string $zipCode;
    private string $city;
    private string $state;

    public function __construct(
        $id             = NULL,
        $street         = NULL,
        $number         = NULL,
        $district       = NULL,
        $zipCode        = NULL,
        $city           = NULL,
        $state          = NULL,
        $idCustomer     = NULL
    ) {
        $this->idCustomer  = $idCustomer;
        $this->street       = $street;
        $this->number       = $number;
        $this->district     = $district;
        $this->zipCode      = $zipCode;
        $this->city         = $city;
        $this->state        = $state;
        $this->id           = $id;
    }

    public function create()
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

    public function getAddress($id)
    {
        return (new Database('address'))->select('id = ' . $id);
    }

    public function getAddressCustomer($idCustomer)
    {
        return (new Database('address'))->select('id_customer = ' . $idCustomer . ' AND active = 1');
    }

    public function getAddresses()
    {
        return (new Database('address'))->select();
    }

    public function update()
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
        print_r($values);
        $address = (new Database('address'))->update($where, $values);
        if ($address == 1) {
            return true;
        } else {
            return false;
        }
    }

    public function delete($id)
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
