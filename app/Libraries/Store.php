<?php

namespace App\Libraries;

use App\Models\StoreModel;

class Store
{
    protected $storeModel;

    public function __construct()
    {
        $this->storeModel = new StoreModel();
    }

    public function getName()
    {
        $store = $this->storeModel->getStore();
        return $store->name;
    }
}
