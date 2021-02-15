<?php

namespace App\Models;

use App\Utils\DataBase;
use ErrorException;
use PDO;

class Users extends DataBase
{
    public \App\Schema\Users $SCHEMA;

    public function __construct()
    {
        parent::__construct();
        $this->SCHEMA = new \App\Schema\Users();
    }

    public function checkEmail(string $email)
    {
        $checkEmail = $this->DB->prepare("SELECT * FROM `users` WHERE email = ?");
        $checkEmail->execute(array($email));
        return count($checkEmail->fetchAll()) > 0;
    }

    public function login(string $email, string $password)
    {
        $login = $this->DB->prepare("SELECT * FROM `users` WHERE email = ?");
        $login->execute(array($email));
        $users = $login->fetchObject(get_class($this->SCHEMA));
        if (is_null($users) || empty($users)) return new ErrorException("Invalid Users: email");
        if (!password_verify($password, $users->getPassword())) return new ErrorException("Invalid Users: password");
        return $users;
    }
}
