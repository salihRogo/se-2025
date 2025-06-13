<?php

Flight::route('GET /admin/shops', function () {
    // Ensure the user is an admin
    $user = Flight::auth_service()->get_current_user();
    if ($user['role'] !== 'admin') {
        Flight::halt(403, "Access denied");
    }

    // Fetch all shops
    $shops = Flight::shopsService()->get_all_shops();
    Flight::json($shops);
});

Flight::route('DELETE /admin/shops/@id', function ($id) {
    $user = Flight::auth_service()->get_current_user();
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

Flight::route('PUT /admin/shops/@id', function ($id) {
    $user = Flight::auth_service()->get_current_user();
    if ($user['role'] !== 'admin') {
        Flight::halt(403, "Access denied");
    }

    $shop = Flight::shopsService()->get_shop_by_id($id);
    if (!$shop) {
        Flight::halt(404, "Shop not found");
    }

    $data = Flight::request()->data->getData();
    Flight::shopsService()->update_shop($id, $data);

    Flight::json(["message" => "Shop updated successfully"]);
});

Flight::route('POST /admin/shops', function () {
    $user = Flight::auth_service()->get_current_user();
    if ($user['role'] !== 'admin') {
        Flight::halt(403, "Access denied");
    }

    $data = Flight::request()->data->getData();
    $shop_id = Flight::shopsService()->add_shop($data);

    Flight::json([
        "message" => "Shop added successfully",
        "id" => $shop_id
    ]);
});
