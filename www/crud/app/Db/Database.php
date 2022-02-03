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
        $campos = array_keys($values);
        $binds  = array_pad([], count($campos), '?');
        try {
            $query = 'INSERT INTO ' . $this->table . ' (' . implode(',', $campos) . ') values (' . implode(',', $binds) . ')';
            $this->execute($query, array_values($values));
            return ($this->connection->lastInsertId());
        } catch (PDOException $e) {
            $e->getMessage();
            return "Error: " . $e->getMessage();
        }
    }

    public function select($where = null, $limit = null, $campos = '*')
    {
        $where = strlen($where) ? 'WHERE ' . $where : '';
        $limit = strlen($limit) ? 'LIMIT ' . $limit : '';
        $query = 'SELECT ' . $campos . ' FROM ' . $this->table . ' ' . $where . ' ' . $limit;
        $this->execute($query);
        return $this->$query->fetchAll();
    }

    public function update($where, $values)
    {
        try {
            $campos = array_keys($values);
            $query = 'UPDATE ' . $this->table . ' SET ' . implode('=?,', $campos) . '=? WHERE ' . $where;
            return  $this->execute($query, array_values($values));
        } catch (PDOException $e) {
            print $e->getMessage();
            echo "Error: " . $e->getMessage();
        }
    }
}
