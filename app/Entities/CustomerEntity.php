<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class CustomerEntity extends Entity
{
    protected $datamap = [];
    protected $dates   = ['created_at', 'updated_at'];
    protected $casts   = [];

    public function getBadgeTheme() {
        if ($this->role == "customer") {
            return "badge-light-warning";
        }

        if ($this->role == "member") {
            return "badge-light-primary";
        }

        if ($this->role == "reseller") {
            return "badge-light-success";
        }
    }
}
