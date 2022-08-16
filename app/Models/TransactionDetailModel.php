<?php

namespace App\Models;

use CodeIgniter\Model;

class TransactionDetailModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'transaction_details';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = \App\Entities\TransactionDetailEntity::class;
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ["transaction_id", "product_id", "product_name", "product_price", "qty", "r_axis", "l_axis"];

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


    public function getByTransactionID(int $transactionID)
    {
        $builder = $this->table("transaction_details");
        $builder->select("id, product_id, transaction_id, product_name, product_price, qty");
        $builder->where("transaction_id", $transactionID);
        $data = $builder->get();
        return $data->getCustomResultObject("\App\Entities\TransactionDetailEntity");
    }


    public function getProducts($transactionID, $productID)
    {
        $builder = $this->table("products");
        $builder->select("id, product_id, qty");
        $builder->where("transaction_id", $transactionID);
        $builder->where("product_id", $productID);
        $data = $builder->get();
        return $data->getResultArray();
    }

    public function getProduct(int $id)
    {
        $builder = $this->table("transaction_details");
        $builder->select("transaction_details.id, transaction_details.r_axis, transaction_details.l_axis, transaction_details.product_price, transaction_details.qty, products.name as product, products.l_sph, products.l_cyl, products.l_add, products.r_sph, products.r_cyl, products.r_add, products.type");
        $builder->where("transaction_details.id", $id);
        $builder->join("products", "transaction_details.product_id = products.id", "LEFT");
        $data = $builder->get();
        return $data->getRowArray();
    }

    public function getProductsByTransaction($transactionID)
    {
        $builder = $this->table("transaction_details");
        $builder->select("transaction_details.id, transaction_details.transaction_id, transaction_details.product_id, transaction_details.product_name, transaction_details.product_price, transaction_details.qty, r_axis, l_axis, products.type, products.r_sph, products.r_cyl, products.r_add, products.l_sph, products.l_cyl, products.l_add, products.type");
        $builder->join("products", "products.id = transaction_details.product_id", "LEFT");
        $builder->where("transaction_details.transaction_id", $transactionID);
        $builder->orderBy("transaction_details.created_at", "DESC");
        $data = $builder->get();
        return $data->getCustomResultObject("\App\Entities\TransactionDetailEntity");
    }
}
