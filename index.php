<?php

use Controllers\Controller;
use Controllers\Routes;

require_once __DIR__ . "/app/config.php";
include __DIR__ . "/vendor/autoload.php";


try {


    $route = $_GET['route'] ?? '';

    $frontController = new Controller($route, $_SERVER['REQUEST_METHOD'], new Routes());
    $frontController->run();
} catch (PDOException $e) {
    $title = 'An error has occurred';
    $output = 'Database error: ' . $e->getMessage() . ' in ' . $e->getFile() . ':' . $e->getLine();
}
