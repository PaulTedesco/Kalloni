<?php


namespace App\Controllers;


use App\Utils\FunctionClass;
use Spatie\Image\Image;

class Items
{
    public function createItems(array $form)
    {
        $img = Image::load($_FILES['picture']['tmp_name']);

        // resize image
        $img->width(300);
        $img->height(200);

        $path = 'public/assets/img/uploads/items/' . $form["title"] . '_' . date("d-m-y") . '.jpg';
        // save image
        $img->save($path);

        $path = '/img/uploads/items/' . $form["title"] . '_' . date("d-m-y") . '.jpg';
        $items_modal = new \App\Models\Items();

        $items_modal->SCHEMA->setTitle($form["title"]);
        $items_modal->SCHEMA->setDescription($form["description"]);
        $items_modal->SCHEMA->setPicture($path);
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