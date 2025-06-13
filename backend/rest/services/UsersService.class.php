<?php

require_once __DIR__ . '/../dao/UsersDao.class.php';
require_once __DIR__ . '/../dao/AuthDao.class.php';
require_once 'BaseService.class.php';

class UsersService extends BaseService
{
    private $users_dao;

    public function __construct()
    {
        $this->users_dao = new UsersDao();
        parent::__construct($this->users_dao);
    }

    public function get_users()
    {
        return $this->users_dao->get_users();
    }

    public function get_user_by_id($id)
    {
        return $this->users_dao->get_user_by_id($id);
    }

    public function update_user($id, $user)
    {
        return $this->users_dao->update_user($id, $user);
    }

    public function delete_user($id)
    {
        return $this->users_dao->delete_user($id);
    }
}
