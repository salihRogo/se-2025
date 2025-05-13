<?php

require_once __DIR__ . '/../services/AuthService.class.php';

Flight::route('GET /admin/users', function () {
    // Ensure the user is an admin
    $user = Flight::authService()->get_current_user();
    if ($user['role'] !== 'admin') {
        Flight::halt(403, "Access denied");
    }

    // Fetch all users
    $users = Flight::usersService()->get_users();
    Flight::json($users);
});

Flight::route('PUT /admin/users/@id', function ($id) {
    $data = Flight::request()->data->getData();

    // Hash the password if it's provided
    if (!empty($data['password'])) {
        $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
    }

    // Update the user
    $user = Flight::usersService()->update_user($id, $data);
    Flight::json($user);
});

Flight::route('DELETE /admin/users/@id', function ($id) {
    $user = Flight::usersService()->get_user_by_id($id);

    if (!$user) {
        Flight::halt(404, "User not found");
    }

    Flight::usersService()->delete_user($id);
    Flight::json(["message" => "User deleted successfully"]);
});