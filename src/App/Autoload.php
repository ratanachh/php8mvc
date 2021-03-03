<?php

$vendor_autoload = realpath('./../vendor/autoload.php');

if (!file_exists($vendor_autoload)) {
    throw new ErrorException("missing autoload file.");
}

require_once $vendor_autoload;

/**
 * Load .env configurations
 */
Dotenv\Dotenv::create(BASE_PATH)->load();