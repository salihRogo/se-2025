<?php

require_once __DIR__ . '/../services/CouponsService.class.php';

Flight::route('POST /coupons/user', function () {
    $data = Flight::request()->data->getData();
    $coupons = Flight::couponService()->add_coupon($data);
    Flight::json($coupons);
}); 

Flight::route('GET /coupons/@user_id', function($user_id){
    $coupons = Flight::couponService()->get_user_coupons($user_id);
    Flight::json($coupons);
});
