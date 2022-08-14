<?php

namespace App\Models;

use CodeIgniter\I18n\Time;
use CodeIgniter\Model;

class PurchasePaymentModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'purchase_payments';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = \App\Entities\PurchasePaymentEntity::class;
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ["purchase_id", "user_id", "nominal", "date"];

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

    public function getByPurchaseID(int $purchaseID)
    {
        $builder = $this->table("purchase_payments");
        $builder->select("id, date, nominal");
        $builder->where("purchase_id", $purchaseID);
        $data = $builder->get();
        return $data->getCustomResultObject("\App\Entities\PurchasePaymentEntity");
    }

    public function todayNominal()
    {
        $date = Time::parse("now", "Asia/Jakarta")->toDateString();
        $builder = $this->table("builder");
        $builder->select("*");
        $builder->where("date", $date);
        $row = $builder->get();
        $data = $row->getResultArray();
        $nominal = 0;
        foreach ($data as $purchase) {
            $nominal += $purchase["nominal"];
        }
        return $nominal;
    }
}
