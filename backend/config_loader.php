<?php
// This file will load the appropriate config file based on environment

// Check if we're on Heroku
if (getenv('JAWSDB_URL') || getenv('CLEARDB_DATABASE_URL')) {
    require_once __DIR__ . '/config.heroku.php';
} else {
    // Local environment
    require_once __DIR__ . '/config.php';
}
