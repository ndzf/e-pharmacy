<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;

class ProfileController extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function index()
    {
        $userID = session("userID");

        $user = $this->userModel->find($userID);
        $validation = service("validation");

        if (empty($user)) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("User tidak ditemukan");
        }

        $data = [
            "title"         => "Profile",
            "user"          => $user,
            "validation"    => $validation->getErrors(),
        ];

        return view("profile/index", $data);
    }

    public function update(int $id)
    {
        $user = $this->userModel->find($id);

        if (empty($user)) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("User tidak ditemukan");
        }

        $inputs = esc($this->request->getPost());

        $rules = [
            "name"          => ["label" => "User.name", "rules" => "required"],
        ];

        $usernameRules = null;
        if ($inputs["username"] == $inputs["currentUsername"]) {
            $usernameRules = ["username" => ["label" => "User.username", "rules" => "required|min_length[4]"]];
        } else {
            $usernameRules = ["username" => ["label" => "User.username", "rules" => "required|min_length[4]|is_unique[users.username,$inputs[currentUsername]]"]];
        }

        $rules += $usernameRules;

        $updatePassword = false;
        if ($inputs["password"]) {
            $passwordRules = ["password" => ["label" => "User.password", "rules" => "required|min_length[5]"]];
            $rules += $passwordRules;
            $updatePassword = true;
        }

        if (!$this->validate($rules)) {
            return redirect()->to("/profile")->withInput();
        }

        $user->username = $inputs["username"];
        $user->name = $inputs["name"];
        $user->phone_number = $inputs["phoneNumber"];
        if ($updatePassword == true) {
            $user->password = password_hash($inputs["password"], PASSWORD_BCRYPT);
        }

        // Update user
        $this->userModel->save($user);

        if ($updatePassword == true) {
            return redirect()->to("/login");
        }
        return redirect()->to("/profile")->with("successMessage", "Berhasil memperbaharui profile");
    }
}
