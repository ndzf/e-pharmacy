<?php

namespace App\Models;

use CodeIgniter\Model;

class StoreModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'store';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = \App\Entities\StoreEntity::class;
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ["name", "address", "phone_number", "email", "banner", "invoice_banner", "text_color", "instagram", "whatsapp_number"];

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

    public function getStore()
    {
        $builder = $this->table("store");
        $builder->select("*");
        $data = $builder->get(1);
        return $data->getCustomRowObject(1, "\App\Entities\StoreEntity");
    }
}
