<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class StoreSeeder extends Seeder
{
    public function run()
    {
        $store = [
            "name"          => "Apotek Sehat",
            "address"       => "Sukorejo Kendal",
            "phone_number"  => "0821212423",
            "email"         => "sehat@apotek.com"
        ];

        $this->db->table("store")->insert($store);
    }
}
