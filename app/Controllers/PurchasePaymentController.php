<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\PurchasePaymentModel;

class PurchasePaymentController extends BaseController
{

    protected $purchasePaymentModel;

    public function __construct
    {
        $this->purchasePaymentModel = new PurchasePaymentModel();
    }

    public function index()
    {
        //
    }

    public function create()
    {
    
    }
}
