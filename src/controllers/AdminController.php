<?php


namespace App\Controllers;


use App\Models\Users;
use App\Utils\Common;
use App\Utils\FunctionClass;

class AdminController extends Common
{

    public function __construct()
    {
        parent::__construct("Dashboard");
    }

    public function showDashboard()
    {
        $users = new Users();
        $params = array('sidebar' => true, "userCount" => $users->getCount($users->SCHEMA));
        parent::getView('Admin/dashboard.twig', $params);
    }

    public function showUser()
    {
        $users = new Users();

        $params = array('sidebar' => true, "users" => $users->getAll($users->SCHEMA));
        parent::getView('Admin/users.twig', $params);
    }

    public function updateUser(string $uuid, string $role)
    {
        $user = new Users();
        $user->SCHEMA->setId($uuid);
        $user->SCHEMA->setRoles($role);
        $user->update($user->SCHEMA);
        FunctionClass::goBack();
    }

    public function deleteUser($uuid)
    {
        $user = new Users();
        $user->SCHEMA->setId($uuid);
        $user->delete($user->SCHEMA);
        FunctionClass::goBack();
    }

}