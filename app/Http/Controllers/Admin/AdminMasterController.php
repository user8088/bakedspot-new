<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminMasterController extends Controller
{
    public function get_dashboard()
    {
        return view('admin.modules.dashboard');
    }
}
