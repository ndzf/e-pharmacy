<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\SupplierModel;
use App\Entities\SupplierEntity;

class SupplierController extends BaseController
{
    protected SupplierModel $supplierModel;

    public function __construct()
    {
        $this->supplierModel = new SupplierModel();
    }

    public function index()
    {
        //
    }
}
