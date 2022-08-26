<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class StoreMigration extends Migration
{
    public function up()
    {
        $this->forge->addField([
            "id"                    => ["type" => "int", "constraint" => 11, "auto_increment" => true],
            "name"                  => ["type" => "varchar", "constraint" => 255],
            "address"               => ["type" => "text", "null" => true],
            "phone_number"          => ["type" => "varchar", "constraint" => 11, "null" => true],
            "email"                 => ["type" => "varchar", "constraint" => 100, "null" => true],
            "banner"                => ["type" => "text", "null" => true],
            "invoice_banner"        => ["type" => "text", "null" => true],
            "text_color"            => ["type" => "varchar", "constraint" => 20, "null" => true],
        ]);
        $this->forge->addKey("id", true);
        $this->forge->createTable("store");
    }

    public function down()
    {
        $this->forge->dropTable("store");
    }
}
