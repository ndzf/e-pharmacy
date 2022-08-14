<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\PurchasePaymentModel;
use App\Entities\PurchasePaymentEntity;
use CodeIgniter\I18n\Time;

class PurchasePaymentController extends BaseController
{

    protected $purchasePaymentModel;

    public function __construct()
    {
        $this->purchasePaymentModel = new PurchasePaymentModel();
    }

    public function index()
    {
        //
    }

    public function create()
    {
        $inputs = esc($this->request->getPost());

        $purchaseModel = new \App\Models\PurchaseModel();
        $purchase = $purchaseModel->find($inputs["purchaseID"]);

        if (empty($purchase)) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Data Pembelian tidak ditemukan");
        }

        $payments = $this->purchasePaymentModel->getByPurchaseID($inputs["purchaseID"]);
        $grandTotal = str_replace(".", "", $inputs["grandTotal"]);
        $inputNominal = str_replace(".", "", $inputs["nominal"]);
        $currentNominal = 0;
        if (!empty($payments)) {
            foreach ($payments as $payment) {
                $currentNominal += $payment->nominal;
            }
        }

        $purchasePayment = new PurchasePaymentEntity();
        $purchasePayment->purchase_id = $inputs["purchaseID"];
        $purchasePayment->user_id = session("userID");
        $purchasePayment->nominal = (($currentNominal + $inputNominal) > $grandTotal) ? $grandTotal - $currentNominal : $inputNominal;
        $this->purchasePaymentModel->save($purchasePayment);

        if (($currentNominal + $inputNominal) >= $grandTotal) {
            $purchase->payment_status = "cash";
            $purchaseModel->save($purchase);
        }

        return redirect()->to("/purchases")->with("successMessage", "Berhasil menambah data pembayaraan");
    }
}
