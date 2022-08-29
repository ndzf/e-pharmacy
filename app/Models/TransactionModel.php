<?php

namespace App\Models;

use CodeIgniter\Model;

class TransactionModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'transactions';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = \App\Entities\TransactionEntity::class;
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ["user_id", "customer_id", "status", "payment_status", "grand_total", "discount", "date", "faced", "pick_up_date", "pd", "recipe", "note"];

    // Dates
    protected $useTimestamps = false;
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

    public function getTransactions(): object
    {
        $builder = $this->table("transactions");
        $builder->select("transactions.id, transactions.date, transactions.status, transactions.payment_status, transactions.grand_total, users.name as user, customers.name as customer");
        $builder->join("users", "users.id = transactions.user_id", "LEFT");
        $builder->join("customers", "customers.id = transactions.customer_id", "LEFT");
        $builder->orderBy("transactions.created_at", "DESC");
        return $builder;
    }

    public function getTransaction(int $id)
    {
        $builder = $this->table("transactions");
        $builder->select("transactions.id, transactions.date, transactions.discount, transactions.status, transactions.payment_status, transactions.grand_total, users.name as user, customers.name as customer");
        $builder->join("users", "users.id = transactions.user_id", "LEFT");
        $builder->join("customers", "customers.id = transactions.customer_id", "LEFT");
        $builder->where("transactions.id", $id);
        $data = $builder->get();
        return $data->getCustomRowObject(1, "\App\Entities\TransactionEntity");
    }

    public function checkout($id, $inputs, $payment)
    {
        $this->db->transStart();
        // Updating transaction
        $transaction = [
            "discount"              => $inputs["discount"],
            "grand_total"           => str_replace(".", "", $inputs["grandTotal"]),
            "payment_status"        => (intval(str_replace(".", "", $inputs["nominal"])) - intval(str_replace(".", "", $inputs["grandTotal"])) < 0) ? "debt" : "cash",
            "status"                => "done",
            "faced"                 => $inputs["faced"],
            "pick_up_date"          => $inputs["pick_up_date"],
            "pd"                    => $inputs["pd"],
            "recipe"                => $inputs["recipe"],
            "note"                  => $inputs["note"],
        ];

        $builder = $this->table("transactions");
        $builder->set($transaction);
        $builder->where("id", $id);
        $builder->update();

        // update products.qty 
        $transactionDetailModel = new \App\Models\TransactionDetailModel();
        $transactionDetails = $transactionDetailModel->getByTransactionID($id);
        $productModel = new \App\Models\ProductModel();

        $products = [];
        foreach ($transactionDetails as $transactionDetail) {
            $product = $productModel->find($transactionDetail->product_id);
            $update = [
                "id"            => $transactionDetail->product_id,
                "qty"           => ($product->qty - $transactionDetail->qty),
            ];
            $productModel->set($update)->where("id", $transactionDetail->product_id)->update();
        }

        // Saving payment 
        $paymentModel = new \App\Models\TransactionPaymentModel();
        $paymentModel->save($payment);

        $this->db->transComplete();
    }

    public function between(?string $start, ?string $end)
    {
        $builder = $this->table("transactions");
        $builder->select("id, date, status, payment_status");
        $builder->where("status", "done");
        if ($start && $end) {
            $builder->where("date between '$start' and '$end'");
        }
        $data = $builder->get();
        return $data->getCustomResultObject("\App\Entities\TransactionEntity");
    }
}
