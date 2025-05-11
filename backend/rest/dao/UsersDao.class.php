<?php

require_once __DIR__ . '/BaseDao.class.php';

class UsersDao extends BaseDao
{
    public function __construct()
    {
        parent::__construct('users');
    }

    public function add_user($payload)
    {
        $query = 'INSERT INTO users (full_name, email, password, phone_number)
        VALUES (:full_name, :email, :password, :phone_number)';
        $params = [
            "full_name" => $payload['full_name'],
            "email" => $payload['email'],
            "password" => $payload['password'],
            "phone_number" => $payload['phone_number']
        ];
        return $this->query($query, $params);
    }

    public function get_user_by_id($id)
    {
        return $this->query_unique("SELECT * FROM users WHERE id = :id", ["id" => $id]);
    }

    public function update_user($id, $user)
    {
        $this->update_user_call("users", $id, $user);
    }

    public function update_user_call($table, $id, $entity, $id_column = "id")
    {
        $query = "UPDATE {$table} SET ";
        foreach ($entity as $name => $value) {
        $query .= $name . "= :" . $name . ", ";
        }
        $query = substr($query, 0, -2);
        $query .= " WHERE {$id_column} = :id";
        $stmt = $this->connection->prepare($query);
        $entity['id'] = $id;
        $stmt->execute($entity);
    }

    public function get_all_users()
    {
        return $this->query("SELECT * FROM users", []);
    }
}
