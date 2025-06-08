<?php

require_once __DIR__ . '/../services/UsersService.class.php';

// Add a new user
Flight::route('POST /users', function () {
    $data = Flight::request()->data->getData();

    // Validate required fields
    if (!isset($data['full_name']) || !isset($data['email']) || !isset($data['password']) || !isset($data['password_confirm']) || !isset($data['phone_number'])) {
        Flight::json(["message" => "All fields are required."], 400);
        return;
    }

    // Email validation
    if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
        Flight::json(["message" => "Invalid email address."], 400);
        return;
    }

    // Password length validation
    if (strlen($data['password']) < 8) {
        Flight::json(["message" => "Password must be at least 8 characters."], 400);
        return;
    }

    // Check if passwords match
    if ($data['password'] !== $data['password_confirm']) {
        Flight::json(["message" => "Password and confirm password do not match."], 400);
        return;
    }

    // Phone number validation (at least 8 digits, only numbers)
    if (!preg_match('/^\d{8,}$/', $data['phone_number'])) {
        Flight::json(["message" => "Please enter a valid phone number."], 400);
        return;
    }

    // Hash the password and remove the confirm password field
    $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
    unset($data['password_confirm']);

    // Add the user
    $user = Flight::usersService()->add_user($data);
    if (array_key_exists("success", $user)) {
        if ($user["success"] == false) {
            Flight::json(["message" => "Email already registered."], 400);
            return;
        }
    }
    return Flight::json($user);
});

// Get a user by ID
Flight::route('GET /user/@id', function ($id) {
    $user = Flight::usersService()->get_user_by_id($id);
    if (!$user) {
        Flight::halt(404, 'User not found');
    }
    Flight::json($user);
});

// Get all users
Flight::route('GET /users', function () {
    $users = Flight::usersService()->get_users();
    Flight::json($users);
});

// Update a user by ID
Flight::route('PUT /user/@id', function ($id) {
    $data = Flight::request()->data->getData();

    // Update the user
    $user = Flight::usersService()->update_user($id, $data);
    Flight::json($user);
});

Flight::route('PUT /user/@id/password', function ($id) {
    $data = Flight::request()->data->getData();

    if (!isset($data['new_password'])) {
        Flight::json(["message" => "New password is required."], 400);
        return;
    }

    if (strlen($data['new_password']) < 8) {
        Flight::json(["message" => "New password must be at least 8 characters."], 400);
        return;
    }

    $update_data = ["password" => password_hash($data['new_password'], PASSWORD_DEFAULT)];
    Flight::usersService()->update_user($id, $update_data);

    Flight::json(["message" => "Password updated successfully."]);
});
