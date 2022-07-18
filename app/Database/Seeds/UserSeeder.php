<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        $users = [
            [
                "username"              => "user@cashier",
                "password"              => password_hash("cashier", PASSWORD_BCRYPT),
                "name"                  => "Cashier 1",
                "role"                  => "cashier",
                "phone_number"          => "823234098",
                "status"                => "active",
            ],
            [
                "username"              => "user@admin",
                "password"              => password_hash("admin", PASSWORD_BCRYPT),
                "name"                  => "Admin 1",
                "role"                  => "admin",
                "phone_number"          => "823234098",
                "status"                => "active",
            ],
        ];

        $this->db->table("users")->insertBatch($users);
    }
}
