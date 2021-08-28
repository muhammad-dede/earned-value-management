<?php

namespace App\Http\Controllers\Aplikasi\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pegawai;
use App\Models\Projek;
use App\Models\Vendor_PT;
use Illuminate\Http\Request;

class BerandaController extends Controller
{
    public function index()
    {
        if (auth()->user()->role->role == 'Vendor') {
            # code...
            return view('app.admin.beranda-vendor', [
                'title' => 'Beranda',
                'menu' => 'beranda',
                'sub_menu' => 'beranda',
                'vendor_pengerjaan' => Projek::where('id_vendor_pt', auth()->user()->vendor->id_vendor_pt)->where('id_status', 3)->count(),
                'vendor_selesai' => Projek::where('id_vendor_pt', auth()->user()->vendor->id_vendor_pt)->where('id_status', 4)->count(),
            ]);
        } else {
            # code...
            return view('app.admin.beranda', [
                'title' => 'Beranda',
                'menu' => 'beranda',
                'sub_menu' => 'beranda',
                'total_pengerjaan' => Projek::where('id_status', 3)->count(),
                'total_pegawai' => Pegawai::count(),
                'total_vendor' => Vendor_PT::count(),
                'total_projek' => Projek::count(),
            ]);
        }
    }
}
