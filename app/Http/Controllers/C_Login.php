<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class C_Login extends Controller
{
    public function login() {
        return 'login';
    }

    public function logout() {
        return 'logout';
    }
}
