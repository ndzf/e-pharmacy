<?php

namespace App\Database\Seeds;

use App\Controllers\CustomerController;
use App\Models\CustomerModel;
use CodeIgniter\Database\Seeder;

class CustomerSeeder extends Seeder
{
    public function run()
    {
        $customerController = new CustomerController();
        $customerModel = new CustomerModel();

        $lastId = $customerModel->getLastId();
        $customer = [
            "name"          => "Mamat manja",
            "code"          => $lastId . "-" . $customerController->getCode(10),
            "phone_number"  => "620123908",
            "email"         => "",
            "address"       => "Kendal City",
            "role"          => "customer",
        ];

        $this->db->table("customers")->insert($customer);
    }
}
