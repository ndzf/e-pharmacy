<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class SuppliersMigration extends Migration
{
    public function up()
    {
        $this->forge->addField([
            "id"                    => ["type" => "int", "constraint" => 11, "auto_increment" => true],
            "name"                  => ["type" => "varchar", "constraint" => 100],
            "address"               => ["type" => "varchar", "constraint" => 255, "null" => true],
            "phone_number"          => ["type" => "varchar", "constraint" => 15, "null" => true],
            "email"                 => ["type" => "varchar", "constraint" => 100, "null" => true],
            "created_at"            => ["type" => "timestamp"],
            "updated_at"            => ["type" => "timestamp", "null" => true],
        ]);
        $this->forge->addKey("id", true);
        $this->forge->createTable("suppliers");
    }

    public function down()
    {
        $this->forge->dropTable("suppliers", true);
    }
}
