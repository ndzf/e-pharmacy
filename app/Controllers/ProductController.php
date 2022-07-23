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
        $keyword = esc($this->request->getVar("q"));
        $validation = service("validation");
        $products = $this->productModel->search($keyword);
        $categoryModel = new \App\Models\CategoryModel();
        $supplierModel = new \App\Models\SupplierModel();

        $data = [
            "title"             => $this->title,
            "keyword"           => $keyword,
            "validation"        => $validation,
            "products"          => $products->paginate(10, "products"),
            "pager"             => $products->pager->links("products", "default"),
            "suppliers"         => $supplierModel->getNames(),
            "categories"        => $categoryModel->getNames(),
        ];

        return view("products/index", $data);
    }
}
