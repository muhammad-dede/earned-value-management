<?php

namespace App\Http\Controllers\Aplikasi\Admin;

use App\Http\Controllers\Controller;
use App\Models\Vendor_PT;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class VendorPTController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = [
            'title' => 'Data Vendor PT',
            'menu' => 'vendor_pt',
            'sub_menu' => 'vendor_pt',
            'data_vendor_pt' => Vendor_PT::all(),
        ];

        return view('app.admin.vendor-pt.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = [
            'title' => 'Tambah Data Vendor PT',
            'menu' => 'vendor_pt',
            'sub_menu' => 'vendor_pt',
        ];

        return view('app.admin.vendor-pt.create', $data);
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
            'vendor' => 'required',
            'alamat' => 'required',
            'telp' => 'required',
            'logo' => 'required|mimes:png,jpg,jpeg|max:2048',
        ]);

        if ($request->logo !== null) {
            $logo = 'logo-' . time() . '.' . $request->logo->extension();
            $request->logo->move(public_path('assets/vendor-pt'), $logo);
        }

        Vendor_PT::create([
            'vendor' => strtoupper($request->vendor),
            'alamat' => ucwords($request->alamat),
            'telp' => $request->telp,
            'logo' => $logo,
        ]);

        return redirect()->route('vendor-pt.index')->with('toast_success', 'Berhasil Menambahkan Vendor PT');
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
    public function edit(Vendor_PT $vendor_pt)
    {
        $data = [
            'title' => 'Ubah Data Vendor PT',
            'menu' => 'vendor_pt',
            'sub_menu' => 'vendor_pt',
            'vendor_pt' => $vendor_pt,
        ];

        return view('app.admin.vendor-pt.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Vendor_PT $vendor_pt)
    {
        $request->validate([
            'vendor' => 'required',
            'alamat' => 'required',
            'telp' => 'required',
        ]);

        if ($request->logo !== null) {
            $request->validate([
                'logo' => 'required|mimes:png,jpg,jpeg|max:2048',
            ]);

            $logo = 'logo-' . time() . '.' . $request->logo->extension();
            $request->logo->move(public_path('assets/vendor-pt'), $logo);
            File::delete('assets/vendor-pt/' . $vendor_pt->logo);
        } else {
            $logo = $vendor_pt->logo;
        }

        Vendor_PT::where('id_vendor_pt', $vendor_pt->id_vendor_pt)->update([
            'vendor' => strtoupper($request->vendor),
            'alamat' => ucwords($request->alamat),
            'telp' => $request->telp,
            'logo' => $logo,
        ]);

        return redirect()->route('vendor-pt.index')->with('toast_success', 'Berhasil Mengubah Vendor PT');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Vendor_PT $vendor_pt)
    {
        $vendor_pt->delete();
        return redirect()->route('vendor-pt.index')->with('toast_success', 'Berhasil Menghapus Vendor PT');
    }
}
