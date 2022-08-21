<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;

class AuthController extends BaseController
{

    protected UserModel $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function login()
    {
        $validation = service("validation");

        $data = [
            "validation"        => $validation->getErrors(),
        ];

        return view("auth/login", $data);
    }

    public function attemptLogin()
    {
        $inputs = esc($this->request->getPost());

        if (!$this->validate("attemptLogin")) {
            return redirect()->to("/login")->withInput()->with("validationError", true);
        }

        $user = $this->userModel->getByUsername($inputs["username"]);
        $hash = $user->password ?? "";
        $passwordVerify = password_verify($inputs["password"], $hash);

        if (empty($user) || !$passwordVerify) {
            dd("Invalid username and password");
        }

        $payload = [
            "isLoggedIn"        => true,
            "userID"            => $user->id,
            "role"              => $user->role,
        ];

        session()->set($payload);
        return redirect()->to("/");
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to("/");
    }
}
