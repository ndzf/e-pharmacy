<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class LensDetailsMigration extends Migration
{
    public function up()
    {
        $this->forge->addField([
            "id"                => ["type" => "int", "constraint" => 11, "auto_increment" => true],
            "product_id"        => ["type" => "int", "constraint" => 11],
            "lens_type"         => ["type" => "enum", "constraint" => ["R", "L"]],
            "sph"               => ["type" => "varchar", "constraint" => 15, "null" => true],
            "cyl"               => ["type" => "varchar", "constraint" => 15, "null" => true],
            "add"               => ["type" => "varchar", "constraint" => 15, "null" => true],
            "created_at"        => ["type" => "timestamp"],
            "updated_at"        => ["type" => "timestamp", "null" => true]
        ]);
        $this->forge->addKey("id", true);
        $this->forge->createTable("lens_details");
    }

    public function down()
    {
        $this->forge->dropTable("lens_details");
    }
}
