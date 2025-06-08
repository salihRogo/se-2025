<?php

require_once __DIR__ . '/../dao/UsersDao.class.php';
require_once __DIR__ . '/../dao/AuthDao.class.php';
require_once 'BaseService.class.php';

class UsersService
{
    private $users_dao;
    private $authDao;

    public function __construct()
    {
        $this->users_dao = new UsersDao();
        $this->authDao = new AuthDao();
    }

    public function add_user($payload)
    {
        $email_exists = $this->authDao->get_user_by_email($payload['email']);
        if ($email_exists) {
            return ['success' => false];
        } else {
            return $this->users_dao->add_user($payload);
        }
    }

    public function get_user_by_id($id)
    {
        return $this->users_dao->get_user_by_id($id);
    }

    public function get_users()
    {
        return $this->users_dao->get_all_users();
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
