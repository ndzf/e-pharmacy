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
                "name"                  => "Metformin HCI",
                "type"                  => "general",
                "qty"                   => 12,
                "minimum_qty"           => 50,
                "original_price"        => 10000,
                "selling_price"         => 10000,
                "member_price"          => 10000,
                "wholesale_price"       => 10000,
            ],
            [
                "supplier_id"           => 1,
                "category_id"           => 2,
                "code"                  => "800puadSf",
                "name"                  => "Lens A",
                "type"                  => "lens",
                "qty"                   => 4,
                "minimum_qty"           => 8,
                "original_price"        => 12000,
                "selling_price"         => 12000,
                "member_price"          => 12000,
                "wholesale_price"       => 12000,
            ],
            [
                "supplier_id"           => 2,
                "category_id"           => 2,
                "code"                  => "sunflower",
                "name"                  => "Paracetamol",
                "type"                  => "general",
                "qty"                   => 8,
                "minimum_qty"           => 4,
                "original_price"        => 17000,
                "selling_price"         => 17000,
                "member_price"          => 17000,
                "wholesale_price"       => 17000,
            ],
        ];

        $this->db->table("products")->insertBatch($products);
    }
}
