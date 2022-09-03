<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class CustomerSeeder extends Seeder
{
    public function run()
    {
        $str1 = rand();
        $str2 = rand();
        $str3 = rand();
        $customers = [
            [
                "name"          => "Mamat manja",
                "code"          => sha1($str1),
                "phone_number"  => "620123908",
                "email"         => "",
                "address"       => "Kendal City",
                "role"          => "customer",
            ],
            [
                "name"          => "Anthony Martial",
                "code"          => sha1($str2),
                "phone_number"  => "620123908",
                "email"         => "",
                "address"       => "Franc",
                "role"          => "customer",
            ],
            [
                "name"          => "Donny Van De Beek",
                "code"          => sha1($str3),
                "phone_number"  => "620123908",
                "email"         => "donny@gmail.com",
                "address"       => "Holland",
                "role"          => "reseller",
            ],
        ];

        $this->db->table("customers")->insertBatch($customers);
    }
}
