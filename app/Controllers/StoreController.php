<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\CustomerCardSettingModel;
use App\Models\StoreModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class StoreController extends BaseController
{
    protected $storeModel;

    public function __construct()
    {
        $this->storeModel = new StoreModel();
    }

    public function index()
    {
        $store = $this->storeModel->getStore();
        $settingModel = new CustomerCardSettingModel();

        if (empty($store)) {
            throw PageNotFoundException::forPageNotFound("something error");
        }

        $data = [
            "title"     => "Toko",
            "store"     => $store,
            "setting"   => $settingModel->getByStatus("active"),
        ];

        return view("store/index", $data);
    }

    public function update(int $id)
    {
        $inputs = esc($this->request->getPost());
        $store = $this->storeModel->getStore();

        if (empty($store)) {
            throw PageNotFoundException::forPageNotFound("something error");
        }

        $store->name = $inputs["name"];
        $store->phone_number = $inputs["phoneNumber"];
        $store->email = $inputs["email"];
        $store->address = $inputs["address"];

        try {
            $this->storeModel->save($store);
            return redirect()->to("/store")->with("successMessage", "Berhasil memperbaharui data toko");
        } catch (\Exception $e) {
            return redirect()->to("/store")->with("errorMessage", $e->getMessage());
        }
    }

    public function print_customer()
    {
        $inputs = [
            "file"          => $this->request->getFile("file"),
            "textColor"     => esc($this->request->getPost("textColor")),
        ];

        $store = $this->storeModel->getStore();

        if (empty($store)) {
            throw PageNotFoundException::forPageNotFound("something error");
        }

        $validationRules = [
            "file"          => ["label" => "Background", "rules" => "is_image[file]"],
        ];

        if ($inputs["file"]->getError() != 4) {
            if (!$this->validate($validationRules)) {
                return redirect()->to("/store")->with("errorMessage", $this->validator->getError("file"));
            }

            // Moving file
            $fileName = $inputs["file"]->getRandomName();
            $targetPath = $_SERVER["DOCUMENT_ROOT"] . "/assets/print-customer/";
            $inputs["file"]->move($targetPath, $fileName);

            $store->banner = $fileName;
        }
        $store->text_color = $inputs["textColor"];
        // check upload image or not
        try {
            $this->storeModel->save($store);
            return redirect()->to("/store")->with("successMessage", "Berhasil memperbaharui data toko");
        } catch (\Exception $e) {
            return redirect()->to("/store")->with("errorMessage", $e->getMessage());
        }
    }

    public function invoiceSetting()
    {
        $validationRules = [
            "invoice_banner"          => ["label" => "Invoice header", "rules" => "is_image[invoice_banner]"],
        ];
        $file = $this->request->getFile("invoice_banner");
        if ($file->getError() != 4) {
            if (!$this->validate($validationRules)) {
                return redirect()->to("/store")->with("errorMessage", $this->validator->getError("invoice_banner"));
            }

            $fileName = $file->getRandomName();
            $targetPath = $_SERVER["DOCUMENT_ROOT"] . "/assets/images/invoice_banner/";
            $file->move($targetPath, $fileName);

            $store = $this->storeModel->getStore();
            $store->invoice_banner = $fileName;
            $this->storeModel->save($store);

            return redirect()->to("/store")->with("successMessage", "Berhasil memperbaharui Logo");
        }
        return redirect()->to("/store")->with("errorMessage", "Logo not uploaded");
    }
}
