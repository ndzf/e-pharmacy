<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\TransactionDetailModel;
use App\Models\TransactionModel;

class ReportController extends BaseController
{
    public function omzet()
    {
        $transactionDetailModel = new TransactionDetailModel();
        $transactionModel =  new TransactionModel();
        $inputs = [
            "start"         => esc($this->request->getVar("start")),
            "end"           => esc($this->request->getVar("end")),
            "date"          => $this->request->getVar("daterange"),
        ];

        $transactions = $transactionModel->between($inputs["start"], $inputs["end"]);
        $products = [];
        foreach ($transactions as $transaction) {
            $transactionDetails = $transactionDetailModel->getProductsByTransaction($transaction->id);
            $product = ["payment_status" => $transaction->payment_status, "date" => $transaction->date];
            foreach ($transactionDetails as $transactionDetail) {
                $product += $transactionDetailModel->getProduct($transactionDetail->id);
                array_push($products, $product);
            }
        }

        $data = [
            "inputs"            => $inputs,
            "products"          => $products
        ];

        return view("reports/omzet", $data);
    }
}
