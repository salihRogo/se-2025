<?php

Flight::route('GET /admin/shops', function() {
    // Ensure the user is an admin
    $user = Flight::authService()->get_current_user();
    if ($user['role'] !== 'admin') {
        Flight::halt(403, "Access denied");
    }

    // Fetch all users
    $shops = Flight::shopsService()->get_all_shops();
    Flight::json($shops);
});