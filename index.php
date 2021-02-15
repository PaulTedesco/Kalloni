<?php


require "vendor/autoload.php";

use App\Router\Routes;

session_start();

$router = new Routes();

$router->Run();
