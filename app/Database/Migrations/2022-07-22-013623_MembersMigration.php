<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class MembersMigration extends Migration
{
    public function up()
    {
        $this->forge->addField([
            "id"                => ["type" => "int", "constraint" => 11, "auto_increment" => true],
            "name"              => ["type" => "varchar", "constraint" => 100],
            "phone_number"      => ["type" => "varchar", "constraint" => 15, "null" => true],
            "email"             => ["type" => "varchar", "constraint" => 100, "null" => true],
            "address"           => ["type" => "varchar", "constraint" => 255, "null" => true],
            "role"              => ["type" => "enum", "constraint" => ["customer", "member", "reseller"]],
            "created_at"        => ["type" => "timestamp"],
            "updated_at"        => ["type" => "timestamp", "null" => true],
        ]);

        $this->forge->addKey("id", true);
        $this->forge->createTable("customers");
    }

    public function down()
    {
        $this->forge->dropTable("customers", true);
    }
}
