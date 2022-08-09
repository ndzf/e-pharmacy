<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class TransactionEntity extends Entity
{
    protected $datamap = [];
    protected $dates   = ['created_at', 'updated_at', 'date'];
    protected $casts   = [];


    public function setGrandTotal($grandTotal) 
    {
        $this->attributes["grand_total"] = str_replace(".", "", $grandTotal);
        return $this;
    }
}
