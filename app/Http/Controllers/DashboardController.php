<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        if(Auth::user()->type == "admin"){
            return redirect()->route("transactions.history");
        } else {
            return redirect()->route("transactions.dashboard");
        }
    }

}
