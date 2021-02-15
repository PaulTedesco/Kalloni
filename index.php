<?php


require "vendor/autoload.php";

use App\Controllers\Home;

session_start();

$router = new AltoRouter();
$router->map('GET', '/', function () {
    echo "<script>window.location.href = '/home';</script>";
});

$HomeController = new Home();

$router->map('GET', '/home', $HomeController->show(), "Home");

$router->map('GET', '/deconnexion', function () {
    session_destroy();
    echo "<script>window.location.href = '/'</script>";

});


// match current request url
$match = $router->match();

// call closure or throw 404 status
if (is_array($match) && is_callable($match['target'])) {
    call_user_func_array($match['target'], $match['params']);
}