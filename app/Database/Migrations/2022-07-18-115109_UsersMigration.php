<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class UsersMigration extends Migration
{
    public function up()
    {
        $this->forge->addField([
            "id"                => ["type" => "int", "constraint" => 11, "auto_increment" => true],
            "username"          => ["type" => "varchar", "constraint" => 100],
            "password"          => ["type" => "varchar", "constraint" => 255],
            "name"              => ["type" => "varchar", "constraint" => 100],
            "phone_number"      => ["type" => "varchar", "constraint" => 15, "null" => true],
            "role"              => ["type" => "enum", "constraint" => ["cashier", "admin"]],
            "status"            => ["type" => "enum", "constraint" => ["active", "suspend"]],
            "created_at"        => ["type" => "timestamp"],
            "updated_at"        => ["type" => "timestamp", "null" => true],
        ]);
        $this->forge->addKey("id", true);
        $this->forge->createTable("users");
    }

    public function down()
    {
        $this->forge->dropTable("users", true);
    }
}
