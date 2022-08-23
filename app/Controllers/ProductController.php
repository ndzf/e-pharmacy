<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ProductModel;
use App\Entities\ProductEntity;
use App\Models\CategoryModel;
use App\Models\SupplierModel;
use Picqer\Barcode\BarcodeGeneratorPNG;
use Picqer\Barcode\BarcodeGeneratorSVG;

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
        $validation = service("validation");
        $products = $this->productModel->search($inputs["keyword"], $inputs["type"], $inputs["category"]);

        $data = [
            "title"         => $this->title,
            "inputs"        => $inputs,
            "products"      => $products->paginate(10, "products"),
            "pager"         => $products->pager->links("products", "default"),
            "validation"    => $validation->getErrors(),
        ];

        return view("products/index", $data);
    }

    public function create()
    {
        $validation = service("validation");

        $supplierModel = new SupplierModel();
        $categoryModel = new CategoryModel();

        $data = [
            "validation"            => $validation->getErrors(),
            "categories"            => $categoryModel->getNames(),
            "suppliers"             => $supplierModel->getNames()
        ];

        return view("products/create", $data);
    }

    public function store()
    {
        $inputs = esc($this->request->getPost());

        if (!$this->validate("createProduct")) {
            return redirect()->to("/products")->withInput()->with("validationErrorCreate", true);
        }

        $product = new ProductEntity();
        $product->fill($inputs);

        $this->productModel->save($product);
        return redirect()->to("/products")->with("successMessage", "Berhasil menambah data produk");
    }

    public function edit(int $id)
    {
        $product = $this->productModel->find($id);

        if (empty($product)) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound(lang("Message.error.notFound", [ucwords($this->title)]));
        }

        $validation = service("validation");

        $supplierModel = new SupplierModel();
        $categoryModel = new CategoryModel();

        $data = [
            "validation"            => $validation->getErrors(),
            "categories"            => $categoryModel->getNames(),
            "suppliers"             => $supplierModel->getNames(),
            "product"               => $product,
        ];

        return view("products/edit", $data);
    }

    public function update(int $id)
    {
        $product = $this->productModel->find($id);

        if (empty($product)) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound(lang("Message.error.notFound", [ucwords($this->title)]));
        }

        $inputs = esc($this->request->getPost());

        if (!$this->validate("updateProduct")) {
            return redirect()->to("/products")->withInput()->with("validationErrorUpdate", $id);
        }

        $product->fill($inputs);

        $this->productModel->save($product);
        return redirect()->to("/products")->with("successMessage", lang("Message.success.update", [strtolower($this->title)]));
    }

    public function delete(int $id)
    {
        $this->productModel->where("id", $id)->delete();
        return redirect()->to("/products")->with("successMessage", lang("Message.success.delete", [strtolower($this->title)]));
    }

    public function search()
    {
        $keyword = esc($this->request->getVar("keyword"));
        $inputs = [
            "keyword"           => esc($this->request->getVar("keyword")),
            "type"              => esc($this->request->getVar("type")),
            "category"          => esc($this->request->getVar("category")),
        ];
        $query = $this->productModel->search($inputs["keyword"], $inputs["type"], $inputs["category"]);
        $products = $query->get(3);
        return json_encode($products->getResultArray());
    }

    public function details($id)
    {
        $product = $this->productModel->find($id);

        if (empty($product)) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound(lang("Message.error.notFound", [ucwords($this->title)]));
        }

        return json_encode($product);
    }

    public function printBarcode()
    {
        $productsInputs = esc($this->request->getPost("products"));
        $products = $this->productModel->find($productsInputs);
        $generator = new BarcodeGeneratorPNG();
        foreach ($products as $product) {
            if (!is_null($product->code)) {
                $product->barcode = base64_encode($generator->getBarcode($product->code, $generator::TYPE_EAN_13));
            }
        }

        $data = [
            "products"          => $products
        ];

        return view("products/printBarcode", $data);
    }
}
