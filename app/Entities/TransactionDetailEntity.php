<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class TransactionDetailEntity extends Entity
{
    protected $datamap = [];
    protected $dates   = ['created_at', 'updated_at'];
    protected $casts   = [];

    public function setProductPrice($productPrice)
    {
        $this->attributes["product_price"] = str_replace(".", "", $productPrice);
        return $this;
    }
}
