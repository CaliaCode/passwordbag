<?php

namespace App\Http\Controllers\Admin;

// Framework
use App\Http\Requests;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{

    /**
     * Display the PasswordBag main page.
     * 
     * @return \Illuminate\Http\Response
     */
    public function index(){
        return view('layouts.admin');
    }
}
