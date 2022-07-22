<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\CustomerModel;
use App\Entities\CustomerEntity;

class CustomerController extends BaseController
{
    protected CustomerModel $customerModel;

    public function __construct()
    {
        $this->customerModel = new CustomerModel();
    }

    public function index()
    {
        //
    }
}
