<?php

namespace App\Entity;

use \App\Db\Database;
use \Exception;

class Customer
{
    private int $id;
    private string $name;
    private string $birthDate;
    private string $cpf;
    private string $document;
    private string $phone;
    private int $active;
    private object $address;

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
        $this->id           = $id;
        $this->name         = $name;
        $this->birthDate    = $birthDate;
        $this->cpf          = $cpf;
        $this->document     = $document;
        $this->phone        = $phone;
        $this->active       = $active;
        $this->address      = $address;
    }

    public function create()
    {
        $customer = new Database('customers');
        $address = new Database('address');
        $addressCustomer = $this->address;
        $customerCreated = $customer->create([
            'name'          => $this->name,
            'birth_date'    => $this->birthDate,
            'cpf'           => $this->cpf,
            'document'      => $this->document,
            'phone'         => $this->phone,
            'active'        => 1
        ]);
        if ($customerCreated > 0) {
            $address->create([
                'id_customer'   => $customerCreated,
                'street'        => $addressCustomer['street'],
                'number'        => $addressCustomer['number'],
                'district'      => $addressCustomer['district'],
                'zip_code'      => $addressCustomer['zipCode'],
                'city'          => $addressCustomer['city'],
                'state'         => $addressCustomer['state'],
                'active'        => 1
            ]);
            return true;
        } else {
            throw new Exception('OPS! Algo deu errado. Tente novamente!!!');
        }
    }

    public function getCustomers()
    {
        $customers = (new Database('customers'))->select('active = 1');
        return $customers;
    }

    public function getCustomer($id)
    {
        $customer = (new Database('customers'))->select('id = ' . $id . ' AND active = 1');
        return $customer;
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
        (new Database('customers'))->update($where, $values);
        return true;
    }

    public function delete($id)
    {
        $whereCustomer = 'id = ' . $id;
        $values = ['active' => 0];
        $customer = (new Database('customers'))->update($whereCustomer, $values);
        if ($customer == 1) {
            $whereAddress = 'id_customer = ' . $id;
            (new Database('address'))->update($whereAddress, $values);
            return true;
        } else {
            return false;
        }
    }
}
