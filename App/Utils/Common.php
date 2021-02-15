<?php


namespace App\Utils;


use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;
use Twig\Extension\DebugExtension;
use Twig\Loader\FilesystemLoader;

abstract class Common
{
    const ASSETS        = "App/Assets";
    const TEMPLATE_PATH = "App/Views";


    /**
     * common constructor.
     * @param $pageTitle
     */
    function __construct(private string $pageTitle = "Kalloni") { }

    /**
     * @param string $templatePath
     * @param array|null $params
     * @return void
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    function getView(string $templatePath, array|null $params = null): void
    {
        $loader = new FilesystemLoader($this::TEMPLATE_PATH);
        $twig = new Environment($loader, ['debug' => true]);

        (is_null($params)) ? $params = ["title" => $this->pageTitle] : $params["title"] = $this->pageTitle;
        $params["assets"] = self::ASSETS;
        if (isset($_SESSION['user'])) $params["user"] = $_SESSION["user"];
        if (isset($_SESSION['user'])) $params["hashMD5"] = md5(strtolower(trim($_SESSION['user']->getEmail())));
        $twig->addExtension(new DebugExtension());
        $page = $twig->load($templatePath);
        $page->display($params);
        return;
    }

}