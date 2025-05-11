<?php

require_once __DIR__ . "/../../config.php";

use Firebase\JWT\JWT;
use Firebase\JWT\Key;


Flight::route('/*', function(){
    $req_method = Flight::request()->method;
    $req_url = Flight::request()->url;
    if($req_method == 'POST' && $req_url == "/login"){
        return TRUE;
    }
    if($req_method == 'GET' && $req_url == "/login"){
        return TRUE;
    }
    if($req_method == 'GET' && $req_url == "/register"){
        return TRUE;
    }
    if($req_method == 'POST' && $req_url == "/users"){
        return TRUE;
    }
    if($req_method == 'GET' && $req_url == "/shops"){
        return TRUE;
    }
    if($req_method == 'GET' && $req_url == "/home/shops"){
        return TRUE;
    }
    if($req_method == 'GET' && preg_match('#^/shops/\d+$#', $req_url)){
        return TRUE;
    }
    try{
        $token = Flight::request()->getHeader('Authentication');
        if(!$token){
            Flight::halt(401, 'Token not provided');
        }
        $decoded_token = JWT::decode($token, new Key(Config::JWT_SECRET(), 'HS256'));

        Flight::set('user', $decoded_token->user->id);
        Flight::set('jwt_token', $token);
        return TRUE;
    } catch(Exception $e){
        Flight::halt(401, $e->getMessage());
    }
});