<?php


namespace App\Utils;


use Exception;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;
use Twig\Extension\DebugExtension;
use Twig\Extra\String\StringExtension;
use Twig\Loader\FilesystemLoader;
use Twig\TwigFilter;

abstract class Common
{
    const VIEWS         = "/public/views/";
    const ASSETS        = "/public/assets";
    const TEMPLATE_PATH = "src/views";
    private string $error;
    private string $notif;


    /**
     * common constructor.
     * @param $pageTitle
     */
    function __construct(private string $pageTitle = "Kalloni")
    {
    }

    /**
     * @return string
     */
    function getError(): string
    {
        return $this->error;
    }

    /**
     * @param string $error
     */
    function setError(string $error): void
    {
        $this->error = $error;
    }

    /**
     * @return string
     */
    function getNotif(): string
    {
        return $this->notif;
    }

    /**
     * @param string $notif
     */
    function setNotif(string $notif): void
    {
        $this->notif = $notif;
    }

    /**
     * @return string
     */
    function getPageTitle(): string
    {
        return $this->pageTitle;
    }


    public function makeHash(string $string)
    {
        $hashed = md5($string);
        return $hashed;
    }

    /**
     * @param string $templatePath
     * @param array|null $params
     * @return false|string
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    function getView(string $templatePath, array $params = NULL)
    {
        $loader = new FilesystemLoader($this::TEMPLATE_PATH);
        $twig = new Environment($loader, ['debug' => true]);

        (is_null($params)) ? $params = ["title" => $this->getPageTitle()] : $params["title"] = $this->getPageTitle();
        $params["assets"] = self::ASSETS;
        if (FunctionClass::isConnected()) $params["user"] = $_SESSION["user"];
        if (FunctionClass::isConnected()) $params["hashMD5"] = md5(strtolower(trim($_SESSION['user']->getEmail())));
        $params['isAdmin'] = FunctionClass::isAdmin();
        if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on')
            $url = "https://";
        else
            $url = "http://";
        $url .= $_SERVER['HTTP_HOST'];
        $url .= $_SERVER['REQUEST_URI'];
        $params["path"] = explode("/", parse_url($url, PHP_URL_PATH));
        $twig->addExtension(new DebugExtension());
        $filter = new \Twig\TwigFilter('md5', function (string $string) {
            return md5($string);
        });
        $twig->addExtension(new StringExtension());
        $twig->addFilter($filter);
        $page = $twig->load($templatePath);
        return $page->display($params);
    }

}