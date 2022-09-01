<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\CustomerCardSettingModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class CustomerCardSettingController extends BaseController
{
    protected $settingModel;
    protected $settingStatus;

    public function __construct()
    {
        $this->settingModel = new CustomerCardSettingModel();
        $this->settingStatus = "active";
    }

    public function index()
    {
        $setting = $this->settingModel->getByStatus($this->settingStatus);

        $data = [
            "setting"           => $setting,
        ];

        return view("customerCardSetting/index", $data);
    }

    public function update(int $id)
    {
        $validationRules = [
            "background_image"          => ["label" => "Background image", "rules" => "is_image[background_image]"],
        ];

        $inputs = [
            "background_image"  => $this->request->getFile("background_image"),
            "text_color"        => esc($this->request->getPost("text_color")),
            "primary_color"     => esc($this->request->getPost("primary_color")),
            "surface_color"     => esc($this->request->getPost("surface_color")),
        ];

        $setting = $this->settingModel->getByStatus($this->settingStatus);

        if (empty($setting)) {
            throw PageNotFoundException::forPageNotFound("Pengaturan tidak ditemukan");
        }

        if ($inputs["background_image"]->getError() != 4) {
            if (!$this->validate($validationRules)) {
                return redirect()->to("/store")->with("errorMessage", $this->validator->getError("background_image"));
            }

            $fileName = $inputs["background_image"]->getRandomName();
            $targetPath = $_SERVER["DOCUMENT_ROOT"] . "/assets/customer-card/";
            $inputs["background_image"]->move($targetPath, $fileName);

            $setting->background_image = $fileName;
        }
        $setting->text_color = $inputs["text_color"];
        $setting->primary_color = $inputs["primary_color"];
        $setting->surface_color = $inputs["surface_color"];

        try {
            $this->settingModel->save($setting);
            return redirect()->to("/store")->with("successMessage", "Berhasil memperbaharui pengaturan");
        } catch (\Exception $e) {
            return redirect()->to("/store")->with("errorMessage", $e->getMessage());
        }
    }
}
