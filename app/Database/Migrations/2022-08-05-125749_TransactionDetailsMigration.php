<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class TransactionDetailsMigration extends Migration
{
    public function up()
    {
        $this->forge->addField([
            "id"                => ["type" => "int", "constraint" => 11, "auto_increment" => true],
            "transaction_id"    => ["type" => "int", "constraint" => 11],
            "product_id"        => ["type" => "int", "constraint" => 11],
            "product_name"      => ["type" => "varchar", "constraint" => 255, "null" => true],
            "product_price"     => ["type" => "int", "constraint" => 11, "null" => true],
            "qty"               => ["type" => "int", "constraint" => 11],
            "axis"              => ["type" => "varchar", "constraint" => 15, "null" => true],
            "r_axis"            => ["type" => "varchar", "constraint" => 15, "null" => true],
            "l_axis"            => ["type" => "varchar", "constraint" => 15, "null" => true],
            "created_at"        => ["type" => "timestamp"],
            "updated_at"        => ["type" => "timestamp", "null" => true],
        ]);
        $this->forge->addKey("id", true);
        $this->forge->createTable("transaction_details");
    }

    public function down()
    {
        $this->forge->dropTable("transaction_details");
    }
}
