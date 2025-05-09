<?php
require_once __DIR__ . '/../services/UsersService.class.php';

Flight::set('users_service', new UserService());

// Add a new user
Flight::route('POST /users', function () {
    $data = Flight::request()->data->getData();

    // Validate required fields
    if (!isset($data['full_name']) || !isset($data['email']) || !isset($data['password'])) {
        Flight::halt(400, 'Full name, email, password, and confirm password are required');
    }

    // Check if passwords match
    if ($data['password'] !== $data['password_confirm']) {
        Flight::halt(400, 'Password and confirm password do not match');
    }

    // Hash the password and remove the confirm password field
    $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
    unset($data['password_confirm']);

    // Add the user
    $user = Flight::get('users_service')->add_user($data);
    Flight::json($user);
});
// Get a user by ID
Flight::route('GET /user/@id', function ($id) {
    $user = Flight::get('users_service')->get_user_by_id($id);
    if (!$user) {
        Flight::halt(404, 'User not found');
    }
    Flight::json($user);
});

// Get all users
Flight::route('GET /users', function () {
    $users = Flight::get('users_service')->get_users();
    Flight::json($users);
});

// Update a user by ID
Flight::route('PUT /user/@id', function ($id) {
    $data = Flight::request()->data->getData();

    // Update the user
    $user = Flight::get('users_service')->update_user($id, $data);
    Flight::json($user);
});
