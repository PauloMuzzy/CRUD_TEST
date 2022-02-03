<?php

namespace App\Db;

use \PDO;
use \PDOException;

class Database
{
    private $table;
    private $connection;

    public function __construct($table = null)
    {
        $this->table = $table;
        $this->setConnection();
    }

    private function setConnection()
    {
        try {
            $this->connection = new PDO('mysql:host=db;dbname=crud_teste', 'root', 'root');
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    public function execute($query, $params = [])
    {
        try {
            $stmt = $this->connection->prepare($query);
            $stmt->execute($params);
            return $stmt;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    public function create($values)
    {
        print_r($values);
        $campos = array_keys($values);
        $binds  = array_pad([], count($campos), '?');
        $query = 'INSERT INTO ' . $this->table . ' (' . implode(',', $campos) . ') values (' . implode(',', $binds) . ')';
        $this->execute($query, array_values($values));
    }

    public function select($where = null, $limit = null, $campos = '*')
    {
        $where = strlen($where) ? 'WHERE ' . $where : '';
        $limit = strlen($limit) ? 'LIMIT ' . $limit : '';
        $query = 'SELECT ' . $campos . ' FROM ' . $this->table . ' ' . $where . ' ' . $limit;
        return $this->execute($query);
    }

    public function update($where, $values)
    {
        $campos = array_keys($values);
        $query = 'UPDATE ' . $this->table . ' SET ' . implode('=?,', $campos) . '=? WHERE ' . $where;
        print_r($query);
        $this->execute($query, array_values($values));
        return true;
    }

    // public function delete($where)
    // {
    //     print_r($where);
    //     $query = 'DELETE FROM ' . $this->table . ' WHERE ' . $where;
    //     $this->execute($query);
    //     return true;
    // }
}
