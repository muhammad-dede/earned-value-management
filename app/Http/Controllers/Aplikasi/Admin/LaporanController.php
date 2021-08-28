<?php

namespace App\Http\Controllers\Aplikasi\Admin;

use App\Http\Controllers\Controller;
use App\Models\Projek;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function index()
    {
        if (auth()->user()->role->role == 'Vendor') {
            # code...
            $projek = Projek::where('id_status', 4)->where('id_vendor_pt', auth()->user()->vendor->id_vendor_pt)->get();
        } else {
            # code...
            $projek = Projek::where('id_status', 4)->get();
        }
        return view('app.admin.laporan.index', [
            'title' => 'Laporan',
            'menu' => 'laporan',
            'sub_menu' => 'laporan',
            'data_projek' => $projek,
        ]);
    }

    public function print_pdf(Projek $projek)
    {
        return view('app.admin.projek.print-pdf', [
            'projek' => $projek,
        ]);
    }
}
