<?php

namespace App\Models;

use App\Utils\DataBase;

class Items extends DataBase
{
    public \App\Schema\Items $SCHEMA;

    public function __construct()
    {
        parent::__construct();
        $this->SCHEMA = new \App\Schema\Items();
    }

}
