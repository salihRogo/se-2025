<?php
require_once __DIR__ . '/../../config.php';
require_once __DIR__ . '/../services/AuthService.class.php';

Flight::set('auth_service', new AuthService());

Flight::route('POST /login', function () {
    $payload = Flight::request()->data->getData();

    // Validate input
    if (empty($payload['email']) || empty($payload['password'])) {
        Flight::halt(400, "Email and password are required");
    }

    // Authenticate user
    $user = Flight::get('auth_service')->get_user_by_email($payload['email']);

    if (!$user || !password_verify($payload['password'], $user['password'])) {
        Flight::halt(401, "Invalid username or password");
    }

    // Remove sensitive data (e.g., password) before returning the user
    unset($user['password']);

    // Return the authenticated user data
    Flight::json($user);
});