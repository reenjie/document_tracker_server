<?php

namespace App\Http\Controllers\RBAC;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class Configuration extends Controller
{
    public function index(Request $request)
    {
        return view('rbac.index');
    }
}
