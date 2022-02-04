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

    public function create()
    {
        $password = $this->password;
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);

        $db = new Database('user');
        $db->create([
            'name'          => $this->name,
            'email'         => $this->email,
            'hash_password'      => $passwordHash,
            'access'        => 1,
            'active'        => 1
        ]);
    }

    public static function getUser($id)
    {
        // return (new Database('user'))->select('id = ' . $id);
    }

    public function update()
    {
        // $where = 'id = ' . $this->id;
        // $values = [
        //     'name'          => $this->name,
        //     'login'         => $this->login,
        //     'email'         => $this->email,
        //     'password'      => $this->password,
        //     'access'        => $this->access
        // ];

        // return (new Database('user'))->update($where, $values);
    }

    public static function delete($id)
    {
        // (new DataBase('user'))->delete('id = ' . $id);
    }

    public static function disable($id)
    {
        // $where = 'id = ' . $id;
        // $values = [
        //     'active' => 0
        // ];

        // return (new Database('user'))->update($where, $values);
    }
}
