<?php

namespace App\Entity;

use \App\Db\Database;

class User
{
    private int $id;
    private string $name;
    private string $email;
    private string $password;
    private string $access;
    private int $active;

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

        $user = (new Database('user'))->create([
            'name'          => $this->name,
            'email'         => $this->email,
            'hash_password' => $passwordHash,
            'access'        => 1,
            'active'        => 1
        ]);
        if ($user != 0) {
            return true;
        } else {
            return false;
        }
    }

    public static function getUser($id)
    {
        return (new Database('user'))->select('id = ' . $id);
    }

    public static function getUsers()
    {
        return (new Database('user'))->select();
    }

    public function update()
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

    public function delete($id)
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

    public function login($email, $password)
    {
        $user = (new Database('user'))->select('email = ' . '"' . $email . '"');
        $name = $user[0]['name'];
        $hash_password = $user[0]['hash_password'];
        $access = $user[0]['access'];

        if (password_verify($password, $hash_password)) {
            return array('name' => $name, 'access' =>  $access, 'valid' => true);
        }
        return array('name' => NULL, 'access' =>  NULL, 'valid' => false);
    }
}
