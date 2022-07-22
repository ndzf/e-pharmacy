<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\CustomerModel;
use App\Entities\CustomerEntity;

class CustomerController extends BaseController
{
    protected CustomerModel $customerModel;
    protected $title;

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
}
