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
            print_r("Error: " . $e->getMessage());
        }
    }

    public function execute($query, $params = [])
    {
        try {
            $stmt = $this->connection->prepare($query);
            $stmt->execute($params);
            return $stmt;
        } catch (PDOException $e) {
            print_r("Error: " . $e->getMessage());
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

    public function select($where = null, $limit = null, $column = '*')
    {
        $where = strlen($where) ? 'WHERE ' . $where : '';
        $limit = strlen($limit) ? 'LIMIT ' . $limit : '';
        try {
            $query = 'SELECT ' . $column . ' FROM ' . $this->table . ' ' . $where . ' ' . $limit;
            return $this->execute($query)->fetchAll();
        } catch (PDOException $e) {
            $e->getMessage();
            return "Error: " . $e->getMessage();
        }
    }

    public function update($where, $values)
    {
        $column = array_keys($values);
        try {

            $query = 'UPDATE ' . $this->table . ' SET ' . implode('=?,', $column) . '=? WHERE ' . $where;
            return  $this->execute($query, array_values($values))->rowCount();
        } catch (PDOException $e) {
            $e->getMessage();
            return "Error: " . $e->getMessage();
        }
    }
}
