<?php

require_once __DIR__ . '/../services/FavouritesService.class.php';

Flight::route('POST /favourite', function () {
    $favourites = Flight::request()->data->getData();
    $result = Flight::favouritesService()->add_favourites($favourites);
});

Flight::route('GET /favourites/@user_id', function ($user_id) {
    Flight::json(Flight::favouritesService()->get_user_favourites($user_id));
});

Flight::route('DELETE /favourite/@id', function ($id) {
    Flight::favouritesService()->delete_favourite($id);
    Flight::json(["message" => "Favourite removed successfully"]);
});
