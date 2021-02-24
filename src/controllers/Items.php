<?php


namespace App\Controllers;


use App\Utils\FunctionClass;
use Spatie\Image\Image;

class Items
{
    public function createItems(array $form)
    {
        $imgs = $_FILES['picture']["tmp_name"];
        $paths = [];
        for ($y = 0; $y < count($imgs); $y++):
            $iLoad = Image::load($_FILES['picture']["tmp_name"][$y]);
            // resize image
            $iLoad->width(300);
            $iLoad->height(200);

            $path = 'public/assets/img/uploads/items/' . str_replace(" ", "_", $form["title"]) . '_' . date("d-m-y") . '_' . $y . '_' . '.jpg';
            // save image
            $iLoad->save($path);

            array_push($paths, '/img/uploads/items/' . str_replace(" ", "_", $form["title"]) . '_' . date("d-m-y") . '_' . $y . '_' . '.jpg');
        endfor;
        $items_modal = new \App\Models\Items();

        $items_modal->SCHEMA->setTitle($form["title"]);
        $items_modal->SCHEMA->setDescription($form["description"]);
        $items_modal->SCHEMA->setPicture(implode(",", $paths));
        $items_modal->SCHEMA->setPrice($form['price']);
        $items_modal->SCHEMA->setCategory($form['category']);
        $items_modal->SCHEMA->setCreatedAt(date("d-m-Y"));
        $items_modal->SCHEMA->setUpdatedAt(date("d-m-Y"));
        $items_modal->create($items_modal->SCHEMA);

        FunctionClass::goBack();

    }

    public function deleteItem(string $uuid)
    {
        $items_modal = new \App\Models\Items();

        $items_modal->SCHEMA->setId($uuid);
        $items_modal->delete($items_modal->SCHEMA);

        FunctionClass::goBack();

    }

    public function updateItem(string $uuid, string $title)
    {
        $items_modal = new \App\Models\Items();

        $items_modal->SCHEMA->setId($uuid);
        $items_modal->SCHEMA->setTitle($title);
        $items_modal->SCHEMA->setUpdatedAt(date('d-m-Y'));
        $items_modal->update($items_modal->SCHEMA);

        FunctionClass::goBack();

    }
}