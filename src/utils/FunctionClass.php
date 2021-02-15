<?php


namespace App\Utils;


class FunctionClass
{
    public static function isConnected()
    {
        return (isset($_SESSION['user']));
    }

    public static function isAdmin()
    {
        if (!self::isConnected()) return false;
        return ($_SESSION['user']->getRoles() == "admin");
    }

    /**
     * @param string $url
     */
    public static function redirect(string $url)
    {
        echo "<script>window.location.href = '" . $url . "'</script>";
        return;
    }

    public static function goBack()
    {
        echo "<script>window.history.back()</script>";
        return;
    }

    public static function getCurrentRole()
    {
        return $_SESSION['user']->getRoles();
    }
}