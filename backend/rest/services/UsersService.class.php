<?php

require_once __DIR__ . '/../dao/UsersDao.class.php';
require_once 'BaseService.class.php';

class UsersService {
    private $users_dao;

    public function __construct() {
        $this->users_dao = new UsersDao();
    }

    public function add_user($payload) {
        return $this->users_dao->add_user($payload);
    }

    public function get_user_by_id($id) {
        return $this->users_dao->get_user_by_id($id);
    }

    public function get_users() { 
        return $this->users_dao->get_all_users();
    }

    public function update_user($id, $user) {
        return $this->users_dao->update_user($id, $user);
    }
}