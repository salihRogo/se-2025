<?php

require __DIR__ . '/vendor/autoload.php';

require_once __DIR__ . '/rest/services/ShopsService.class.php';
require_once __DIR__ . '/rest/services/ReviewsService.class.php';
require_once __DIR__ . '/rest/services/ReservationsService.class.php';
require_once __DIR__ . '/rest/services/UsersService.class.php';

Flight::register('shopsService', 'ShopsService');
Flight::register('reviewsService', 'ReviewsService');
Flight::register('reservationsService', 'ReservationsService');
Flight::register('usersService', 'UsersService');

require_once __DIR__ . '/rest/routes/shops_routes.php';
require_once __DIR__ . '/rest/routes/reviews_routes.php';
require_once __DIR__ . '/rest/routes/reservations_routes.php';
require_once __DIR__ . '/rest/routes/users_routes.php';

Flight::start();