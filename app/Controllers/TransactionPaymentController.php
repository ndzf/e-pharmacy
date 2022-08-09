<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\TransactionPaymentModel;
use App\Entities\TransactionPaymentEntity;
use CodeIgniter\I18n\Time;

class TransactionPaymentController extends BaseController
{

    protected $transactionPaymentModel;

    public function __construct()
    {
        $this->TransactionPaymentModel = new TransactionPaymentModel();
    }

    public function index()
    {
        //
    }

    public function create()
    {
        $inputs = esc($this->request->getPost());

        $transactionModel = new \App\Models\TransactionModel;
        $transaction = $transactionModel->find($inputs["transactionID"]);

        if (empty($transaction)) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Transaksi tidak ditemukan");
        }

        $payments = $this->TransactionPaymentModel->getByTransaction($inputs["transactionID"]);
        $grandTotal = str_replace(".", "", $inputs["grandTotal"]);
        $inputNominal = str_replace(".", "", $inputs["nominal"]);
        $currentNominal = 0;
        if (!empty($payments)) {
            foreach($payments as $payment) {
                $currentNominal += $payment->nominal;
            }
        }

        // Create transaction payment
        $transactionPayment = new TransactionPaymentEntity();
        $transactionPayment->transaction_id = $inputs["transactionID"];
        $transactionPayment->user_id = session("userID");
        $transactionPayment->nominal = (($currentNominal + $inputNominal) > $grandTotal) ? $grandTotal - $currentNominal : $inputNominal; 
        $transactionPayment->date = Time::parse("now", "Asia/Jakarta")->toDateString();

        // Update transaction payment
        if (($currentNominal + $inputNominal) >= $grandTotal) {
            $transaction->payment_status = "cash";
            $transactionModel->save($transaction);
        }

        $this->TransactionPaymentModel->save($transactionPayment);
        return redirect()->back()->with("successMessage", "Berhasil menambah data transaksi");
    }
}
