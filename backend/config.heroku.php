<?php

ini_set('display_errors', 0); // Disable error display in production
ini_set('display_startup_errors', 0);
error_reporting(E_ALL ^ (E_NOTICE | E_DEPRECATED));

class Config
{
    public static function DB_NAME()
    {
        $url = getenv('JAWSDB_URL') ?: getenv('CLEARDB_DATABASE_URL');
        
        if ($url) {
            $url = parse_url($url);
            return substr($url['path'], 1); // Remove leading slash
        }
        
        return 'pastry-franchise';
    }

    public static function DB_PORT()
    {
        $url = getenv('JAWSDB_URL') ?: getenv('CLEARDB_DATABASE_URL');
        
        if ($url) {
            $url = parse_url($url);
            return isset($url['port']) ? $url['port'] : 3306;
        }
        
        return 3306;
    }

    public static function DB_USER()
    {
        $url = getenv('JAWSDB_URL') ?: getenv('CLEARDB_DATABASE_URL');
        
        if ($url) {
            $url = parse_url($url);
            return $url['user'];
        }
        
        return 'root';
    }

    public static function DB_PASSWORD()
    {
        $url = getenv('JAWSDB_URL') ?: getenv('CLEARDB_DATABASE_URL');
        
        if ($url) {
            $url = parse_url($url);
            return $url['pass'];
        }
        
        return 'rootroot';
    }
    
    public static function DB_HOST()
    {
        $url = getenv('JAWSDB_URL') ?: getenv('CLEARDB_DATABASE_URL');
        
        if ($url) {
            $url = parse_url($url);
            return $url['host'];
        }
        
        return '127.0.0.1';
    }

    public static function JWT_SECRET()
    {
        return getenv('JWT_SECRET') ?: ',dpPL,Se%fM-UVQBwf/X0T&B!DF6%}';
    }
}
