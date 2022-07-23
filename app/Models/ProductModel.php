<?php

namespace App\Models;

use CodeIgniter\Model;

class ProductModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'products';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = \App\Entities\ProductEntity::class;
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ["supplier_id", "category_id", "code", "name", "qty", "minimum_qty", "lens_type", "original_price", "selling_price", "member_price", "wholesale_price"];

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
        $builder = $this->table("products");
        $builder->select("products.id, categories.name as category, products.code, products.name, products.qty, products.minimum_qty, products.original_price, products.selling_price");
        $builder->join("categories", "categories.id = products.supplier_id", "LEFT");
        if ($keyword) {
            $builder->like("products.name", $keyword);
            $builder->orLike("products.code", $keyword);
            $builder->orLike("categories.name", $keyword);
        }
        $builder->orderBy("products.created_at", "DESC");
        return $builder;
    }
}
