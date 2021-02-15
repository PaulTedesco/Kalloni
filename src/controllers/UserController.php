<?php


namespace App\Controllers;


use App\Utils\Common;
use App\Utils\FunctionClass;
use Exception;
use App\Models;

class UserController extends common
{
    public function __construct()
    {
        parent::__construct("Utilisateur");
    }

    public function showLogin(string|null $error = null)
    {
        $param = ($error) ? array("error" => $error) : [];
        return parent::getView("Users/login.twig", $param);
    }

    public function showRegister(string|null $error = null, string|null $info = null)
    {
        $param = ($error) ? array("error" => $error) : (($info) ? array("info" => $info) : []);
        return parent::getView("Users/register.twig", $param);
    }

    /**
     * @param string|null $error
     * @param string|null $info
     * @return bool|string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function show(string $uuid, string|null $error = null, string|null $info = null)
    {
        $user = new Models\Users();
        $profil = $user->getOne($user->SCHEMA, "id", $uuid);
        return parent::getView("Users/profile.twig",
            ($error) ? array("error" => $error, "profile" => $profil) :
                (($info) ? array("info" => $info, "profile" => $profil) : ["profile" => $profil]));
    }

    /**
     * @param array $input
     * @return bool|string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function register(array $input)
    {
        $model = new Models\Users();

        if (!isset($input['first_name']) || empty($input['first_name'])) return self::showRegister("Error: First name is empty");
        if (!isset($input['last_name']) || empty($input['last_name'])) return self::showRegister("Error: Last name is empty");
        if (!isset($input['email']) || empty($input['email'])) return self::showRegister("Error: Email is empty");
        if (!isset($input['zip_code']) || empty($input['zip_code'])) return self::showRegister("Error: Zip Code is empty");
        if (!isset($input['country']) || empty($input['country'])) return self::showRegister("Error: Country is empty");
        if (!isset($input['city']) || empty($input['city'])) return self::showRegister("Error: City is empty");
        if (!isset($input['address']) || empty($input['address'])) return self::showRegister("Error: Address is empty");
        if ($model->checkEmail($input['email'])) return self::showRegister("Error: Email already used");
        if (!isset($input['password']) || empty($input['password'])) return self::showRegister("Error: Password is empty");
        if (!isset($input['password_confirmation']) || is_null($input['password_confirmation'])
            || $input['password_confirmation'] != $input['password']) return self::showRegister("Error: Repeat password is empty or not equal");

        $model->SCHEMA->setFirstName($input['first_name']);
        $model->SCHEMA->setLastName($input['last_name']);
        $model->SCHEMA->setZipCode($input['zip_code']);
        $model->SCHEMA->setCountry($input['country']);
        $model->SCHEMA->setCity($input['city']);
        $model->SCHEMA->setAddress($input['address']);
        $model->SCHEMA->setRoles("member");
        $model->SCHEMA->setPassword(password_hash($input['password'], PASSWORD_BCRYPT));
        $model->SCHEMA->setEmail($input['email']);
        $err = $model->create($model->SCHEMA);
        if (!$err) {
            return self::showRegister(info: "Success: User Created you can login now");
        } else {
            return self::showRegister("Error: " . gettype($err));
        }
    }

    public function login(array $input)
    {
        $model = new Models\Users();

        if (!isset($input['email']) || empty($input['email'])) {
            return self::showLogin("Error: Email is empty");
        }
        if (!isset($input['password']) || empty($input['password'])) {
            return self::showLogin("Error: Password is empty");
        }
        $err = $model->login($input['email'], $input['password']);
        if ($err instanceof Exception):
            return self::showLogin($err->getMessage());
        endif;
        $_SESSION['user'] = $err;
        FunctionClass::redirect("/profile/" . $err->getId());
    }
}
