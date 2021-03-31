<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

class LoginController extends Controller
{
    /**
     * Redirect to login page.
     *
     * @return View
     */
    public function index()
    {
        return view('welcome');
    }
}
