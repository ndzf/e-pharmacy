<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class CustomerSeeder extends Seeder
{
    public function run()
    {
        $customers = [
            [
                "name"          => "Mamat manja",
                "phone_number"  => "620123908",
                "email"         => "",
                "address"       => "Kendal City",
                "role"          => "customer",
            ],
            [
                "name"          => "Anthony Martial",
                "phone_number"  => "620123908",
                "email"         => "",
                "address"       => "Franc",
                "role"          => "customer",
            ],
            [
                "name"          => "Donny Van De Beek",
                "phone_number"  => "620123908",
                "email"         => "donny@gmail.com",
                "address"       => "Holland",
                "role"          => "reseller",
            ],
        ];

        $this->db->table("customers")->insertBatch($customers);
    }
}
