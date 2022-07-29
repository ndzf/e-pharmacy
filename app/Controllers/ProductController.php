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
        $inputs = [
            "keyword"           => esc($this->request->getVar("q")),
            "type"              => esc($this->request->getVar("type")),
            "category"          => esc($this->request->getVar("category")),
        ];

        $products = $this->productModel->search($inputs["keyword"], $inputs["type"], $inputs["category"]);

        $data = [
            "title"         => $this->title,
            "inputs"        => $inputs,
            "products"      => $products->paginate(10, "products"),
            "pager"         => $products->pager->links("products", "default"),
        ];

        return view("products/index", $data);
    }
}
