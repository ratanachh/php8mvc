<?php

define('BASE_PATH', dirname(__DIR__));
define('APP_PATH', BASE_PATH . '/src');
require_once '../src/App/Autoload.php';

use QuickSoft\Application;

try {
    
    $app = new Application(BASE_PATH);
    echo $app->run();
} catch (ErrorException $exception) {
    echo $exception->getMessage();
}