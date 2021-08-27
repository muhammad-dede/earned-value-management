<?php

namespace App\Http\Controllers\Aplikasi\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Vendor;
use App\Models\Vendor_PT;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class VendorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = [
            'title' => 'Data Vendor',
            'menu' => 'vendor',
            'sub_menu' => 'vendor',
            'data_vendor' => Vendor::all(),
        ];

        return view('app.admin.vendors.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = [
            'title' => 'Tambah Data Vendor',
            'menu' => 'vendor',
            'sub_menu' => 'vendor',
            'data_vendor_pt' => Vendor_PT::all(),
        ];

        return view('app.admin.vendors.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_vendor_pt' => 'required',
            'nama' => 'required',
            'telp' => 'required',
            'email' => 'required|email|unique:user,email',
            'password' => 'required|min:8',
        ]);

        $user = User::create([
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'id_role' => 5,
        ]);

        Vendor::create([
            'id_vendor_pt' => $request->id_vendor_pt,
            'nama' => ucwords($request->nama),
            'telp' => $request->telp,
            'id_user' => $user->id,
        ]);

        return redirect()->route('vendors.index')->with('toast_success', 'Berhasil Menambahkan Vendor');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Vendor $vendor)
    {
        $data = [
            'title' => 'Ubah Data Vendor',
            'menu' => 'vendor',
            'sub_menu' => 'vendor',
            'data_vendor_pt' => Vendor_PT::all(),
            'vendor' => $vendor,
        ];

        return view('app.admin.vendors.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Vendor $vendor)
    {
        $request->validate([
            'id_vendor_pt' => 'required',
            'nama' => 'required',
            'telp' => 'required',
            'email' => 'required|email|unique:user,email,' . $vendor->user->id . ',id',
        ]);

        if ($request->password !== null) {
            $request->validate([
                'password' => 'required|min:8',
            ]);
            User::where('id', $vendor->user->id)->update([
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'id_role' => 5,
            ]);
        } else {
            User::where('id', $vendor->user->id)->update([
                'email' => $request->email,
                'id_role' => 5,
            ]);
        }

        Vendor::where('id_vendor', $vendor->id_vendor)->update([
            'id_vendor_pt' => $request->id_vendor_pt,
            'nama' => ucwords($request->nama),
            'telp' => $request->telp,
        ]);

        return redirect()->route('vendors.index')->with('toast_success', 'Berhasil Mengubah Vendor');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Vendor $vendor)
    {
        $vendor->delete();
        return redirect()->route('vendors.index')->with('toast_success', 'Berhasil Menghapus Vendor');
    }
}
