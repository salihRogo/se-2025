<?php

require __DIR__ . '/vendor/autoload.php';

require_once __DIR__ . '/data/roles.class.php';
require_once __DIR__ . '/rest/services/ShopsService.class.php';
require_once __DIR__ . '/rest/services/ReviewsService.class.php';
require_once __DIR__ . '/rest/services/ReservationsService.class.php';
require_once __DIR__ . '/rest/services/UsersService.class.php';
require_once __DIR__ . '/rest/services/AuthService.class.php';
require_once __DIR__ . '/rest/services/FavouritesService.class.php';
require_once __DIR__ . '/rest/services/CouponsService.class.php';
require_once __DIR__ . '/middleware/AuthMiddleware.class.php';

Flight::register('auth_middleware', "AuthMiddleware");
Flight::register('auth_service', 'AuthService');
Flight::register('shopsService', 'ShopsService');
Flight::register('reviewsService', 'ReviewsService');
Flight::register('reservationsService', 'ReservationsService');
Flight::register('usersService', 'UsersService');
Flight::register('favouritesService', 'FavouritesService');
Flight::register('couponService', 'CouponService');

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

Flight::route('/*', function () {
    $req_method = Flight::request()->method;
    $req_url = Flight::request()->url;

    if ($req_method == 'POST' && $req_url == "/login") {
        return TRUE;
    }
    if ($req_method == 'POST' && $req_url == "/register") {
        return TRUE;
    }
    if ($req_method == 'GET' && $req_url == "/shops") {
        return TRUE;
    }
    if ($req_method == 'GET' && $req_url == "/home/shops") {
        return TRUE;
    }
    if (preg_match('#^/admin/#', $req_url)) {
        $user = Flight::authService()->get_current_user();
        if (!$user || $user['role'] !== Roles::ADMIN) {
            Flight::halt(403, "Access denied");
        }
    }
    try {
        $token = Flight::request()->getHeader("Authentication");
        if (Flight::auth_middleware()->verifyToken($token)) {
            return TRUE;
        }
    } catch (\Exception $e) {
        Flight::halt(401, $e->getMessage());
    }
});

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
