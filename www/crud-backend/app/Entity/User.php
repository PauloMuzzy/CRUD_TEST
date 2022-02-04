<?php

namespace App\Entity;

use \App\Db\Database;

class User
{
    private $id;
    private $name;
    private $email;
    private $password;
    private $access;
    private $active;

    public function __construct(
        $id         = NULL,
        $name       = NULL,
        $email      = NULL,
        $password   = NULL,
        $access     = NULL,
        $active     = NULL
    ) {
        $this->id           = $id;
        $this->name         = $name;
        $this->email        = $email;
        $this->password     = $password;
        $this->access       = $access;
        $this->active       = $active;
    }

    public function create() // OK
    {
        $password = $this->password;
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);

        $user = (new Database('user'))->create([
            'name'          => $this->name,
            'email'         => $this->email,
            'hash_password' => $passwordHash,
            'access'        => 2,
            'active'        => 1
        ]);
        if ($user != 0) {
            return true;
        } else {
            return false;
        }
    }

    public static function getUser($id) // OK
    {
        return (new Database('user'))->select('id = ' . $id);
    }

    public static function getUsers() // OK
    {
        return (new Database('user'))->select();
    }

    public function update() // OK
    {
        $where = 'id = ' . $this->id;
        $values = [
            'name'          => $this->name,
            'email'         => $this->email,
            'access'        => $this->access
        ];
        $user = (new Database('user'))->update($where, $values);
        if ($user == 1) {
            return true;
        } else {
            return false;
        }
    }

    public function delete($id) // OK
    {
        $where = 'id = ' . $id;
        $values = ['active' => 0];
        $user = (new Database('user'))->update($where, $values);
        if ($user == 1) {
            return true;
        } else {
            return false;
        }
    }
}
