<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ProductModel;
use App\Entities\ProductEntity;

class ProductController extends BaseController
{

    protected $title;
    protected $productModel;

    public function __construct()
    {
        $this->title = lang("Product.title.index");
        $this->productModel = new ProductModel();
    }

    public function index()
    {

    }
}
