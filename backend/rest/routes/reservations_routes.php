<?php

require_once __DIR__ . '/../services/ReservationsService.class.php';

Flight::route('GET /reservations', function () {
    Flight::json(Flight::reservationsService()->get_all_reservations());
});

Flight::route('GET /reservations/@id', function ($id) {
    Flight::json(Flight::reservationsService()->get_reservation_by_id($id));
});

Flight::route('POST /reservation', function () {
    $reservations = Flight::request()->data->getData();
    Flight::json(Flight::reservationsService()->add_reservation($reservations));
});

Flight::route('GET /user/reservations/@user_id', function ($user_id) {
    Flight::json(Flight::reservationsService()->get_user_reservations($user_id));
});

Flight::route('GET /shop/reservations/@shop_id', function ($shop_id) {
    Flight::json(Flight::reservationsService()->get_shop_reservations($shop_id));
});

Flight::route('DELETE /reservations/@id', function ($id) {
    Flight::json(Flight::reservationsService()->delete_reservation($id));
});

Flight::route('PUT /reservations/@id', function ($reservation_id) {
    $fields = Flight::request()->data->getData();
    Flight::json(Flight::reservationsService()->update_reservation($reservation_id, $fields));
});
