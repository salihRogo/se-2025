<?php
require_once 'BaseService.class.php';
require_once __DIR__ . '/../dao/AuthDao.class.php';

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class AuthService extends BaseService
{
    private $auth_dao;
    public function __construct()
    {
        $this->auth_dao = new AuthDao();
        parent::__construct(new AuthDao);
    }

    public function get_user_by_email($email)
    {
        return $this->auth_dao->get_user_by_email($email);
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

    public function register($entity)
    {
        if (empty($entity['email']) || empty($entity['password'])) {
            return ['success' => false, 'error' => 'Email and password are required.'];
        }

        $email_exists = $this->auth_dao->get_user_by_email($entity['email']);
        if ($email_exists) {
            return ['success' => false, 'error' => 'Email already registered.'];
        }

        $entity['password'] = password_hash($entity['password'], PASSWORD_BCRYPT);

        $entity = parent::create($entity);

        unset($entity['password']);

        return ['success' => true, 'data' => $entity];
    }

    public function login($entity)
    {
        if (empty($entity['email']) || empty($entity['password'])) {
            return ['success' => false, 'error' => 'Email and password are required.'];
        }

        $user = $this->auth_dao->get_user_by_email($entity['email']);
        if (!$user) {
            return ['success' => false, 'error' => 'Invalid email.'];
        }

        if (!$user || !password_verify($entity['password'], $user['password'])) {
            return ['success' => false, 'error' => 'Invalid password.'];
        }

        unset($user['password']);

        $jwt_payload = [
            'user' => $user,
            'iat' => time(),
            'exp' => time() + (60 * 60 * 24)
        ];

        $token = JWT::encode(
            $jwt_payload,
            Config::JWT_SECRET(),
            'HS256'
        );

        return ['success' => true, 'data' => array_merge($user, ['token' => $token])];
    }
}
