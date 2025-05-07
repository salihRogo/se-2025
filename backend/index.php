<?php

require __DIR__ . '/vendor/autoload.php';

require_once __DIR__ . '/rest/services/ShopsService.class.php';
require_once __DIR__ . '/rest/services/ReviewsService.class.php';

Flight::register('shopsService', 'ShopsService');
Flight::register('reviewsService', 'ReviewsService');

require_once __DIR__ . '/rest/routes/shops_routes.php';
require_once __DIR__ . '/rest/routes/reviews_routes.php';

Flight::start();