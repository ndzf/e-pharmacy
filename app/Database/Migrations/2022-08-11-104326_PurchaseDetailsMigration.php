<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class PurchaseDetailsMigration extends Migration
{
    public function up()
    {
        $this->forge->addField([
            "id"                => ["type" => "int", "constraint" => 11, "auto_increment" => true],
            "purchase_id"       => ["type" => "int", "constraint" => 11],
            "product_id"        => ["type" => "int", "constraint" => 11],
            "product_name"      => ["type" => "varchar", "constraint" => 255, "null" => true],
            "qty"               => ["type" => "int", "constraint" => 11],
            "price"             => ["type" => "int", "constraint" => 11],
            "created_at"        => ["type" => "timestamp"],
            "updated_at"        => ["type" => "timestamp"],
        ]);
        $this->forge->addKey("id", true);
        $this->forge->createTable("purchase_details");
    }

    public function down()
    {
        $this->forge->dropTable("purchase_details");
    }
}
