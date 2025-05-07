<?php

require_once __DIR__ . '/../services/ShopsService.class.php';

Flight::route('GET /shops', function () {
    Flight::json(Flight::shopsService()->get_all_shops());
});

Flight::route('GET /shops/@id', function ($id) {
    Flight::json(Flight::shopsService()->get_shop_by_id($id));
});

Flight::route('POST /shop', function(){
    $shops = Flight::request()->data->getData();
    Flight::json(Flight::shopsService()->add_shop($shops));
});

Flight::route('DELETE /shop/@id', function($id){
    Flight::json(Flight::shopsService()->delete_shop($id));
});

Flight::route('PUT /shop/@id', function($id) {
    $shops = Flight::request()->data->getData();
    Flight::json(Flight::shopsService()->update_shop($id, $shops));
});