<?php

namespace App\Libraries;
use App\Models\CategoryModel;

class Category
{
    protected $categoryModel;

    public function __construct()
    {
        $this->categoryModel = new CategoryModel();
    }

    public function getNames(?string $active)
    {
        $data = [
            "active"    => $active,
            "data"      => $this->categoryModel->getNames()
        ];

        return view("_partials/forms/options", $data);
    }
}