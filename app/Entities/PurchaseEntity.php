<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class PurchaseEntity extends Entity
{
    protected $datamap = [];
    protected $dates   = ['created_at', 'updated_at', "date"];
    protected $casts   = [];
}
