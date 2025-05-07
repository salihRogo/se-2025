<?php

require_once __DIR__ . '/../services/ReviewsService.class.php';

Flight::route('POST /reviews', function () {
    $reviews = Flight::request()->data->getData();
    Flight::json(Flight::reviewsService()->add_review($reviews));
});

Flight::route('GET /reviews', function () {
    Flight::json(Flight::reviewsService()->get_all_reviews());
});

Flight::route('GET /user/reviews/@user_id', function ($user_id) {
    Flight::json(Flight::reviewsService()->get_user_reviews($user_id));
});

Flight::route('GET /shop/reviews/@shop_id', function ($shop_id) {
    Flight::json(Flight::reviewsService()->get_shop_reviews($shop_id));
});

Flight::route('DELETE /review/@id', function($id){
    Flight::json(Flight::reviewsService()->delete_review($id));
});
