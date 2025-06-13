<?php

require_once __DIR__ . '/BaseDao.class.php';

class UsersDao extends BaseDao
{
    protected $table_name;

    public function __construct()
    {
        $this->table_name = "users";
        parent::__construct($this->table_name);
    }

    public function get_users()
    {
        return $this->get_all();
    }

    public function get_user_by_id($id)
    {
        return $this->get_by_id($id);
    }

    public function update_user($id, $user)
    {
        return $this->update($id, $user);
    }

    public function delete_user($id)
    {
        return $this->delete($id);
    }
}
