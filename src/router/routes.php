<?php


namespace App\Router;


use AltoRouter;
use App\Controllers\AdminController;
use App\Controllers\HomeController;
use App\Controllers\UserController;
use App\Utils\FunctionClass;

class Routes
{
    private AltoRouter $router;

    public function __construct()
    {
        $this->router = new AltoRouter();
    }

    private function getRoute()
    {

        $this->router->map('GET', '/', function () {
            echo "<script>window.location.href = '/home';</script>";
        });

        $HomeController = new HomeController();
        $UserController = new UserController();
        $AdminController = new AdminController();

        $this->router->map('GET', '/home', function () use ($HomeController) { return $HomeController->show(); });
        $this->router->map('GET', '/profile/[*:uuid]', function ($uuid) use ($UserController) { return $UserController->show($uuid); });

        if (!FunctionClass::isConnected()):
            $this->router->map('POST', '/register', function () use ($UserController) { return $UserController->register($_POST); });
            $this->router->map('GET', '/register', function () use ($UserController) { return $UserController->showRegister(); });
            $this->router->map('POST', '/login', function () use ($UserController) { return $UserController->login($_POST); });
            $this->router->map('GET', '/login', function () use ($UserController) { return $UserController->showLogin(); });
        endif;
        if (FunctionClass::isConnected()):
            $this->router->map('GET', '/logout', function () {
                session_destroy();
                FunctionClass::redirect("/login");

            });
        endif;
        if (FunctionClass::isAdmin()):
            $this->router->map('GET', '/admin', function () use ($AdminController) { return $AdminController->showDashboard(); });
            $this->router->map('GET', '/admin/users', function () use ($AdminController) { return $AdminController->showUser(); });
            $this->router->map('GET', '/admin/users/delete/[*:uuid]', function ($uuid) use ($AdminController) { return $AdminController->deleteUser($uuid); });
            $this->router->map('POST', '/admin/users/update/[*:uuid]', function ($uuid) use ($AdminController) { return $AdminController->updateUser($uuid, $_POST['role']); });
            $this->router->map('POST', '/register', function () use ($UserController) { return $UserController->register($_POST); });
            $this->router->map('GET', '/register', function () use ($UserController) { return $UserController->showRegister(); });
        endif;

    }

    public function Run()
    {
        self::getRoute();
        // match current request url
        $match = $this->router->match();

        // call closure or throw 404 status
        if (is_array($match) && is_callable($match['target'])) {
            call_user_func_array($match['target'], $match['params']);
        }
    }

}