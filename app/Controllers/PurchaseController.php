<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\PurchaseModel;
use \CodeIgniter\I18n\Time;
use App\Models\PurchaseDetailModel;

class PurchaseController extends BaseController
{
    protected $purchaseModel;

    public function __construct()
    {
        $this->purchaseModel = new PurchaseModel;
    }

    public function index()
    {
        $purchases = $this->purchaseModel->getPurchases();

        $data = [
            "purchases"         => $purchases->paginate(100, "purchases"),
            "pager"             => $purchases->pager->links("purchases", "default"),
        ];

        return view("purchases/index", $data);
    }

    public function create()
    {
        $purchaseDetailModel = new PurchaseDetailModel();
        $purchaseID = session("purchaseID");
        $purchase = $this->purchaseModel->find($purchaseID);

        if (empty($purchase)) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Data Penjualan Tidak Ditemukan");
        }

        $data = [
            "purchaseDetails"   => $purchaseDetailModel->getProductsByPurchaseID($purchaseID),
            "purchase"          => $purchase,
        ];

        return view("purchases/create", $data);

    }

    public function store()
    {

        // Check session 
        if (session("createPurchase") || session("purchaseID")) {
            return redirect()->to("/purchases/create");
        }

        $purchase = new \App\Entities\PurchaseEntity();
        $purchase->user_id = session("userID");
        $purchase->status = "open";
        $purchase->date = Time::parse("now", "Asia/Jakarta")->toDateString();

        // Saving new purchase 
        $this->purchaseModel->insert($purchase);
        $purchaseID = $this->purchaseModel->getInsertID();
        // Set Sessions
        session()->set("createPurchase", true);
        session()->set("purchaseID", $purchaseID);
        
        return redirect()->to("/purchases/create");
    }

    public function clear()
    {
        session()->remove("createPurchase");
        session()->remove("purchaseID");
    }

    public function checkout($id)
    {
        $purchase = $this->purchaseModel->find($id);
        $inputs = esc($this->request->getPost());
        $nominal = str_replace(".", "", $inputs["nominal"]);
        $grandTotal = str_replace(".", "", $inputs["grandTotal"]);
        $payment = [
            "purchase_id"       => $id,
            "nominal"           => ($nominal >= $grandTotal) ? $grandTotal : $nominal,
            "user_id"           => session("userID"),
            "date"              => Time::now("Asia/Jakarta")->toDateString(),
        ];

        $this->purchaseModel->checkout($id, $inputs, $payment);

        session()->remove("createPurchase");
        session()->remove("purchaseID");

		return redirect()->to('/purchases')->with("successMessage", "Berhasil membuat transaksi pembelian");
    }
}
