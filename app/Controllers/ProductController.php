<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ProductModel;
use App\Entities\ProductEntities;

class ProductController extends BaseController
{
    protected ProductModel $productModel;
    protected String $title;

    public function __construct()
    {
        $this->productModel = new ProductModel();
        $this->title = lang("Product.title.index");
    }

    public function index()
    {
        //
    }
}
