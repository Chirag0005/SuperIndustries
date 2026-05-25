<?php

use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// Register the Composer autoloader
require __DIR__ . '/../vendor/autoload.php';

// Bootstrap Laravel
/** @var Application $app */
$app = require_once __DIR__ . '/../bootstrap/app.php';

// Handle dynamic SQLite setup on Vercel cold starts
if (env('DB_CONNECTION') === 'sqlite' && env('DB_DATABASE') === '/tmp/database.sqlite') {
    if (!file_exists('/tmp/database.sqlite')) {
        $sourceDatabase = __DIR__ . '/../database/database.sqlite';
        if (file_exists($sourceDatabase)) {
            copy($sourceDatabase, '/tmp/database.sqlite');
        } else {
            touch('/tmp/database.sqlite');
        }
    }
}

// Handle the request
$app->handleRequest(Request::capture());
