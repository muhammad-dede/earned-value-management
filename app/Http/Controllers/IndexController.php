<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function index()
    {
        if (auth()->user()->role->role == 'vendor') {
            return redirect()->route('vendor.beranda');
        } else {
            return redirect()->route('beranda');
        }
    }
}
