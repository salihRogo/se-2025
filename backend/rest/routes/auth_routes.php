<?php

require_once __DIR__ . '/../../config.php';
require_once __DIR__ . '/../services/AuthService.class.php';

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

Flight::route('POST /login', function () {
    $payload = Flight::request()->data->getData();

    // Validate input
    if (empty($payload['email']) || empty($payload['password'])) {
        Flight::halt(400, "Email and password are required");
    }

    // Authenticate user
    $user = Flight::authService()->get_user_by_email($payload['email']);

    if (!$user || !password_verify($payload['password'], $user['password'])) {
        Flight::halt(401, "Invalid username or password");
    }

    // Remove sensitive data (e.g., password)
    unset($user['password']);

    // Prepare JWT payload
    $jwt_payload = [
        'user' => $user,
        'iat' => time(),
        'exp' => time() + (60 * 60) // Valid for 1 hour
    ];

    // Generate JWT token
    $token = JWT::encode(
        $jwt_payload,
        Config::JWT_SECRET(),
        'HS256'
    );

    // Return user data with the token
    Flight::json(
        array_merge($user, ['token' => $token])
    );
});