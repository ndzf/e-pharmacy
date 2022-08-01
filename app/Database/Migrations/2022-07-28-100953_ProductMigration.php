<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ProductMigration extends Migration
{
    public function up()
    {
        $this->forge->addField([
            "id"                => ["type" => "int", "constraint" => 11, "auto_increment" => true],
            "supplier_id"       => ["type" => "int", "constraint" => 11, "null" => true],
            "category_id"       => ["type" => "int", "constraint" => 11, "null" => true],
            "code"              => ["type" => "varchar", "constraint" => 15, "null" => true],
            "name"              => ["type" => "varchar", "constraint" => 255],
            "type"              => ["type" => "enum", "constraint" => ["general", "lens"], "default" => "general"],
            "qty"               => ["type" => "int", "constraint" => 11, "null" => true, "default" => 0],
            "minimum_qty"       => ["type" => "int", "constraint" => 11, "null" => true, "default" => 0],
            "original_price"    => ["type" => "int", "constraint" => 11],
            "selling_price"     => ["type" => "int", "constraint" => 11],
            "member_price"      => ["type" => "int", "constraint" => 11, "null" => true, "default" => 0],
            "wholesale_price"   => ["type" => "int", "constraint" => 11, "null" => true, "default" => 0],
            "r_sph"             => ["type" => "varchar", "constraint" => 15, "null" => true],
            "r_cyl"             => ["type" => "varchar", "constraint" => 15, "null" => true],
            "r_add"             => ["type" => "varchar", "constraint" => 15, "null" => true],
            "l_sph"             => ["type" => "varchar", "constraint" => 15, "null" => true],
            "l_cyl"             => ["type" => "varchar", "constraint" => 15, "null" => true],
            "l_add"             => ["type" => "varchar", "constraint" => 15, "null" => true],
            "created_at"        => ["type" => "timestamp"],
            "updated_at"        => ["type" => "timestamp", "null" => true],
        ]);

        $this->forge->addKey("id", true);
        $this->forge->createTable("products");
    }

    public function down()
    {
        $this->forge->dropTable("products", true);
    }
}
