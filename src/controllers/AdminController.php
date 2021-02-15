<?php


namespace App\Controllers;


use App\Models\Users;
use App\Utils\Common;
use App\Utils\FunctionClass;

class AdminController extends Common
{

    private array $params;

    public function __construct()
    {
        parent::__construct("Dashboard");
        $this->params = array('sidebar' => true);

    }

    public function showDashboard()
    {
        $users = new Users();
        $param = array("users" => $users->getCount($users->SCHEMA));
        $this->params = array_merge($this->params, $param);
        parent::getView('Admin/dashboard.twig', $this->params);
    }

    public function showUser()
    {
        $users = new Users();
        $param = array("users" => $users->getAll($users->SCHEMA));
        $this->params = array_merge($this->params, $param);
        parent::getView('Admin/users.twig', $this->params);
    }

    public function showItemsCategories()
    {
        $items_cat = new \App\Models\ItemsCategories();
        $param = array("categories" => $items_cat->getAll($items_cat->SCHEMA));
        $this->params = array_merge($this->params, $param);
        parent::getView('Admin/items_categories.twig', $this->params);
    }

    public function showItems()
    {
        $items = new \App\Models\Items();
        $cat = new \App\Models\ItemsCategories();
        $categories = $cat->getAll($cat->SCHEMA);
        $param = array("items" => ($items->getAll($items->SCHEMA)) ? $items->getAll($items->SCHEMA) : [], "categories" => $categories);
        $this->params = array_merge($this->params, $param);
        parent::getView('Admin/items.twig', $this->params);
    }

    public function updateUser(string $uuid, string $role)
    {
        $user = new Users();
        $user->SCHEMA->setId($uuid);
        $user->SCHEMA->setRoles($role);
        $user->SCHEMA->setUpdatedAt(date('d-m-Y'));
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