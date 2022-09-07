<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\CustomerModel;
use App\Entities\CustomerEntity;
use App\Models\CustomerCardSettingModel;
use BaconQrCode\Common\ErrorCorrectionLevel;
use CodeIgniter\Exceptions\PageNotFoundException;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel\ErrorCorrectionLevelLow;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\RoundBlockSizeMode\RoundBlockSizeModeMargin;
use Endroid\QrCode\Writer\PngWriter;
use Endroid\QrCode\Color\Color;

class CustomerController extends BaseController
{
    protected CustomerModel $customerModel;
    protected $title;

    function getCode($n)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomString = '';

        for ($i = 0; $i < $n; $i++) {
            $index = rand(0, strlen($characters) - 1);
            $randomString .= $characters[$index];
        }

        return $randomString;
    }

    public function __construct()
    {
        $this->customerModel = new CustomerModel();
        $this->title = lang("Customer.title.index");
    }

    public function index()
    {
        $validation = service("validation");
        $keyword = esc($this->request->getVar("q"));
        $customers = $this->customerModel->search($keyword);

        $data = [
            "title"         => $this->title,
            "keyword"       => $keyword,
            "validation"    => $validation->getErrors(),
            "customers"     => $customers->paginate(10, "customers"),
            "pager"         => $customers->pager->links("customers", "default"),
        ];

        return view("customers/index", $data);
    }

    public function create()
    {
        $inputs = esc($this->request->getPost());

        if (!$this->validate("createCustomer")) {
            return redirect()->to("/customers")->withInput()->with("validationErrorCreate", true);
        }

        $customer = new CustomerEntity();
        $customer->name = $inputs["name"];
        $customer->code = $this->customerModel->getLastId() . "-" . $this->getCode(10);
        $customer->phone_number = $inputs["phoneNumber"];
        $customer->email = $inputs["email"];
        $customer->role = $inputs["role"];
        $customer->address = $inputs["address"];

        $this->customerModel->save($customer);

        return redirect()->to("/customers")->with("successMessage", lang("Message.success.create", [strtolower($this->title)]));
    }

    public function edit(int $id)
    {
        $customer = $this->customerModel->find($id);

        if (empty($customer)) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound(lang("Message.error.notFound"), [$this->title]);
        }

        return json_encode($customer);
    }

    public function update(int $id)
    {
        $customer = $this->customerModel->find($id);

        if (empty($customer)) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound(lang("Message.error.notFound"), [$this->title]);
        }

        $inputs = esc($this->request->getPost());

        if (!$this->validate("updateCustomer")) {
            return redirect()->to("/customers")->withInput()->with("validationErrorUpdate", $id);
        }

        $customer->name = $inputs["name"];
        $customer->phone_number = $inputs["phoneNumber"];
        $customer->email = $inputs["email"];
        $customer->role = $inputs["role"];
        $customer->address = $inputs["address"];

        $this->customerModel->save($customer);

        return redirect()->to("/customers")->with("successMessage", lang("Message.success.update", [strtolower($this->title)]));
    }

    public function delete(int $id)
    {
        $this->customerModel->where("id", $id)->delete();
        return redirect()->to("/customers")->with("successMessage", lang("Message.success.delete", [strtolower($this->title)]));
    }

    public function print(int $id)
    {
        $settingModel = new CustomerCardSettingModel();
        $storeModel = new \App\Models\StoreModel();
        $customer = $this->customerModel->find($id);

        if (empty($customer)) {
            throw PageNotFoundException::forPageNotFound("Customer tidak ditemukan");
        }

        $setting = $settingModel->getByStatus("active");
        $writer = new PngWriter();
        $hex = $setting->surface_color ?? "#fff";
        list($r, $g, $b) = sscanf($hex, "#%02x%02x%02x");

        $qrCode = QrCode::create("$customer->name, $customer->phone_number, $customer->address")
            ->setEncoding(new Encoding("UTF-8"))
            ->setErrorCorrectionLevel(new ErrorCorrectionLevelLow())
            ->setSize(48)
            ->setMargin(0)
            ->setRoundBlockSizeMode(new RoundBlockSizeModeMargin())
            ->setForegroundColor(new Color(0, 0, 0))
            ->setBackgroundColor(new Color($r, $g, $b));

        $result = $writer->write($qrCode);

        $data = [
            "customer"      => $customer,
            "store"         => $storeModel->getStore(),
            "setting"       => $setting,
            "qrCode"        => $result->getDataUri()
        ];

        return view("customers/print", $data);
    }
}
