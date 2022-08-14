<?php

namespace App\Controllers;

use App\Models\PurchaseModel;
use App\Models\PurchasePaymentModel;
use App\Models\TransactionPaymentModel;

class Home extends BaseController
{
    public function index()
    {
        $purchasePaymentModel = new PurchasePaymentModel();
        $transactionPaymentModel = new TransactionPaymentModel();

        $data = [
            "purchaseNominal"       => $purchasePaymentModel->todayNominal(),
            "transactionNominal"    => $transactionPaymentModel->todayNominal(),
        ];

        return view("welcome_message", $data);
    }
}
