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

    public function setSph($sph)
    {
        return ($this->attributes["lens_type"] == "regular") ? $this->attributes["sph"] = $sph : $this->attributes["sph"] = null;
    }

    public function setCyl($cyl)
    {
        $value = ($this->attributes["lens_type"] == "regular") ? $cyl : null;
        return $this->attributes["cyl"] = $value;
    }

    public function setAdd($add)
    {
        $value = ($this->attributes["lens_type"] == "regular") ? $add : null;
        return $this->attributes["add"] = $value;
    }

    public function setRSph($rSph)
    {
        $value = ($this->attributes["lens_type"] == "progressive") ? $rSph : null;
        return $this->attributes["r_sph"] = $value;
    }

    public function setRCyl($rCyl)
    {
        $value = ($this->attributes["lens_type"] == "progressive") ? $rCyl : null;
        return $this->attributes["r_cyl"] = $value;
    }

    public function setRAdd($rAdd)
    {
        $value = ($this->attributes["lens_type"] == "progressive") ? $rAdd : null;
        return $this->attributes["r_add"] = $value;
    }

    public function setLSph($lSph)
    {
        $value = ($this->attributes["lens_type"] == "progressive") ? $lSph : null;
        return $this->attributes["l_sph"] = $value;
    }

    public function setLCyl($lCyl)
    {
        $value = ($this->attributes["lens_type"] == "progressive") ? $lCyl : null;
        return $this->attributes["l_cyl"] = $value;
    }

    public function setLAdd($lAdd)
    {
        $value = ($this->attributes["lens_type"] == "progressive") ? $lAdd : null;
        return $this->attributes["l_add"] = $value;
    }
}
