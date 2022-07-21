<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class SupplierSeeder extends Seeder
{
    public function run()
    {
        $suppliers = [
            [
                "name"                  => "Indofood",
                "address"               => "Tangrang",
                "phone_number"          => "6280809",
                "email"                 => "cs@indofood.com"
            ],
            [
                "name"                  => "Kalbe",
                "address"               => "Tangsel",
                "phone_number"          => "6123098908",
                "email"                 => "cs@kalbe.com"
            ],
            [
                "name"                  => "Kimia Farma",
                "address"               => "Jakarat",
                "phone_number"          => "7102830189",
                "email"                 => "cs@kimiafarma.com"
            ],
            [
                "name"                  => "Bio Farma",
                "address"               => "Jakarat Selatan",
                "phone_number"          => "89018230",
                "email"                 => "cs@biofarma.com"
            ],
        ];

        $this->db->table("suppliers")->insertBatch($suppliers);
    }
}
