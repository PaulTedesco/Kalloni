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
    public function show($uuid)
    {
        $items = new \App\Models\Items();
        $item = $items->getOne($items->SCHEMA, 'title', $uuid);
        parent::getView('Items/index.twig', array("item" => $item));
        return;
    }
}