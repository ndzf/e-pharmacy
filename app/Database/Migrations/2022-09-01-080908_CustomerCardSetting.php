<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CustomerCardSetting extends Migration
{
    public function up()
    {
        $this->forge->addField([
            "id"                    => ["type" => "int", "constraint" => 11, "auto_increment" => true],
            "background_image"      => ["type" => "varchar", "constraint" => 255, "null" => true],
            "text_color"            => ["type" => "varchar", "constraint" => 100],
            "primary_color"         => ["type" => "varchar", "constraint" => 100],
            "surface_color"         => ["type" => "varchar", "constraint" => 100],
            "status"                => ["type" => "enum", "constraint" => ["disable", "active"], "default" => "disable"]
        ]);
        $this->forge->addKey("id", true);
        $this->forge->createTable("customer_card_setting");
    }

    public function down()
    {
        $this->forge->dropTable("customer_card_setting");
    }
}
