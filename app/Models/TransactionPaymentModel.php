<?php

namespace App\Models;

use CodeIgniter\I18n\Time;
use CodeIgniter\Model;

class TransactionPaymentModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'transaction_payments';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = \App\Entities\TransactionPaymentEntity::class;
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ["transaction_id", "user_id", "nominal", "date"];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    public function getByTransaction($transactionID)
    {
        $builder = $this->table("transaction_payments");
        $builder->select("id, date, nominal");
        $builder->where("transaction_id", $transactionID);
        $data = $builder->get();
        return $data->getCustomResultObject("\App\Entities\TransactionPaymentEntity");
    }

    public function todayNominal()
    {
        $date = Time::parse("now", "Asia/Jakarta")->toDateString();
        $builder = $this->table("transaction_payments");
        $builder->select("id, nominal");
        $builder->where("date", $date);
        $row = $builder->get();
        $transactions = $row->getResultArray();
        $nominal = 0;
        foreach ($transactions as $transaction) {
            $nominal += $transaction["nominal"];
        }
        return $nominal;
    }

    public function getTotalByTransaction($transactionId)
    {
        $builder = $this->builder("transaction_payments");
        $builder->select("id, nominal");
        $builder->where("transaction_id", $transactionId);
        $data = $builder->get();
        $payments = $data->getCustomResultObject("\App\Entities\TransactionPaymentEntity");
        $total = 0;

        if (empty($payments)) {
            return $total;
        }

        foreach ($payments as $payment) {
            $total += $payment->nominal;
        }

        return $total;
    }
}
