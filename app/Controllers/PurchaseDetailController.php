<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\PurchaseDetailModel;

class PurchaseDetailController extends BaseController
{
    protected $purchaseDetailModel;

    public function __construct()
    {
        $this->purchaseDetailModel = new PurchaseDetailModel();
    }

    public function index()
    {
        //
    }

    public function create()
    {
        $purchaseID = session("purchaseID");
        $inputs = esc($this->request->getPost());
        
        $purchase = [
            "purchase_id"           => $purchaseID,
            "product_id"            => $inputs["productID"],
            "product_name"          => $inputs["productName"],
            "qty"                   => $inputs["qty"],
            "price"                 => $inputs["price"],
        ];

        $this->purchaseDetailModel->insert($purchase);
        return redirect()->to("/purchases/create")->with("successMessage", "Berhasil menambah produk");
    }

    public function show(int $id)
    {
        $purchase = $this->purchaseDetailModel->getProduct($id);
        if (empty($purchase)) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Produk tidak ditemukan");
        }

        return json_encode($purchase);
    }

    public function delete($id)
    {
        $this->purchaseDetailModel->where("id", $id)->delete();
        return redirect()->to("/purchases/create")->with("successMessage", "Berhasil menghapus produk");
    }
}
