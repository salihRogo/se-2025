<?php

Flight::route('GET /admin/shop/reservations/@shop_id', function ($shop_id) {
    // Ensure the user is an admin
    $user = Flight::authService()->get_current_user();
    if ($user['role'] !== 'admin') {
        Flight::halt(403, "Access denied");
    }
    
    Flight::json(Flight::reservationsService()->get_shop_reservations($shop_id));
});