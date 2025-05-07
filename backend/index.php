<?php

require __DIR__ . '/vendor/autoload.php';

require_once __DIR__ . '/rest/services/ShopsService.class.php';
require_once __DIR__ . '/rest/services/ReviewsService.class.php';
require_once __DIR__ . '/rest/services/ReservationsService.class.php';

Flight::register('shopsService', 'ShopsService');
Flight::register('reviewsService', 'ReviewsService');
Flight::register('reservationsService', 'ReservationsService');

require_once __DIR__ . '/rest/routes/shops_routes.php';
require_once __DIR__ . '/rest/routes/reviews_routes.php';
require_once __DIR__ . '/rest/routes/reservations_routes.php';

Flight::start();