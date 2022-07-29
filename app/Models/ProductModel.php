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
    protected $allowedFields    = ["supplier_id", "category_id", "code", "name", "type", "qty", "minimum_qty", "original_price", "selling_price", "member_price", "wholesale_price"];

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

    public function search(?string $keyword, ?string $type, ?string $category)
    {
        $builder = $this->table("products");
        $builder->select("products.id, products.name, products.qty, products.type, products.minimum_qty, products.selling_price, products.original_price, categories.name as category");
        $builder->join("categories", "categories.id = products.category_id", "LEFT");
        if ($keyword) {
            $builder->like("products.name", $keyword);

            if ($type) {
                $builder->having("products.type", $type);
                $builder->groupBy("products.type");
            }

            if ($category) {
                $builder->having("products.category_id", $category);
                $builder->groupBy("products.category_id");
            }
        }

        if ($type) {
            $builder->where("products.type", $type);
        }

        if ($category) {
            $builder->where("products.category_id", $category);
        }

        return $builder;
    }

    public function create($inputs)
    {
        $productBuilder = $this->table("products");

        $product = [
            "supplier_id"           => $inputs["supplier"],
            "category_id"           => $inputs["category"],
            "code"                  => $inputs["code"],
            "name"                  => $inputs["name"],
            "type"                  => $inputs["type"],
            "qty"                   => $inputs["qty"],
            "minimum_qty"           => $inputs["minimumQty"],
            "original_price"        => $inputs["originalPrice"],
            "selling_price"         => $inputs["sellingPrice"],
            "member_price"          => $inputs["memberPrice"],
            "wholesale_price"       => $inputs["wholesalePrice"],
        ];

        $productBuilder->insert($product);
        $productID = $productBuilder->insertID();

        if ($inputs["type"] == "lens") {
            $lensDetailModel = new \App\Models\LensDetailModel();
            $lensDetails = [
                [
                    "product_id"            => $productID,
                    "lens_type"             => "R",
                    "sph"                   => $inputs["createRSph"],
                    "cyl"                   => $inputs["createRCyl"],
                    "add"                   => $inputs["createRAdd"],
                ],
                [
                    "product_id"            => $productID,
                    "lens_type"             => "L",
                    "sph"                   => $inputs["createLSph"],
                    "cyl"                   => $inputs["createLCyl"],
                    "add"                   => $inputs["createLAdd"],
                ],
            ];

            $lensDetailModel->insertBatch($lensDetails);
        }
    }
}
