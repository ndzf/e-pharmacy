<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\StoreModel;
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
        $storeModel = new StoreModel();

        $data = [
            "validation"        => $validation->getErrors(),
            "store"             => $storeModel->getStore(),
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
            return redirect()->to("/login")->withInput()->with("errorMessage", "Email atau password salah");
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
