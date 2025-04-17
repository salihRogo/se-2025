<?php

require 'vendor/autoload.php';

require_once __DIR__ . '/rest/services/ShopsService.class.php';

Flight::register('shopsService', 'ShopsService');

// require 'rest/routes/middleware_routes.php';
require __DIR__ . '/rest/routes/shops_routes.php';

Flight::start();