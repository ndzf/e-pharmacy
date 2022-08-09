<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run()
    {
        $products = [
            [
                "supplier_id"           => 1,
                "category_id"           => 1,
                "code"                  => "45pxadSf",
                "name"                  => "Frame A",
                "type"                  => "general",
                "qty"                   => 10,
                "minimum_qty"           => 50,
                "original_price"        => 10000,
                "selling_price"         => 10000,
                "member_price"          => 10000,
                "wholesale_price"       => 10000,
                "r_sph"                 => null,
                "r_cyl"                 => null,
                "r_add"                 => null,
                "l_sph"                 => null,
                "l_cyl"                 => null,
                "l_add"                 => null,
            ],
            [
                "supplier_id"           => 1,
                "category_id"           => 2,
                "code"                  => "800puadSf",
                "name"                  => "Lens A",
                "type"                  => "lens",
                "qty"                   => 10,
                "minimum_qty"           => 8,
                "original_price"        => 12000,
                "selling_price"         => 12000,
                "member_price"          => 12000,
                "wholesale_price"       => 12000,
                "r_sph"                 => "0.5",
                "r_cyl"                 => "0.5",
                "r_add"                 => "0.5",
                "l_sph"                 => "0.8",
                "l_cyl"                 => "0.8",
                "l_add"                 => "0.8",
            ],
        ];

        $this->db->table("products")->insertBatch($products);
    }
}
