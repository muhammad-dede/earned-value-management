<?php

namespace App\Http\Controllers\Aplikasi\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pegawai;
use App\Models\Ref_Jabatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class PegawaiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = [
            'title' => 'Data Pegawai',
            'menu' => 'pegawai',
            'sub_menu' => 'pegawai',
            'data_pegawai' => Pegawai::all(),
        ];

        return view('app.admin.pegawai.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = [
            'title' => 'Tambah Data Pegawai',
            'menu' => 'pegawai',
            'sub_menu' => 'pegawai',
            'data_jabatan' => Ref_Jabatan::all(),
        ];

        return view('app.admin.pegawai.create', $data);
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
            'nama' => 'required',
            'jk' => 'required',
            'tempat_lahir' => 'required',
            'tgl_lahir' => 'required',
            'alamat' => 'required',
            'file_ktp' => 'required|mimes:png,jpeg,jpg|max:2048',
            'file_asuransi' => 'required|mimes:png,jpeg,jpg|max:2048',
            'file_foto' => 'required|mimes:png,jpeg,jpg|max:2048',
            'id_jabatan' => 'required',
        ]);

        if ($request->file_ktp !== null) {
            $file_ktp = 'KTP-' . time() . '.' . $request->file_ktp->extension();
            $request->file_ktp->move(public_path('assets/file-pegawai'), $file_ktp);
        }

        if ($request->file_asuransi !== null) {
            $file_asuransi = 'ASURANSI-' . time() . '.' . $request->file_asuransi->extension();
            $request->file_asuransi->move(public_path('assets/file-pegawai'), $file_asuransi);
        }

        if ($request->file_foto !== null) {
            $file_foto = 'FOTO-' . time() . '.' . $request->file_foto->extension();
            $request->file_foto->move(public_path('assets/file-pegawai'), $file_foto);
        }

        Pegawai::create([
            'nama' => ucwords($request->nama),
            'jk' => $request->jk,
            'tempat_lahir' => ucwords($request->tempat_lahir),
            'tgl_lahir' => $request->tgl_lahir,
            'alamat' => ucwords($request->alamat),
            'file_ktp' => $file_ktp,
            'file_asuransi' => $file_asuransi,
            'file_foto' => $file_foto,
            'id_jabatan' => $request->id_jabatan,
            'id_user' => null,
        ]);

        return redirect()->route('pegawai.index')->with('toast_success', 'Berhasil Menambahkan Data Pegawai');
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
    public function edit(Pegawai $pegawai)
    {
        $data = [
            'title' => 'Ubah Data Pegawai',
            'menu' => 'pegawai',
            'sub_menu' => 'pegawai',
            'data_jabatan' => Ref_Jabatan::all(),
            'pegawai' => $pegawai,
        ];

        return view('app.admin.pegawai.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Pegawai $pegawai)
    {
        $request->validate([
            'nama' => 'required',
            'jk' => 'required',
            'tempat_lahir' => 'required',
            'tgl_lahir' => 'required',
            'alamat' => 'required',
            'id_jabatan' => 'required',
        ]);

        if ($request->file_ktp !== null) {
            $request->validate([
                'file_ktp' => 'required|mimes:png,jpeg,jpg|max:2048',
            ]);

            $file_ktp = 'KTP-' . time() . '.' . $request->file_ktp->extension();
            $request->file_ktp->move(public_path('assets/file-pegawai'), $file_ktp);
            File::delete('assets/file-pegawai/' . $pegawai->file_ktp);
        } else {
            $file_ktp = $pegawai->file_ktp;
        }

        if ($request->file_asuransi !== null) {
            $request->validate([
                'file_asuransi' => 'required|mimes:png,jpeg,jpg|max:2048',
            ]);

            $file_asuransi = 'ASURANSI-' . time() . '.' . $request->file_asuransi->extension();
            $request->file_asuransi->move(public_path('assets/file-pegawai'), $file_asuransi);
            File::delete('assets/file-pegawai/' . $pegawai->file_asuransi);
        } else {
            $file_asuransi = $pegawai->file_asuransi;
        }

        if ($request->file_foto !== null) {
            $request->validate([
                'file_foto' => 'required|mimes:png,jpeg,jpg|max:2048',
            ]);

            $file_foto = 'FOTO-' . time() . '.' . $request->file_foto->extension();
            $request->file_foto->move(public_path('assets/file-pegawai'), $file_foto);
            File::delete('assets/file-pegawai/' . $pegawai->file_foto);
        } else {
            $file_foto = $pegawai->file_foto;
        }

        Pegawai::where('id_pegawai', $pegawai->id_pegawai)->update([
            'nama' => ucwords($request->nama),
            'jk' => $request->jk,
            'tempat_lahir' => ucwords($request->tempat_lahir),
            'tgl_lahir' => $request->tgl_lahir,
            'alamat' => ucwords($request->alamat),
            'file_ktp' => $file_ktp,
            'file_asuransi' => $file_asuransi,
            'file_foto' => $file_foto,
            'id_jabatan' => $request->id_jabatan,
        ]);

        return redirect()->route('pegawai.index')->with('toast_success', 'Berhasil Mengubah Data Pegawai');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Pegawai $pegawai)
    {
        $pegawai->delete();
        return redirect()->route('pegawai.index')->with('toast_success', 'Berhasil Menghapus Data Pegawai');
    }
}
