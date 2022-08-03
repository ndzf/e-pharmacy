<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\TransactionModel;

class TransactionController extends BaseController
{
	protected $transactionModel;
	protected $title;

	public function __construct()
	{
		$this->transactionModel = new TransactionModel();
		$this->title = lang("Transaction.title.index");
	}

    public function index()
    {
		//
    }
}
