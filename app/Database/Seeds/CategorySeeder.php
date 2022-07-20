<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run()
    {
        $categories = [
            [
                "name"      => "Drugs",
            ],
            [
                "name"      => "Alkes",
            ],
            [
                "name"      => "Kacamata"
            ]
        ];

        $this->db->table("categories")->insertBatch($categories);
    }
}
