<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class PurchasesMigration extends Migration
{
    public function up()
    {
        $this->forge->addField([
            "id"                => ["type" => "int", "constraint" => 11, "auto_increment" => true],
            "user_id"           => ["type" => "int", "constraint" => 11],
            "status"            => ["type" => "enum", "constraint" => ["open", "done"], "default" => "open"],
            "payment_status"    => ["type" => "enum", "constraint" => ["cash", "debt"], "null" => true],
            "grand_total"       => ["type" => "int", "constraint" => 11, "null" => true],
            "discount"          => ["type" => "int", "constraint" => 11, "null" => true],
            "date"              => ["type" => "date"],
            "created_at"        => ["type" => "timestamp"],
            "updated_at"        => ["type" => "timestamp", "null" => true],
        ]);

        $this->forge->addKey("id", true);
        $this->forge->createTable("purchases");
    }

    public function down()
    {
        $this->forge->dropTable("purchases");
    }
}
