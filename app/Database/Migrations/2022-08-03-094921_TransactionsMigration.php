<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class TransactionsMigration extends Migration
{
    public function up()
    {
		$this->forge->addField([
			"id"				=> ["type" => "int", "constraint" => 11, "auto_increment" => true],
			"user_id"			=> ["type" => "int", "constraint" => 11],
			"customer_id"		=> ["type" => "int", "constraint" => 11, "null" => true],
			"status"			=> ["type" => "enum", "constraint" => ["open", "done"]],
			"payment_status"	=> ["type" => "enum", "constraint" => ["cash", "debt"], "null" => true],
			"grand_total"		=> ["type" => "int", "constraint" => 11, "null" => true],
			"discount"			=> ["type" => "int", "constraint" => 11, "null" => true],
			"date"				=> ["type" => "date"],
			"created_at"		=> ["type" => "timestamp"],
			"updated_at"		=> ["type" => "timestamp", "null" => true],
		]);
		$this->forge->addkey("id", true);
		$this->forge->createTable("transactions", true);
    }

    public function down()
    {
		$this->forge->dropTable("transactions", true);
    }
}
