<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\StoreModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class StoreController extends BaseController
{
    protected $storeModel;

    public function __construct()
    {
        $this->storeModel = new StoreModel();
    }

    public function index()
    {
        $store = $this->storeModel->getStore();

        if (empty($store)) {
            throw PageNotFoundException::forPageNotFound("something error");
        }

        $data = [
            "title"     => "Toko",
            "store"     => $store,
        ];

        return view("store/index", $data);
    }

    public function update(int $id)
    {
        $inputs = esc($this->request->getPost());
        $store = $this->storeModel->getStore();

        if (empty($store)) {
            throw PageNotFoundException::forPageNotFound("something error");
        }

        $store->name = $inputs["name"];
        $store->phone_number = $inputs["phoneNumber"];
        $store->email = $inputs["email"];
        $store->address = $inputs["address"];

        try {
            $this->storeModel->save($store);
            return redirect()->to("/store")->with("successMessage", "Berhasil memperbaharui data toko");
        } catch (\Exception $e) {
            return redirect()->to("/store")->with("errorMessage", $e->getMessage());
        }
    }
}
