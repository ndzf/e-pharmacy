<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\PurchaseModel;
use \CodeIgniter\I18n\Time;

class PurchaseController extends BaseController
{
    protected $purchaseModel;

    public function __construct()
    {
        $this->purchaseModel = new PurchaseModel;
    }

    public function index()
    {
        $data = [
            "title"         => "Data Pembelian",
        ];

        return view("purchases/index", $data);
    }

    public function create()
    {

    }

    public function store()
    {
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
}
