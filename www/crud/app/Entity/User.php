<?php

namespace App\Entity;

use Exception;
use \App\Db\Database;
use PDOException;

class User
{
    private $id;
    private $name;
    private $email;
    private $password;
    private $access;
    private $active;

    public function __construct(
        $name       = NULL,
        $email      = NULL,
        $password   = NULL,
        $access     = NULL,
        $active     = NULL,
        $id         = NULL
    ) {
        try {
            $this->name         = $name;
            $this->email        = $email;
            $this->password     = $password;
            $this->access       = $access;
            $this->active       = $active;
            $this->id           = $id;
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    public function create()
    {
        $password = $this->password;
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);

        print_r($this);
        $db = new Database('user');
        try {
            $db->create([
                'name'          => $this->name,
                'email'         => $this->email,
                'hash_password'      => $passwordHash,
                'access'        => 1,
                'active'        => 1
            ]);
        } catch (Exception $e) {
            print $e->getMessage();
            echo "Error: " . $e->getMessage();
        }
    }

    public static function getUser($id)
    {
        return (new Database('user'))->select('id = ' . $id);
    }

    public function update()
    {
        $where = 'id = ' . $this->id;
        $values = [
            'name'          => $this->name,
            'login'         => $this->login,
            'email'         => $this->email,
            'password'      => $this->password,
            'access'        => $this->access
        ];

        try {
            return (new Database('user'))->update($where, $values);
        } catch (PDOException $e) {
            print $e->getMessage();
            echo "Error: " . $e->getMessage();
        }
    }

    public static function delete($id)
    {
        (new DataBase('user'))->delete('id = ' . $id);
    }

    public static function disable($id)
    {
        $where = 'id = ' . $id;
        $values = [
            'active' => 0
        ];

        try {
            return (new Database('user'))->update($where, $values);
        } catch (PDOException $e) {
            print $e->getMessage();
            echo "Error: " . $e->getMessage();
        }
    }
}
