<?php

namespace App\Controllers;

use App\Models\UserModel;

class AuthController extends BaseController
{
    public function login()
    {
        if (strtolower($this->request->getMethod()) === 'post') {
            $username = $this->request->getPost('username');
            $password = $this->request->getPost('password');

            $userModel = new UserModel();
            $user = $userModel->where('username', $username)->first();

            if (! $user || ! password_verify($password, $user['password'])) {
                return redirect()->back()->with('error', 'Username atau password salah.');
            }

            session()->set([
                'isLoggedIn'     => true,
                'user_id'        => $user['id'],
                'name'           => $user['name'],
                'role'           => $user['role'],
                'approval_level' => $user['approval_level']
            ]);

            return redirect()->to('/dashboard');
        }

        return view('auth/login');
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login');
    }
}