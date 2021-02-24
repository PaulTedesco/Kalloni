<?php


namespace App\Controllers;


use App\Utils\Common;

class Shop extends Common
{

    /**
     * Shop constructor.
     */
    public function __construct()
    {
        parent::__construct("Items");
    }

    /**
     * @param $uuid
     */
    public function show($category, $uuid)
    {
        $items = new \App\Models\Items();
        $item = $items->fetchOne($items->SCHEMA, 'title', str_replace("_", " ", $uuid));
        parent::getView('Items/index.twig', array("item" => $item));
        return;
    }
}