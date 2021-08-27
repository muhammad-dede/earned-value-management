<?php

namespace App\Http\Controllers\Aplikasi\Vendor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BerandaController extends Controller
{
    public function index()
    {
        $data = [
            'title' => 'Beranda',
            'menu' => 'beranda',
            'sub_menu' => 'beranda',
        ];

        return view('app.vendor.beranda', $data);
    }
}