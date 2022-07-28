<?php

namespace App\Libraries;
use App\Models\SupplierModel;

class Supplier 
{
    protected $supplierModel;

    public function __construct()
    {
        $this->supplierModel = new SupplierModel();
    }

    public function getNames(?string $active)
    {
        $data = [
            "active"            => $active,
            "data"              => $this->supplierModel->getNames(),
        ];

        return view("_partials/forms/options", $data);
    }
}