<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\SupplierModel;
use App\Entities\SupplierEntity;

class SupplierController extends BaseController
{
    protected SupplierModel $supplierModel;

    public function __construct()
    {
        $this->supplierModel = new SupplierModel();
    }

    public function index()
    {
        $keyword = esc($this->request->getVar("q"));
        $validation = service("validation");
        $suppliers = $this->supplierModel->search($keyword);

        $data = [
            "title"             => lang("Supplier.title.index"),
            "keyword"           => $keyword,
            "validation"        => $validation->getErrors(),
            "suppliers"         => $suppliers->paginate(10, "suppliers"),
            "pager"             => $suppliers->pager->links("suppliers", "default"),
        ];

        return view("suppliers/index", $data);
    }

    public function create()
    {
        $inputs = esc($this->request->getPost());

        if (!$this->validate("createSupplier")) {
            return redirect()->to("/suppliers")->withInput()->with("validationErrorCreate", true);
        }

        $supplier = new SupplierEntity();
        $supplier->name = $inputs["name"];
        $supplier->phone_number = $inputs["phoneNumber"];
        $supplier->email = $inputs["email"];
        $supplier->address = $inputs["address"];

        $this->supplierModel->save($supplier);

        $title = strtolower(lang("Supplier.title.index"));
        return redirect()->to("/suppliers")->with("successMessage", lang("Message.success.create", [$title]));
    }

    public function edit($id)
    {
        $supplier = $this->supplierModel->find($id);

        if (empty($supplier)) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound(lang("Message.error.notFound", [lang("Supplier.title.index")]));
        }

        return json_encode($supplier);
    }

    public function update($id)
    {
        $supplier = $this->supplierModel->find($id);

        if (empty($supplier)) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound(lang("Message.error.notFound", [lang("Supplier.title.index")]));
        }

        $inputs = esc($this->request->getPost());

        if (!$this->validate("updateSupplier")) {
            return redirect()->to("/suppliers")->withInput()->with("validationErrorUpdate", $id);
        }

        $supplier->name = $inputs["name"];
        $supplier->phone_number = $inputs["phoneNumber"];
        $supplier->email = $inputs["email"];
        $supplier->address = $inputs["address"];

        $this->supplierModel->save($supplier);

        return redirect()->to("/suppliers")->with("successMessage", lang("Message.success.update", [strtolower(lang("Supplier.title.index"))]));
    }

    public function delete(int $id)
    {
        $this->supplierModel->where("id", $id)->delete();
        return redirect()->to("/suppliers")->with("successMessage", lang("Message.success.delete", [strtolower(lang("Supplier.title.index"))]));
    }
}
