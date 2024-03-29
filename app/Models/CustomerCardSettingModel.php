<?php

namespace App\Models;

use CodeIgniter\Model;

class CustomerCardSettingModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'customer_card_setting';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = \App\Entities\CustomerCardSettingEntity::class;
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ["background_image", "text_color", "primary_color", "surface_color", "status"];

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

    public function getByStatus(string $status): ?object
    {
        $builder = $this->table("customer_card_setting");
        $builder->select("*");
        $builder->where("status", $status);
        $data = $builder->get();
        return $data->getCustomRowObject(1, "\App\Entities\CustomerCardSettingEntity");
    }
}
