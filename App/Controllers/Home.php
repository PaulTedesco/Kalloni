<?php


namespace App\Controllers;


use App\Utils\Common;
use JetBrains\PhpStorm\Pure;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

/**
 * Class Home
 * @package App\Controllers
 */
class Home extends Common
{
    /**
     * Home constructor.
     */
    #[Pure] public function __construct()
    {
        parent::__construct();
    }

    /**
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function show()
    {
        parent::getView("home.twig");
        return;
    }
}