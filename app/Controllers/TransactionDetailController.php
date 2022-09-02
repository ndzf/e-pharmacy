<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\TransactionDetailModel;
use App\Entities\TransactionDetailEntity;

class TransactionDetailController extends BaseController
{
    protected $transactionDetailModel;

    public function __construct()
    {
        $this->transactionDetailModel = new TransactionDetailModel();
    }

    public function index()
    {
        //
    }

    public function create()
    {
        $productModel = new \App\Models\ProductModel();
        $inputs = esc($this->request->getPost());
        $product = $productModel->find($inputs["productID"]);

        $totalQty = $this->currentQty($inputs["productID"]) + $inputs["qty"];

        if (($product->qty - $totalQty) < 0) {
            return redirect()->to("/transactions/create")->with("errorMessage", "Stok produk tidak mencukupi");
        }

        $transactionDetail = new TransactionDetailEntity();
        $transactionDetail->transaction_id = session("transactionID");
        $transactionDetail->product_id = $inputs["productID"];
        $transactionDetail->product_name = $inputs["productName"];
        $transactionDetail->product_price = $inputs["productPrice"];
        $transactionDetail->qty = $inputs["qty"];
        if ($product->lens_type == "progressive") {
            $transactionDetail->r_axis = $inputs["rAxis"];
            $transactionDetail->l_axis = $inputs["lAxis"];
        }
        if ($product->lens_type == "regular") {
            $transactionDetail->axis = $inputs["axis"];
        }

        $this->transactionDetailModel->save($transactionDetail);
        return redirect()->to("/transactions/create")->with("successMessage", "Berhasil menambah item");
    }

    public function currentQty($productID)
    {
        $transactionDetailModel = new \App\Models\TransactionDetailModel();
        $transactionID = session("transactionID");
        $productBuckets =  $transactionDetailModel->getProducts($transactionID, $productID);

        $currentQty = 0;
        if (!empty($productBuckets)) {
            foreach ($productBuckets as $productBucket) {
                $currentQty += $productBucket["qty"];
            }
        }

        return $currentQty;
    }

    public function delete(int $id)
    {
        $this->transactionDetailModel->where("id", $id)->delete();
        return redirect()->to("transactions/create")->with("successMessage", lang("Message.success.delete", ["transaksi"]));
    }

    public function show(int $id)
    {
        $transactionDetail = $this->transactionDetailModel->getProduct($id);
        if (empty($transactionDetail)) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound(lang("Message.error.notFound", [ucfirst("transaksi")]));
        }

        return json_encode($transactionDetail);
    }
}
