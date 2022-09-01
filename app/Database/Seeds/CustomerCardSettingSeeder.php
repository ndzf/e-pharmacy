<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class CustomerCardSettingSeeder extends Seeder
{
    public function run()
    {
        $data = [
            "background_image"              => "default.jpg",
            "text_color"                    => "#000000",
            "primary_color"                 => "#2b5398",
            "surface_color"                 => "#9ebcee",
            "status"                        => "active",
        ];

        $this->db->table("customer_card_setting")->insert($data);
    }
}
