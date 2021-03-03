<?php

define('BASE_PATH', dirname(__DIR__));
define('DS', DIRECTORY_SEPARATOR);

require_once '../src/App/Autoload.php';

use QuickSoft\Application;

try {
    
    $app = new Application(BASE_PATH);
    echo $app->run();
} catch (ErrorException $exception) {
    echo $exception->getMessage();
}