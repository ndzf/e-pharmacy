<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ProductsMigration extends Migration
{
    public function up()
    {
        $this->forge->addField([
            "id"                        => ["type" => "int", "constraint" => 11, "auto_increment" => true],
            "supplier_id"               => ["type" => "int", "constraint" => 11, "null" => true],
            "category_id"               => ["type" => "int", "constraint" => 11, "null" => true],
            "code"                      => ["type" => "varchar", "constraint" => 100, "null" => true],
            "name"                      => ["type" => "varchar", "constraint" => 255],
            "qty"                       => ["type" => "int", "constraint" => 11, "default" => 0, "null" => true],
            "minimum_qty"               => ["type" => "int", "constraint" => 11, "default" => 0, "null" => true],
            "lens_type"                 => ["type" => "varchar", "constraint" => 100, "null" => true],
            "original_price"            => ["type" => "int", "constraint" => 11],
            "selling_price"             => ["type" => "int", "constraint" => 11],
            "member_price"              => ["type" => "int", "constraint" => 11, "null" => true],
            "wholesale_price"           => ["type" => "int", "constraint" => 11, "null" => true],
            "created_at"                => ["type" => "timestamp"],
            "updated_at"                => ["type" => "timestamp", "null" => true],
        ]);

        $this->forge->addKey("id", true);
        $this->forge->createTable("products");
    }

    public function down()
    {
        $this->forge->dropTable("products", true);
    }
}
