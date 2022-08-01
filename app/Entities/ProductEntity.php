<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class ProductEntity extends Entity
{
    protected $datamap = [];
    protected $dates   = ['created_at', 'updated_at'];
    protected $casts   = [];

    public function setOriginalPrice($originalPrice)
    {
        $this->attributes["original_price"] = str_replace(".", "", $originalPrice);
        return $this;
    }

    public function setSellingPrice($sellingPrice)
    {
        $this->attributes["selling_price"] = str_replace(".", "", $sellingPrice);
        return $this;
    }

    public function setMemberPrice($memberPrice)
    {
        $this->attributes["member_price"] = str_replace(".", "", $memberPrice);
        return $this;
    }

    public function setWholesalePrice($wholesalePrice)
    {
        $this->attributes["wholesale_price"] = str_replace(".", "", $wholesalePrice);
        return $this;
    }
}
