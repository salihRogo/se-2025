<?php

require_once __DIR__ . '/../services/UsersService.class.php';

Flight::route('GET /user/@id', function ($id) {
    $user = Flight::usersService()->get_user_by_id($id);
    if (!$user) {
        Flight::halt(404, 'User not found');
    }
    Flight::json($user);
});

Flight::route('GET /users', function () {
    $users = Flight::usersService()->get_users();
    Flight::json($users);
});

Flight::route('PUT /user/@id', function ($id) {
    $data = Flight::request()->data->getData();

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
