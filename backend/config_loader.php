<?php
// This file will load the appropriate config file based on environment

// Check if we're on Heroku or GitHub Actions
if (getenv('JAWSDB_URL') || getenv('CLEARDB_DATABASE_URL') || getenv('GITHUB_ACTIONS')) {
    require_once __DIR__ . '/config.heroku.php';
} else {
    // Local environment
    require_once __DIR__ . '/config.php';
}
