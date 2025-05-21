<?php

require_once __DIR__ . "/../../config.php";
require_once __DIR__ . '/../services/AuthService.class.php';

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

Flight::route('/*', function () {
    $req_method = Flight::request()->method;
    $req_url = Flight::request()->url;
    if ($req_method == 'POST' && $req_url == "/coupons/user") {
        return TRUE;
    }
    if ($req_method == 'GET' && preg_match('#^/coupons/\d+$#', $req_url)) {
        return TRUE;
    }
    if ($req_method == 'POST' && $req_url == "/login") {
        return TRUE;
    }
    if ($req_method == 'GET' && $req_url == "/login") {
        return TRUE;
    }
    if ($req_method == 'GET' && $req_url == "/register") {
        return TRUE;
    }
    if ($req_method == 'POST' && $req_url == "/users") {
        return TRUE;
    }
    if ($req_method == 'GET' && $req_url == "/shops") {
        return TRUE;
    }
    if ($req_method == 'GET' && $req_url == "/home/shops") {
        return TRUE;
    }
    if ($req_method == 'POST' && $req_url == "/favourite") {
        return TRUE;
    }
    if ($req_method == 'DELETE' && preg_match('#^/favourite/\d+$#', $req_url)) {
        return TRUE;
    }
    if ($req_method == 'GET' && preg_match('#^/favourites/\d+$#', $req_url)) {
        return TRUE;
    }
    if ($req_method == 'GET' && preg_match('#^/shops/\d+$#', $req_url)) {
        return TRUE;
    }
    if ($req_method == 'GET' && preg_match('#^/shop/reviews/\d+$#', $req_url)) {
        return TRUE;
    }
    if (preg_match('#^/admin/#', $req_url)) {
        $user = Flight::authService()->get_current_user();
        if (!$user || $user['role'] !== 'admin') {
            Flight::halt(403, "Access denied");
        }
    }
    try {
        $token = Flight::request()->getHeader('Authentication');
        if (!$token) {
            Flight::halt(401, 'Token not provided');
        }
        $decoded_token = JWT::decode($token, new Key(Config::JWT_SECRET(), 'HS256'));

        Flight::set('user', $decoded_token->user->id);
        Flight::set('jwt_token', $token);
        return TRUE;
    } catch (Exception $e) {
        Flight::halt(401, $e->getMessage());
    }
});
