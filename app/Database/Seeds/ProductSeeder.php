<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run()
    {
        $products = [
            [
                "supplier_id"               => 1,
                "category_id"               => 1,
                "code"                      => "MT-HCI-500",
                "name"                      => "Metformin HCI 500g",
                "qty"                       => 10,
                "minimum_qty"               => 100,
                "lens_type"                 => "",
                "original_price"            => 100000,
                "selling_price"             => 120000,
                "member_price"              => 110000,
                "wholesale_price"           => 109000,
            ],
            [
                "supplier_id"               => 1,
                "category_id"               => 2,
                "code"                      => "pc-20",
                "name"                      => "Paracetamol 20g",
                "qty"                       => 100,
                "minimum_qty"               => 100,
                "lens_type"                 => "",
                "original_price"            => 2000,
                "selling_price"             => 5000,
                "member_price"              => 3000,
                "wholesale_price"           => 3000,
            ],
            [
                "supplier_id"               => 1,
                "category_id"               => 1,
                "code"                      => "ibuprofen-200",
                "name"                      => "Ibuprofen 200g",
                "qty"                       => 15,
                "minimum_qty"               => 10,
                "lens_type"                 => "",
                "original_price"            => 5000,
                "selling_price"             => 10000,
                "member_price"              => 8000,
                "wholesale_price"           => 7000,
            ],
            [
                "supplier_id"               => 3,
                "category_id"               => 1,
                "code"                      => "bio",
                "name"                      => "Vitamine C 500g",
                "qty"                       => 2,
                "minimum_qty"               => 1,
                "lens_type"                 => "R",
                "original_price"            => 3000,
                "selling_price"             => 5000,
                "member_price"              => 4000,
                "wholesale_price"           => 3000,
            ],
        ];

        $this->db->table("products")->insertBatch($products);
    }
}
