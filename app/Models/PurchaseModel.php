<?php

namespace App\Models;

use CodeIgniter\Model;

class PurchaseModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'purchases';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = \App\Entities\PurchaseEntity::class;
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ["user_id", "status", "payment_status", "grand_total", "date"];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    public function getPurchases(): object
    {
        $builder = $this->table("purchases");
        $builder->select("purchases.id, purchases.grand_total, purchases.status, purchases.payment_status, purchases.user_id, purchases.date, users.name as user");
        $builder->join("users", "users.id = purchases.user_id", "LEFT");
        return $builder;
    }

    public function checkout($id, $inputs, $payment)
    {
        $this->db->transStart();

        // Update purchase
        $purchase = [
            "discount"              => $inputs["discount"],
            "grand_total"           => str_replace(".", "", $inputs["grandTotal"]),
            "payment_status"        => (intval(str_replace(".", "", $inputs["nominal"])) - intval(str_replace(".", "", $inputs["grandTotal"])) < 0) ? "debt" : "cash",
            "status"                => "done",
        ];

        $builder = $this->table("purchases");
        $builder->where("id", $id)->set($purchase)->update();

        // Update products.qty
        $purchaseDetailModel = new \App\Models\PurchaseDetailModel();
        $purchaseDetails = $purchaseDetailModel->getProductsByPurchaseID($id);
        $productModel = new \App\Models\ProductModel();

        foreach ($purchaseDetails as $purchaseDetail) {
            $product = $productModel->find($purchaseDetail->product_id);
            $qty = $product->qty + $purchaseDetail->qty;
            $productModel->set("qty", $qty)->where("id", $purchaseDetail->product_id)->update();
        }

        // Payment 

        $purchasePaymentModel = new \App\Models\PurchasePaymentModel();
        $purchasePaymentModel->save($payment);

        $this->db->transComplete();
    }
}
