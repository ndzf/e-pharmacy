<?php

namespace App\Models;

use CodeIgniter\Model;

class PurchaseDetailModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'purchase_details';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = \App\Entities\PurchaseDetailEntity::class;
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ["purchase_id", "product_id", "product_name", "price", "qty"];

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


    public function getProductsByPurchaseID(int $purchaseID)
    {
        $builder = $this->table("purchase_details");
        $builder->select("id, purchase_id, product_id, product_name, price, qty");
        $builder->where("purchase_id", $purchaseID);
        $data = $builder->get();
        return $data->getCustomResultObject("\App\Entities\PurchaseDetailEntity");
    }

    public function getProduct($id)
    {
        $builder = $this->table("purchase_details");
        $builder->select("purchase_details.id, purchase_details.price, purchase_details.qty, products.name as product, products.l_sph, products.l_cyl, products.l_add, products.r_sph, products.r_cyl, products.r_add, products.type");
        $builder->where("purchase_details.id", $id);
        $builder->join("products", "purchase_details.product_id = products.id", "LEFT");
        $data = $builder->get();
        return $data->getRowArray();
    }

}
