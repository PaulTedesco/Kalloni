<?php


namespace App\Controllers;


use App\Utils\Common;
use JetBrains\PhpStorm\Pure;

class HomeController extends Common
{

    /**
     * HomeController constructor.
     */
    #[Pure] public function __construct()
    {
        parent::__construct('Kalloni');

    }

    public function show()
    {
        parent::getView("Home/home.twig");
        return;
    }
}