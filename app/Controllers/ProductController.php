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
        $inputs = esc($this->request->getPost());

        if (!$this->validate("createProduct")) {
            return redirect()->to("/products")->withInput()->with("validationErrorCreate", true);
        }

        $product = new ProductEntity();
        $product->name = $inputs["name"];
        $product->supplier_id = $inputs["supplier"];
        $product->category_id = $inputs["category"];
        $product->code = $inputs["code"];
        $product->type = $inputs["type"];
        $product->r_sph = $inputs["rSph"];
        $product->r_cyl = $inputs["rCyl"];
        $product->r_add = $inputs["rAdd"];
        $product->l_sph = $inputs["lSph"];
        $product->l_cyl = $inputs["lCyl"];
        $product->l_add = $inputs["lAdd"];
        $product->qty = $inputs["qty"];
        $product->minimum_qty = $inputs["minimumQty"];
        $product->original_price = $inputs["originalPrice"];
        $product->selling_price = $inputs["sellingPrice"];
        $product->member_price = $inputs["memberPrice"];
        $product->wholesale_price = $inputs["wholesalePrice"];

        $this->productModel->save($product);
        return redirect()->to("/products")->with("successMessage", lang("Message.success.create", [strtolower($this->title)]));

    }

    public function edit(int $id)
    {
        $product = $this->productModel->find($id);

        if (empty($product)) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound(lang("Message.error.notFound", [ucwords($this->title)]));
        }

        return json_encode($product);
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

	$product->name = $inputs["name"];
	$product->supplier_id = $inputs["supplier"];
	$product->category_id = $inputs["category"];
	$product->code = $inputs["code"];
	$product->type = $inputs["type"];
	$product->r_sph = $inputs["rSph"];
	$product->r_cyl = $inputs["rCyl"];
	$product->r_add = $inputs["rAdd"];
	$product->l_sph = $inputs["lSph"];
	$product->l_cyl = $inputs["lCyl"];
	$product->l_add = $inputs["lAdd"];
	$product->qty = $inputs["qty"];
	$product->minimum_qty = $inputs["minimumQty"];
	$product->original_price = $inputs["originalPrice"];
	$product->selling_price = $inputs["sellingPrice"];
	$product->member_price = $inputs["memberPrice"];
	$product->wholesale_price = $inputs["wholesalePrice"];

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
}
