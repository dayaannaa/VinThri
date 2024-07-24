<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminHomeController extends Controller
{
    /**
     * Display the admin home page.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        return view('admins.home');
    }
}
