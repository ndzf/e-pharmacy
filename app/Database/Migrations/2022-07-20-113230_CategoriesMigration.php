<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CategoriesMigration extends Migration
{
    public function up()
    {
        $this->forge->addField([
            "id"                => ["type" => "int", "constraint" => 11, "auto_increment" => true],
            "name"              => ["type" => "varchar", "constraint" => 255],
            "created_at"        => ["type" => "timestamp"],
            "updated_at"        => ["type" => "timestamp", "null" => true],
        ]);
        $this->forge->addKey("id", true);
        $this->forge->createTable("categories");
    }

    public function down()
    {
        $this->forge->dropTable("categories", true);
    }
}
