<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\PurchaseModel;

class PurchaseController extends BaseController
{
    protected $purchaseModel;

    public function __construct()
    {
        $this->purchaseModel = new PurchaseModel;
    }

    public function index()
    {
        //
    }
}
