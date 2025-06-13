<?php

class BaseDao
{
    protected $table_name;
    protected $connection;

    public function __construct($table_name)
    {
        $this->table_name = $table_name;
        require_once __DIR__ . '/Database.class.php';
        $this->connection = Database::connect();
    }

    public function get_all()
    {
        $query = "SELECT * FROM " . $this->table_name;
        $stmt = $this->connection->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function get_by_id($id)
    {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = ?";
        $stmt = $this->connection->prepare($query);
        $stmt->execute([(int) $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    protected function query($query, $params)
    {
        $stmt = $this->connection->prepare($query);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    protected function query_unique($query, $params)
    {
        $results = $this->query($query, $params);
        return reset($results);
    }

    /**
     * Method used to get add entity to database
     * string $first_name: First name is the first name of the course
     */
    public function add($entity)
    {
        $query = "INSERT INTO " . $this->table_name . " (";
        foreach ($entity as $column => $value) {
            $query .= $column . ', ';
        }
        $query = substr($query, 0, -2);
        $query .= ") VALUES (";
        foreach ($entity as $column => $value) {
            $query .= ":" . $column . ', ';
        }
        $query = substr($query, 0, -2);
        $query .= ")";

        $stmt = $this->connection->prepare($query);
        $stmt->execute($entity);
        $entity['id'] = $this->connection->lastInsertId();
        return $entity;
    }

    /**
     * Method used to update entity in database
     */
    public function update($entity, $id, $id_column = "id")
    {
        $query = "UPDATE " . $this->table_name . " SET ";
        foreach ($entity as $column => $value) {
            $query .= $column . "=:" . $column . ", ";
        }
        $query = substr($query, 0, -2);
        $query .= " WHERE " . $id_column . " = :id";
        $stmt = $this->connection->prepare($query);
        $entity['id'] = $id;
        $stmt->execute($entity);
        return $entity;
    }

    /**
     * Method used to delete entity from database
     */
    public function delete($id)
    {
        $stmt = $this->connection->prepare("DELETE FROM " . $this->table_name . " WHERE id = :id");
        $stmt->bindValue(':id', $id); #prevent SQL injection
        $stmt->execute();
    }
}
