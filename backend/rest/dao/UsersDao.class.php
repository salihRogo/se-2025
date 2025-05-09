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
        $this->update("users", $id, $user);
    }

    public function get_all_users()
    {
        return $this->query("SELECT * FROM users", []);
    }
}
