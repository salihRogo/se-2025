<?php

require_once __DIR__ . "/../dao/AuthDao.class.php";

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class AuthService {
    private $authDao;
    public function __construct() {
        $this->authDao = new AuthDao();
    }

    public function get_user_by_email($email){
        return $this->authDao->get_user_by_email($email);
    }

    public function get_current_user()
    {
        try {
            $token = Flight::request()->getHeader('Authentication');

            if (!$token) {
                Flight::halt(401, "Authentication header is missing");
            }
            // Decode the JWT token using the Key class
            $decoded = JWT::decode($token, new Key(Config::JWT_SECRET(), 'HS256'));
            return (array) $decoded->user; // Return the user object as an array
        } catch (Exception $e) {
            Flight::halt(401, $e->getMessage());
        }
    }
}