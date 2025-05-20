<?php

Flight::route('GET /admin/shops', function () {
    // Ensure the user is an admin
    $user = Flight::authService()->get_current_user();
    if ($user['role'] !== 'admin') {
        Flight::halt(403, "Access denied");
    }

    // Fetch all shops
    $shops = Flight::shopsService()->get_all_shops();
    Flight::json($shops);
});

Flight::route('DELETE /admin/shops/@id', function ($id) {
    $user = Flight::authService()->get_current_user();
    if ($user['role'] !== 'admin') {
        Flight::halt(403, "Access denied");
    }

    $shop = Flight::shopsService()->get_shop_by_id($id);
    if (!$shop) {
        Flight::halt(404, "Shop not found");
    }

    Flight::shopsService()->delete_shop($id);

    Flight::json(["message" => "Shop and all related data deleted successfully"]);
});
