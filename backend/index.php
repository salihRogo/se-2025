<?php

require __DIR__ . '/vendor/autoload.php';

require_once __DIR__ . '/rest/services/ShopsService.class.php';
require_once __DIR__ . '/rest/services/ReviewsService.class.php';
require_once __DIR__ . '/rest/services/ReservationsService.class.php';
require_once __DIR__ . '/rest/services/UsersService.class.php';
require_once __DIR__ . '/rest/services/AuthService.class.php';
require_once __DIR__ . '/rest/services/FavouritesService.class.php';
require_once __DIR__ . '/rest/services/CouponsService.class.php';


Flight::register('shopsService', 'ShopsService');
Flight::register('reviewsService', 'ReviewsService');
Flight::register('reservationsService', 'ReservationsService');
Flight::register('usersService', 'UsersService');
Flight::register('authService', 'AuthService');
Flight::register('favouritesService', 'FavouritesService');
Flight::register('couponService', 'CouponService');


require_once __DIR__ . '/rest/routes/middleware_routes.php';

require_once __DIR__ . '/rest/routes/admin_routes/shops_routes.php';
require_once __DIR__ . '/rest/routes/admin_routes/users_routes.php';
require_once __DIR__ . '/rest/routes/admin_routes/reviews_routes.php';
require_once __DIR__ . '/rest/routes/admin_routes/reservations_routes.php';

require_once __DIR__ . '/rest/routes/shops_routes.php';
require_once __DIR__ . '/rest/routes/reviews_routes.php';
require_once __DIR__ . '/rest/routes/reservations_routes.php';
require_once __DIR__ . '/rest/routes/users_routes.php';
require_once __DIR__ . '/rest/routes/auth_routes.php';
require_once __DIR__ . '/rest/routes/favourites_routes.php';
require_once __DIR__ . '/rest/routes/coupons_routes.php';


Flight::start();
