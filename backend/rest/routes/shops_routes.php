<?php

require_once __DIR__ . '/../services/ShopsService.class.php';

Flight::route('GET /shops', function() {
    Flight::json(Flight::shopsService() -> get_all_shops());
});

Flight::route('GET /nebitno', function() {
    echo "Ovo radi";
});

Flight::route('/', function() {
    echo "Ovo valjda radi";
});

Flight::start();