<?php

namespace App\Http\Controllers\Aplikasi\Admin;

use App\Http\Controllers\Controller;
use App\Models\Laporan_Pekerjaan;
use App\Models\Laporan_Pengeluaran;
use App\Models\Projek;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class ProjekController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
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

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = [
            'title' => 'Tambah Projek',
            'menu' => 'projek',
            'sub_menu' => 'projek',
        ];
        return view('app.admin.projek.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
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

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
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

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
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
            'title' => 'Detail Laporan Pengeluaran',
            'menu' => 'projek',
            'sub_menu' => 'projek',
            'data_laporan_pengeluaran' => Laporan_Pengeluaran::where('id_laporan_pekerjaan', $laporan_pekerjaan->id_laporan_pekerjaan)->get(),
            'laporan_pekerjaan' => $laporan_pekerjaan,
        ]);
    }
}
