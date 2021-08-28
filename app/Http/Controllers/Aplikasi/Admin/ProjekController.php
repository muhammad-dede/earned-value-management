<?php

namespace App\Http\Controllers\Aplikasi\Admin;

use App\Http\Controllers\Controller;
use App\Models\Laporan_Pekerjaan;
use App\Models\Laporan_Pengeluaran;
use App\Models\Projek;
use App\Models\Surat_Jalan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class ProjekController extends Controller
{
    public function __construct()
    {
        $this->middleware('projek_create')->only(['create']);
        $this->middleware('projek_edit')->only(['edit']);
        $this->middleware('projek_destroy')->only(['destroy']);
    }

    public function index()
    {
        $data = [
            'title' => 'Data Projek',
            'menu' => 'projek',
            'sub_menu' => 'projek',
            'data_projek' => Projek::orderBy('tgl_kontrak', 'desc')->get(),
        ];
        return view('app.admin.projek.index', $data);
    }

    public function create()
    {
        $data = [
            'title' => 'Tambah Projek',
            'menu' => 'projek',
            'sub_menu' => 'projek',
        ];
        return view('app.admin.projek.create', $data);
    }

    public function store(Request $request)
    {
        //
    }

    public function show(Projek $projek)
    {
        $data = [
            'title' => 'Detail Projek',
            'menu' => 'projek',
            'sub_menu' => 'projek',
            'projek' => $projek
        ];
        return view('app.admin.projek.show', $data);
    }

    public function edit(Projek $projek)
    {
        $data = [
            'title' => 'Ubah Projek',
            'menu' => 'projek',
            'sub_menu' => 'projek',
            'projek' => $projek
        ];
        return view('app.admin.projek.edit', $data);
    }

    public function update(Request $request, Projek $projek)
    {
        if ($projek->id_status == 1) {
            $id_status = 2;
        } elseif ($projek->id_status == 2) {
            $id_status = 3;
        } elseif ($projek->id_status == 3) {
            $id_status = 4;
        } elseif ($projek->id_status == 4) {
            $id_status = 5;
        }

        $projek->update([
            'id_status' => $id_status,
        ]);

        return redirect()->route('projek.show', $projek)->with('toast_success', 'Berhasil Mengubah Status Projek');
    }

    public function destroy(Projek $projek)
    {
        File::delete('assets/projek/' . $projek->file_izin_kerja);
        File::delete('assets/projek/' . $projek->file_kontrak);

        $projek->delete();
        return redirect()->route('projek.index')->with('toast_success', 'Berhasil Menghapus Projek');
    }

    public function kurva(Projek $projek)
    {
        $cek_laporan_pekerjaan = Laporan_Pekerjaan::where('id_projek', $projek->id_projek);
        if ($cek_laporan_pekerjaan->count() == 0) {
            return abort('404');
        }

        $laporan_pekerjaan = Laporan_Pekerjaan::where('id_projek', $projek->id_projek)->orderBy('tgl')->get();
        $actual = 0;
        $schedule = 0;
        $acwp_count = 0;
        $bcwp_count = 0;
        $bcws_count = 0;

        foreach ($laporan_pekerjaan as $pekerjaan) {
            $actual += $pekerjaan->bobot_actual;
            $schedule += $pekerjaan->bobot_schedule;
            $acwp_count += $pekerjaan->acwp;
            $bcwp_count += $pekerjaan->bcwp;
            $bcws_count += $pekerjaan->bcws;
            //
            $categories[] = Carbon::parse($pekerjaan->tgl)->format('d M');
            $bobot_actual[] = $actual;
            $bobot_schedule[] = $schedule;
            $acwp[] = $acwp_count;
            $bcwp[] = $bcwp_count;
            $bcws[] = $bcws_count;
        }

        $jumlah_hari_pengerjaan = Laporan_Pekerjaan::where('id_projek', $projek->id_projek)->count();
        $bcwp_kum = Laporan_Pekerjaan::where('id_projek', $projek->id_projek)->sum('bcwp');
        $acwp_kum = Laporan_Pekerjaan::where('id_projek', $projek->id_projek)->sum('acwp');
        $bcws_kum = Laporan_Pekerjaan::where('id_projek', $projek->id_projek)->sum('bcws');
        $cpi = $bcwp_kum / $acwp_kum;
        $etc = ($projek->nilai_kontrak - $bcwp_kum) / ($cpi);
        $eac = $acwp_kum + $etc;
        $spi = $bcwp_kum / $bcws_kum;
        $te = $jumlah_hari_pengerjaan + (($projek->durasi_kontrak - ($jumlah_hari_pengerjaan * $spi)) / $spi);

        return view('app.admin.projek.kurva', [
            'title' => 'Kurva Projek',
            'menu' => 'projek',
            'sub_menu' => 'projek',
            'projek' => $projek,
            'categories' => $categories,
            'bobot_actual' => $bobot_actual,
            'bobot_schedule' => $bobot_schedule,
            'acwp' => $acwp,
            'bcwp' => $bcwp,
            'bcws' => $bcws,
            'cpi' => $cpi,
            'etc' => $etc,
            'eac' => $eac,
            'spi' => $spi,
            'te' => $te,
        ]);
    }

    public function detail_laporan_pengeluaran(Laporan_Pekerjaan $laporan_pekerjaan)
    {
        return view('app.admin.projek.laporan-pengeluaran', [
            'title' => 'Detail Laporan Pekerjaan',
            'menu' => 'projek',
            'sub_menu' => 'projek',
            'data_laporan_pengeluaran' => Laporan_Pengeluaran::where('id_laporan_pekerjaan', $laporan_pekerjaan->id_laporan_pekerjaan)->get(),
            'laporan_pekerjaan' => $laporan_pekerjaan,
        ]);
    }

    public function tambah_surat_jalan(Projek $projek)
    {
        return view('app.admin.projek.tambah-surat-jalan', [
            'title' => 'Tambah Surat Jalan',
            'menu' => 'projek',
            'sub_menu' => 'projek',
            'projek' => $projek,
        ]);
    }

    public function upload_surat_jalan(Request $request, Projek $projek)
    {
        $request->validate([
            'keterangan' => 'required',
            'tgl_surat' => 'required',
            'file_surat' => 'required|mimes:pdf|max:2048',
        ]);

        if ($request->file_surat !== null) {
            $file_surat = 'SJ-' . time() . '.' . $request->file_surat->extension();
            $request->file_surat->move(public_path('assets/file-surat-jalan'), $file_surat);
        }

        Surat_Jalan::create([
            'no_surat_jalan' => time(),
            'id_projek' => $projek->id_projek,
            'keterangan' => $request->keterangan,
            'tgl_surat' => $request->tgl_surat,
            'file_surat' => $file_surat,
        ]);

        return redirect()->route('projek.show', $projek)->with('toast_success', 'Berhasil Upload Surat Jalan');
    }

    public function edit_surat_jalan($no_surat_Jalan)
    {
        return view('app.admin.projek.edit-surat-jalan', [
            'title' => 'Edit Surat Jalan',
            'menu' => 'projek',
            'sub_menu' => 'projek',
            'surat_jalan' => Surat_Jalan::where('no_surat_jalan', $no_surat_Jalan)->first(),
        ]);
    }

    public function update_surat_jalan(Request $request, $no_surat_Jalan)
    {
        $request->validate([
            'keterangan' => 'required',
            'tgl_surat' => 'required',
        ]);

        $surat_Jalan = Surat_Jalan::where('no_surat_jalan', $no_surat_Jalan)->first();

        if ($request->file_surat !== null) {
            $request->validate([
                'file_surat' => 'required|mimes:pdf|max:2048',
            ]);
            $file_surat = 'SJ-' . time() . '.' . $request->file_surat->extension();
            $request->file_surat->move(public_path('assets/file-surat-jalan'), $file_surat);
            File::delete('assets/file-surat-jalan/' . $surat_Jalan->file_surat);
        } else {
            $file_surat = $surat_Jalan->file_surat;
        }

        Surat_Jalan::where('no_surat_jalan', $no_surat_Jalan)->update([
            'id_projek' => $surat_Jalan->id_projek,
            'keterangan' => $request->keterangan,
            'tgl_surat' => $request->tgl_surat,
            'file_surat' => $file_surat,
        ]);

        return redirect()->route('projek.show', $surat_Jalan->id_projek)->with('toast_success', 'Berhasil Ubah Surat Jalan');
    }
}
