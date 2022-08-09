<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class TransactionPaymentEntity extends Entity
{
    protected $datamap = [];
    protected $dates   = ['created_at', 'updated_at'];
    protected $casts   = [];

    public function getDate()
    {
       $this->attributes["date"] = $this->mutateDate($this->attributes["date"]);
       return $this->attributes["date"]->format("d M Y");
    }
}
