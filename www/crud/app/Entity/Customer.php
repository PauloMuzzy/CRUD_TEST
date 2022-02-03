<?php

namespace App\Entity;

use \App\Db\Database;

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
        $this->id           = $id;
        $this->name         = $name;
        $this->birthDate    = $birthDate;
        $this->cpf          = $cpf;
        $this->document     = $document;
        $this->phone        = $phone;
        $this->active       = $active;
        $this->address      = $address;
    }

    public function create() // OK
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
            return $customerCreated;
        }
    }

    public function getCustomer($id)
    {
        $customer = (new Database('customers'))->select('id = ' . $id);
    }

    public function getCustomers()
    {
        $customers = (new Database('customers'))->select();
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
    }

    public function delete($id, $active)
    {
        $whereCustomer = 'id = ' . $id;
        $values = ['active' => $active];
        $customer = (new Database('customers'))->update($whereCustomer, $values);
        $resultCustomer = $customer->rowCount();
        $resultCustomerAndAndAddressDelete = array('customerDeleted' => $resultCustomer);

        if ($customer == 1) {
            $whereAddress = 'id_customer = ' . $id;
            $address = (new Database('address'))->update($whereAddress, $values);
            $resultAddress = $address->rowCount();
            $resultCustomerAndAndAddressDelete['addressDeleted'] = $resultAddress;
            return $resultCustomerAndAndAddressDelete;
        } else {
            return false;
        }
    }
}
