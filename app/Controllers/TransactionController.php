<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\TransactionModel;
use App\Entities\TransactionEntity;
use App\Models\CustomerModel;
use App\Models\TransactionDetailModel;
use App\Models\TransactionPaymentModel;
use App\Models\UserModel;
use CodeIgniter\I18n\Time;

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
		$customerModel = new \App\Models\CustomerModel();
		$transactions = $this->transactionModel->getTransactions();

		$data = [
			"transactions"		=> $transactions->paginate(100, "transactions"),
			"customers"			=> $customerModel->getNames("customer", "member"),
		];

		return view("transactions/index", $data);
	}

	public function checkCurrentTransaction()
	{
		if (session("createTransaction") && session("transactionID")) {
			return json_encode(true);
		}

		return json_encode(false);
	}

	public function create()
	{
		$transactionID = session("transactionID");
		$customerModel = new \App\Models\CustomerModel();
		$transaction = $this->transactionModel->find($transactionID);
		$transactionDetailModel = new \App\Models\TransactionDetailModel();

		$data = [
			"transaction"			=> $transaction,
			"customer"				=> $customerModel->find($transaction->customer_id),
			"transactionDetails"	=> $transactionDetailModel->getByTransactionID($transactionID),
		];

		return view("transactions/create", $data);
	}

	public function store()
	{
		$inputs = esc($this->request->getPost());

		if (!$this->validate("createTransaction")) {
			return redirect()->to("/transactions")->withInput()->with("validationErrorCreate", true);
		}

		// Check session
		if (session("createTransaction") && session("transactionID")) {
			return redirect()->to("/transactions/create");
		}

		$transaction = [
			"user_id"		=> session("userID"),
			"status"		=> "open",
			"date"			=> Time::now("Asia/Jakarta")->toDateString(),
			"customer_id"	=> $inputs["customer"],
		];

		$this->transactionModel->insert($transaction);
		$transactionID = $this->transactionModel->getInsertID();

		session()->set("createTransaction", true);
		session()->set("transactionID", $transactionID);

		return redirect()->to("/transactions/create");
	}

	public function checkout($id)
	{
		$inputs = esc($this->request->getPost());
		$transaction = $this->transactionModel->find($id);
		$nominal = str_replace(".", "", $inputs["nominal"]);
		$grandTotal = str_replace(".", "", $inputs["grandTotal"]);
		$payment = [
			"nominal"			=> ($nominal >= $grandTotal) ? $grandTotal : $nominal,
			"user_id"			=> session("userID"),
			"transaction_id"	=> $id,
			"date"				=> Time::now("Asia/Jakarta")->toDateString(),
		];

		$this->transactionModel->checkout($id, $inputs, $payment);

		// Remove sessions
		session()->remove("createTransaction");
		session()->remove("transactionID");

		// finishing touch 
		return redirect()->to('/transactions')->with("successMessage", "Berhasil membuat transaksi penjualan");
	}

	public function destroy()
	{
		$transactionID = session("transactionID");
		$transactionDetailModel = new \App\Models\TransactionDetailModel();
		// Delete transaction
		$this->transactionModel->where("id", $transactionID)->delete();

		// Delete transaction details 
		$transactionDetailModel->where("transaction_id", $transactionID)->delete();

		session()->remove("createTransaction");
		session()->remove("transactionID");

		return redirect()->to("/transactions");
	}

	public function delete(int $id)
	{
		$transactionDetailModel = new TransactionDetailModel();
		$transactionPaymentModel = new TransactionPaymentModel();

		$transactionDetailModel->where("transaction_id", $id)->delete();
		$transactionPaymentModel->where("transaction_id", $id)->delete();
		$this->transactionModel->where("id", $id)->delete();

		return redirect()->to("/transactions")->with("successMessage", "Berhasil menghapus transaksi");
	}

	public function show(int $id)
	{
		$transactionPaymentModel = new \App\Models\TransactionPaymentModel();
		$transactionDetailModel = new \App\Models\TransactionDetailModel();
		$transaction = $this->transactionModel->getTransaction($id);

		if (empty($transaction)) {
			throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Transaksi tidak ditemukan");
		}

		// casting date 
		$transaction->formattedDate = $transaction->date->toLocalizedString("dd MMM yyyy");

		$data = [
			"transaction"			=> $transaction,
			"payments"				=> $transactionPaymentModel->getByTransaction($id),
			"transactionDetails"	=> $transactionDetailModel->getProductsByTransaction($id),
		];

		return json_encode($data);
	}

	public function payments(int $id)
	{
		$transaction = $this->transactionModel->select("id, grand_total, status")->where("id", $id)->get()->getRowArray();

		if (empty($transaction)) {
			throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Transaksi Tidak Ditemukan");
		}

		$transactionPaymentModel = new TransactionPaymentModel();

		$data = [
			"transaction"		=> $transaction,
			"payments"			=> $transactionPaymentModel->getByTransaction($id),
		];

		return json_encode($data);
	}

	public function print($id)
	{
		$transaction = $this->transactionModel->find($id);

		if (empty($transaction)) {
			throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Transaksi tidak ditemukan");
		}

		$userModel = new UserModel();
		$customerModel = new CustomerModel();
		$transactionDetailModel = new TransactionDetailModel();

		$data = [
			"transaction"		=> $transaction,
			"user"				=> $userModel->find($transaction->user_id),
			"customer"			=> $customerModel->where("id", $transaction->customer_id)->select("name")->get()->getRowObject(),
			"products"			=> $transactionDetailModel->getProductsByTransaction($transaction->id),
		];

		return view("transactions/invoice", $data);
	}
}
