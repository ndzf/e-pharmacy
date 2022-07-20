<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;
use App\Entities\UserEntity;

class UserController extends BaseController
{

    protected UserModel $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function index()
    {
        $keyword = esc($this->request->getVar("q"));
        $validation = service("validation");
        $users = $this->userModel->search($keyword);

        $data = [
            "keyword"       => $keyword,
            "users"         => $users->paginate(10, "users"),
            "pager"         => $users->pager->links("users", "default"),
            "title"         => lang("User.title.index"),
            "validation"    => $validation->getErrors(),
        ];

        return view("users/index", $data);
    }

    public function create()
    {
        $inputs = esc($this->request->getPost());
        // Validate the inputs 
        if (!$this->validate("createUser")) {
            return redirect()->to("/users")->withInput()->with("validationErrorCreate", true);
        }

        // Fill properties of user
        $user = new UserEntity();
        $user->username = $inputs["username"];
        $user->password = password_hash($inputs["password"], PASSWORD_BCRYPT);
        $user->name = $inputs["name"];
        $user->phone_number = $inputs["phoneNumber"];
        $user->role = $inputs["role"];
        $user->status = "active";

        // Store new user
        $this->userModel->save($user);
        // redirect to '/users'
        return redirect()->to("/users")->withInput()->with("successMessage", lang("User.messages.success.create"));
    }

    public function edit(int $id)
    {
        $user = $this->userModel->find($id);
        // Throw 404 if user not found
        if (empty($user)) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound(lang("User.messages.error.userNotFound"));
        }

        return json_encode($user);
    }

    public function update(int $id)
    {
        $user = $this->userModel->find($id);

        if (empty($user)) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound(lang("User.messages.error.userNotFound"));
        }

        $inputs = esc($this->request->getPost());
        // Validation Rules 
        $rules = [
            "role"              => [
                "label"         => "User.role",
                "rules"         => "required"
            ],
            "status"            => [
                "label"         => "User.status",
                "rules"         => "required"
            ],
            "name"              => [
                "label"         => "User.name",
                "rules"         => "required"
            ],
        ];

        if (!$this->validate($rules)) {
            return redirect()->to("/users")->withInput()->with("validationErrorUpdate", $id);
        }

        // Updating properties 
        $user->name = $inputs["name"];
        $user->status = $inputs["status"];
        $user->role = $inputs["role"];
        $user->phone_number = $inputs["phoneNumber"];

        // Updating user 
        $this->userModel->save($user);
        // Redirect to users
        return redirect()->to("/users")->with("successMessage", lang("User.messages.success.update"));
    }

    public function delete(int $id)
    {
        $this->userModel->where("id", $id)->delete();
        return redirect()->to("/users")->with("successMessage", lang("User.messages.success.delete"));
    }
}
