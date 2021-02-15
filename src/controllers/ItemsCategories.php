<?php


namespace App\Controllers;


use App\Utils\FunctionClass;

class ItemsCategories
{
    public function createCategories(string $name)
    {
        $items_categories_modal = new \App\Models\ItemsCategories();

        $items_categories_modal->SCHEMA->setTitle($name);
        $items_categories_modal->create($items_categories_modal->SCHEMA);

        FunctionClass::goBack();

    }

    public function deleteCategory(string $uuid)
    {
        $items_categories_modal = new \App\Models\ItemsCategories();

        $items_categories_modal->SCHEMA->setId($uuid);
        $items_categories_modal->delete($items_categories_modal->SCHEMA);

        FunctionClass::goBack();

    }

    public function updateCategory(string $uuid, string $title)
    {
        $items_categories_modal = new \App\Models\ItemsCategories();

        $items_categories_modal->SCHEMA->setId($uuid);
        $items_categories_modal->SCHEMA->setTitle($title);
        $items_categories_modal->update($items_categories_modal->SCHEMA);

        FunctionClass::goBack();

    }
}