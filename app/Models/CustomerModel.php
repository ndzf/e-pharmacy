<?php

namespace App\Models;

use CodeIgniter\Model;

class CustomerModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'customers';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = \App\Entities\CustomerEntity::class;
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ["name", "code", "phone_number", "email", "address", "role"];

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

    public function search(?string $keyword)
    {
        $builder = $this->table("customers");
        $builder->select("id, name, phone_number, email, role");
        if ($keyword) {
            $builder->like("name", $keyword);
            $builder->orLike("phone_number", $keyword);
            $builder->orLike("email", $keyword);
            $builder->orLike("role", $keyword);
        }
        return $builder;
    }

    public function getNames(?string ...$roles)
    {
        $builder = $this->table("customers");
        $builder->select("id, name, role, phone_number");
        if (!empty($roles)) {
            $builder->whereIn("role", $roles);
        }
        $data = $builder->get();
        return $data->getCustomResultObject("\App\Entities\CustomerEntity");
    }

    public function getLastId()
    {
        $builder = $this->table("customers");
        $builder->select("id");
        $builder->orderBy("id", "DESC");
        $row = $builder->get();
        $data = $row->getRowArray();
        return (isset($data["id"])) ? $data["id"] + 1 : 1;
    }
}
