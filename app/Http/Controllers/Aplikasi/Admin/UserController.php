<?php

namespace App\Http\Controllers\Aplikasi\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pegawai;
use App\Models\Ref_Jabatan;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = [
            'title' => 'Data User',
            'menu' => 'user',
            'sub_menu' => 'user',
            'data_user' => Pegawai::where('id_user', '!=', null)->get(),
        ];
        return view('app.admin.user.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = [
            'title' => 'Tambah Data User',
            'menu' => 'user',
            'sub_menu' => 'user',
            'data_jabatan' => Ref_Jabatan::all(),
            'data_role' => Role::where('role', '!=', 'Vendor')->get(),
        ];
        return view('app.admin.user.create', $data);
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
            'email' => 'required|email|unique:user,email',
            'password' => 'required|min:8',
            'id_role' => 'required',
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

        $user = User::create([
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'id_role' => $request->id_role,
        ]);

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
            'id_user' => $user->id,
        ]);

        return redirect()->route('user.index')->with('toast_success', 'Berhasil Menambahkan Data User');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Pegawai $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Pegawai $user)
    {
        $data = [
            'title' => 'Ubah Data Pegawai',
            'menu' => 'pegawai',
            'sub_menu' => 'pegawai',
            'data_jabatan' => Ref_Jabatan::all(),
            'data_role' => Role::where('role', '!=', 'Vendor')->get(),
            'user' => $user,
        ];

        return view('app.admin.user.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Pegawai $user)
    {
        $request->validate([
            'nama' => 'required',
            'jk' => 'required',
            'tempat_lahir' => 'required',
            'tgl_lahir' => 'required',
            'alamat' => 'required',
            'id_jabatan' => 'required',
            'email' => 'required|email|unique:user,email,' . $user->id_user . ',id',
            'id_role' => 'required',
        ]);

        if ($request->password !== null) {
            $request->validate([
                'password' => 'required|min:8',
            ]);
        }

        if ($request->file_ktp !== null) {
            $request->validate([
                'file_ktp' => 'required|mimes:png,jpeg,jpg|max:2048',
            ]);

            $file_ktp = 'KTP-' . time() . '.' . $request->file_ktp->extension();
            $request->file_ktp->move(public_path('assets/file-pegawai'), $file_ktp);
            File::delete('assets/file-pegawai/' . $user->file_ktp);
        } else {
            $file_ktp = $user->file_ktp;
        }

        if ($request->file_asuransi !== null) {
            $request->validate([
                'file_asuransi' => 'required|mimes:png,jpeg,jpg|max:2048',
            ]);

            $file_asuransi = 'ASURANSI-' . time() . '.' . $request->file_asuransi->extension();
            $request->file_asuransi->move(public_path('assets/file-pegawai'), $file_asuransi);
            File::delete('assets/file-pegawai/' . $user->file_asuransi);
        } else {
            $file_asuransi = $user->file_asuransi;
        }

        if ($request->file_foto !== null) {
            $request->validate([
                'file_foto' => 'required|mimes:png,jpeg,jpg|max:2048',
            ]);

            $file_foto = 'FOTO-' . time() . '.' . $request->file_foto->extension();
            $request->file_foto->move(public_path('assets/file-pegawai'), $file_foto);
            File::delete('assets/file-pegawai/' . $user->file_foto);
        } else {
            $file_foto = $user->file_foto;
        }

        User::where('id', $user->id_user)->update([
            'email' => $request->email,
            'id_role' => $request->id_role,
        ]);

        if ($request->password !== null) {
            User::where('id', $user->id_user)->update([
                'password' => Hash::make($request->password),
            ]);
        }

        Pegawai::where('id_pegawai', $user->id_pegawai)->update([
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

        return redirect()->route('user.index')->with('toast_success', 'Berhasil Mengubah Data User');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
