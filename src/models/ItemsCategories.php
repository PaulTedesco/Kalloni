<?php

namespace App\Models;

use App\Utils\DataBase;

class ItemsCategories extends DataBase
{
    public \App\Schema\ItemsCategory $SCHEMA;

    public function __construct()
    {
        parent::__construct();
        $this->SCHEMA = new \App\Schema\ItemsCategory();
    }

}
