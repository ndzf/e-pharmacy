<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class PurchasePaymentsMigration extends Migration
{
    public function up()
    {
        $this->forge->addField([
            "id"                => ["type" => "int", "constraint" => 11, "auto_increment" => true], 
            "purchase_id"       => ["type" => "int", "constraint" => 11],
            "user_id"           => ["type" => "int", "constraint" => 11],
            "nominal"           => ["type" => "int", "constraint" => 11],
            "date"              => ["type" => "date"],
            "created_at"        => ["type" => "timestamp"],
            "updated_at"        => ["type" => "timestamp", "null" => true],
        ]);
        $this->forge->addKey("id", true);
        $this->forge->createTable("purchase_payments");
    }

    public function down()
    {
        $this->forge->dropTable("purchase_payments");
    }
}
