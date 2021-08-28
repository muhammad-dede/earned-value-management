<?php

namespace App\Http\Livewire\Projek;

use App\Models\Earned_Value;
use App\Models\Laporan_Foto;
use App\Models\Laporan_Pekerjaan;
use App\Models\Laporan_Pengeluaran;
use App\Models\Ref_Satuan;
use App\Models\Schedule;
use Illuminate\Support\Facades\File;
use Livewire\Component;
use Livewire\WithFileUploads;

class Proses extends Component
{
    use WithFileUploads;
    public $nav = 'schedule';
    public $projek;

    public $modal_schedule = '';
    public $schedule = null;
    public $pekerjaan, $tgl_mulai, $tgl_selesai, $biaya, $bobot_actual, $laporan_foto = [], $keterangan;

    public $modal_laporan = '';
    public $laporan_pekerjaan = null;
    public $id_schedule, $tgl, $jam_mulai, $jam_selesai;
    public $laporan_pengeluaran = [];

    public $detail_laporan_pekerjaan;
    public $data_laporan_pengeluaran = null;

    public function mount($projek)
    {
        $this->projek = $projek;
    }

    public function render()
    {
        return view('livewire.projek.proses', [
            'data_schedule' => Schedule::where('id_projek', $this->projek->id_projek)->get(),
            'data_laporan_pekerjaan' => Laporan_Pekerjaan::where('id_projek', $this->projek->id_projek)->get(),
            'data_satuan' => Ref_Satuan::all(),
        ]);
    }

    public function nav_schedule()
    {
        $this->nav = 'schedule';
    }

    public function nav_laporan()
    {
        $this->nav = 'laporan';
    }

    public function nav_surat_jalan()
    {
        $this->nav = 'surat-jalan';
    }

    public function tambah_schedule()
    {
        $this->schedule = null;
        $this->modal_schedule = 'Tambah Schedule';
        $this->pekerjaan = null;
        $this->tgl_mulai = null;
        $this->tgl_selesai = null;
        $this->biaya = null;
    }

    public function ubah_schedule(Schedule $schedule)
    {
        $this->schedule = $schedule;
        $this->modal_schedule = 'Ubah Schedule';
        $this->pekerjaan = $schedule->pekerjaan;
        $this->tgl_mulai = $schedule->tgl_mulai;
        $this->tgl_selesai = $schedule->tgl_selesai;
        $this->biaya = $schedule->biaya;
    }

    public function save_schedule()
    {
        $this->validate([
            'pekerjaan' => 'required',
            'tgl_mulai' => 'required',
            'tgl_selesai' => 'required',
            'biaya' => 'required',
        ]);

        if ($this->tgl_mulai == $this->tgl_selesai) {
            $durasi_hari = 1;
        } elseif ($this->tgl_mulai > $this->tgl_selesai) {
            return $this->dispatchBrowserEvent('swal', [
                'titleText'  => 'Tanggal mulai melebihi tanggal selesai',
                'icon' => 'warning',
            ]);
        } else {
            $durasi_hari = date_diff(date_create($this->tgl_mulai), date_create($this->tgl_selesai))->days + 1;
        }

        $bobot_total = ($this->biaya / $this->projek->nilai_kontrak) * 100;
        $bobot_hari = $bobot_total / $durasi_hari;

        if ($this->modal_schedule == 'Tambah Schedule') {
            $schedule = Schedule::create([
                'id_projek' => $this->projek->id_projek,
                'pekerjaan' => $this->pekerjaan,
                'tgl_mulai' => $this->tgl_mulai,
                'tgl_selesai' => $this->tgl_selesai,
                'durasi_hari' => $durasi_hari,
                'biaya' => $this->biaya,
                'bobot_total' => $bobot_total,
                'bobot_hari' => $bobot_hari,
            ]);

            Earned_Value::create([
                'id_projek' => $this->projek->id_projek,
                'id_schedule' => $schedule->id_schedule,
            ]);
        } else {
            Schedule::where('id_schedule', $this->schedule->id_schedule)->update([
                'id_projek' => $this->projek->id_projek,
                'pekerjaan' => $this->pekerjaan,
                'tgl_mulai' => $this->tgl_mulai,
                'tgl_selesai' => $this->tgl_selesai,
                'durasi_hari' => $durasi_hari,
                'biaya' => $this->biaya,
                'bobot_total' => $bobot_total,
                'bobot_hari' => $bobot_hari,
            ]);
        }

        $this->dispatchBrowserEvent('swal', [
            'titleText'  => $this->schedule == null ? 'Schedule Ditambahkan' : 'Schedule Diubah',
            'icon' => 'success',
            'toast' => true,
            'position' => 'top-end',
        ]);

        $this->emit('closeModal');
    }

    public function tambah_laporan()
    {
        $this->laporan_pekerjaan = null;
        $this->laporan_foto = [];
        $this->laporan_pengeluaran = [];
        $this->modal_laporan = 'Tambah Laporan';
        $this->id_schedule = null;
        $this->tgl = null;
        $this->jam_mulai = null;
        $this->jam_selesai = null;
        $this->bobot_actual = null;
        $this->keterangan = null;
        $this->laporan_foto[] = [
            'id_foto' => null,
            'id_laporan_pekerjaan' => null,
            'foto' => null,
            'input_foto' => null,
        ];

        $this->laporan_pengeluaran[] = [
            'id_laporan_pengeluaran' => null,
            'id_projek' => null,
            'id_laporan_pekerjaan' => null,
            'rincian' => null,
            'id_satuan' => null,
            'qty' => null,
            'biaya' => null,
        ];
    }

    public function ubah_laporan(Laporan_Pekerjaan $laporan_pekerjaan)
    {
        $this->laporan_pekerjaan = $laporan_pekerjaan;
        $this->laporan_foto = [];
        $this->laporan_pengeluaran = [];
        $this->modal_laporan = 'Ubah Laporan';
        $this->id_schedule = $laporan_pekerjaan->id_schedule;
        $this->tgl = $laporan_pekerjaan->tgl;
        $this->jam_mulai = $laporan_pekerjaan->jam_mulai;
        $this->jam_selesai = $laporan_pekerjaan->jam_selesai;
        $this->bobot_actual = $laporan_pekerjaan->bobot_actual;
        $this->keterangan = $laporan_pekerjaan->keterangan;

        foreach ($laporan_pekerjaan->laporan_foto as $foto) {
            $this->laporan_foto[] = [
                'id_foto' => $foto->id_foto,
                'id_laporan_pekerjaan' => $foto->id_laporan_pekerjaan,
                'foto' => $foto->foto,
                'input_foto' => null,
            ];
        }

        foreach ($laporan_pekerjaan->laporan_pengeluaran as $laporan_pengeluaran) {
            # code...
            $this->laporan_pengeluaran[] = [
                'id_laporan_pengeluaran' => $laporan_pengeluaran->id_laporan_pengeluaran,
                'id_projek' => $laporan_pengeluaran->id_projek,
                'id_laporan_pekerjaan' => $laporan_pengeluaran->id_laporan_pekerjaan,
                'rincian' => $laporan_pengeluaran->rincian,
                'id_satuan' => $laporan_pengeluaran->id_satuan,
                'qty' => $laporan_pengeluaran->qty,
                'biaya' => $laporan_pengeluaran->biaya,
            ];
        }
    }

    public function tambah_laporan_foto()
    {
        $this->laporan_foto[] = [
            'id_foto' => null,
            'id_laporan_pekerjaan' => null,
            'foto' => null,
            'input_foto' => null,
        ];
    }

    public function hapus_laporan_foto($index)
    {
        if ($this->laporan_foto[$index]['id_foto'] !== null) {
            File::delete('assets/laporan-foto/' . $this->laporan_foto[$index]['foto']);
            Laporan_Foto::where('id_foto', $this->laporan_foto[$index]['id_foto'])->delete();
        }
        unset($this->laporan_foto[$index]);
        $this->laporan_foto = array_values($this->laporan_foto);
    }

    public function hapus_laporan(Laporan_Pekerjaan $laporan)
    {
        $laporan->delete();
        $this->dispatchBrowserEvent('swal', [
            'titleText'  => 'Laporan Pekerjan Dihapus',
            'icon' => 'success',
            'toast' => true,
            'position' => 'top-end',
        ]);
    }

    public function tambah_laporan_pengeluaran()
    {
        $this->laporan_pengeluaran[] = [
            'id_laporan_pengeluaran' => null,
            'id_projek' => null,
            'id_laporan_pekerjaan' => null,
            'rincian' => null,
            'id_satuan' => null,
            'qty' => null,
            'biaya' => null,
        ];
    }

    public function hapus_laporan_pengeluaran($index)
    {
        if ($this->laporan_pengeluaran[$index]['id_laporan_pengeluaran'] !== null) {
            # code...
            Laporan_Pengeluaran::where('id_laporan_pengeluaran', $this->laporan_pengeluaran[$index]['id_laporan_pengeluaran'])->delete();
        }
        unset($this->laporan_pengeluaran[$index]);
        $this->laporan_pengeluaran = array_values($this->laporan_pengeluaran);
    }

    public function detail_laporan(Laporan_Pekerjaan $pekerjaan)
    {
        $this->detail_laporan_pekerjaan = $pekerjaan;
        $this->data_laporan_pengeluaran = Laporan_Pengeluaran::where('id_laporan_pekerjaan', $pekerjaan->id_laporan_pekerjaan)->get();
    }

    public function save_laporan()
    {
        $this->validate([
            'id_schedule' => 'required',
            'tgl' => 'required',
            'jam_mulai' => 'required',
            'jam_selesai' => 'required',
            'bobot_actual' => 'required|numeric',
            'keterangan' => 'required',
        ]);

        if ($this->laporan_pengeluaran == []) {
            return $this->dispatchBrowserEvent('swal', [
                'titleText'  => 'Laporan Pengeluaran Wajib Diisi',
                'icon' => 'warning',
            ]);
        }

        foreach ($this->laporan_foto as $index => $foto) {
            if ($foto['id_foto'] == null) {
                $this->validate([
                    'laporan_foto.' . $index . '.input_foto' => 'required|mimes:jpeg,jpg,png|max:2048',
                ]);
            }
        }

        foreach ($this->laporan_pengeluaran as $index => $row) {
            $this->validate([
                'laporan_pengeluaran.' . $index . '.rincian' => 'required',
                'laporan_pengeluaran.' . $index . '.id_satuan' => 'required',
                'laporan_pengeluaran.' . $index . '.qty' => 'required',
                'laporan_pengeluaran.' . $index . '.biaya' => 'required',
            ], [
                'laporan_pengeluaran.' . $index . '.rincian.required' => 'Wajib Isi',
                'laporan_pengeluaran.' . $index . '.id_satuan.required' => 'Wajib Isi',
                'laporan_pengeluaran.' . $index . '.qty.required' => 'Wajib Isi',
                'laporan_pengeluaran.' . $index . '.biaya.required' => 'Wajib Isi',
            ]);
        }

        if ($this->modal_laporan == 'Tambah Laporan') {
            $laporan_pekerjaan = Laporan_Pekerjaan::create([
                'id_projek' => $this->projek->id_projek,
                'id_schedule' => $this->id_schedule,
                'tgl' => $this->tgl,
                'jam_mulai' => $this->jam_mulai,
                'jam_selesai' => $this->jam_selesai,
                'bobot_actual' => $this->bobot_actual,
                'keterangan' => $this->keterangan,
            ]);

            foreach ($this->laporan_foto as $index => $laporan_foto) {
                if ($laporan_foto['input_foto'] !== null) {
                    $foto = time() . $index . '.' . $laporan_foto['input_foto']->extension();
                    $laporan_foto['input_foto']->storeAs('public/laporan-foto', $foto);
                    File::move('storage/laporan-foto/' . $foto, 'assets/laporan-foto/' . $foto);
                } else {
                    $foto = null;
                }

                Laporan_Foto::create([
                    'id_laporan_pekerjaan' => $laporan_pekerjaan->id_laporan_pekerjaan,
                    'foto' => $foto,
                ]);
            }

            foreach ($this->laporan_pengeluaran as $laporan_pengeluaran) {
                Laporan_Pengeluaran::create([
                    'id_projek' => $this->projek->id_projek,
                    'id_laporan_pekerjaan' => $laporan_pekerjaan->id_laporan_pekerjaan,
                    'rincian' => $laporan_pengeluaran['rincian'],
                    'id_satuan' => $laporan_pengeluaran['id_satuan'],
                    'qty' => $laporan_pengeluaran['qty'],
                    'biaya' => $laporan_pengeluaran['biaya'],
                    'total_biaya' => $laporan_pengeluaran['qty'] * $laporan_pengeluaran['biaya'],
                ]);
            }

            $schedule = Schedule::where('id_schedule', $laporan_pekerjaan->id_schedule)->first();
            // menentukan nilai bobot_schedule
            $bobot_schedule = $schedule->bobot_hari;
            $acwp = Laporan_Pengeluaran::where('id_laporan_pekerjaan', $laporan_pekerjaan->id_laporan_pekerjaan)->sum('total_biaya');
            $bcwp = ($this->projek->nilai_kontrak / 100) * $this->bobot_actual;
            $bcws = ($this->projek->nilai_kontrak / 100) * $bobot_schedule;

            $laporan_pekerjaan->update([
                'bobot_schedule' => $bobot_schedule,
                'acwp' => $acwp,
                'bcwp' => $bcwp,
                'bcws' => $bcws,
            ]);

            $bobot_actual_kum = Laporan_Pekerjaan::where('id_schedule', $schedule->id_schedule)->sum('bobot_actual');
            $bobot_schedule_kum = Laporan_Pekerjaan::where('id_schedule', $schedule->id_schedule)->sum('bobot_schedule');
            $acwp_kum = Laporan_Pekerjaan::where('id_schedule', $schedule->id_schedule)->sum('acwp');
            $bcwp_kum = Laporan_Pekerjaan::where('id_schedule', $schedule->id_schedule)->sum('bcwp');
            $bcws_kum = Laporan_Pekerjaan::where('id_schedule', $schedule->id_schedule)->sum('bcws');

            $jumlah_hari_pengerjaan = Laporan_Pekerjaan::where('id_projek', $this->projek->id_projek)->count();

            $cv = $bcwp_kum - $acwp_kum;
            $sv = $bcwp_kum - $bcws_kum;
            $cpi = $bcwp_kum / $acwp_kum;
            $spi = $bcwp_kum / $bcws_kum;
            $etc = ($this->projek->nilai_kontrak - $bcwp_kum) / $cpi;
            $eac = $acwp_kum + $etc;
            $te = $jumlah_hari_pengerjaan + (($this->projek->durasi_kontrak - ($jumlah_hari_pengerjaan * $spi)) / $spi);

            Earned_Value::where('id_schedule', $schedule->id_schedule)->where('id_projek', $this->projek->id_projek)->update([
                'bobot_actual_kum' => $bobot_actual_kum,
                'bobot_schedule_kum' => $bobot_schedule_kum,
                'acwp_kum' => $acwp_kum,
                'bcwp_kum' => $bcwp_kum,
                'bcws_kum' => $bcws_kum,
                'cv' => $cv,
                'sv' => $sv,
                'cpi' => $cpi,
                'spi' => $spi,
                'etc' => $etc,
                'eac' => $eac,
                'te' => $te,
            ]);
        } else {
            Laporan_Pekerjaan::where('id_laporan_pekerjaan', $this->laporan_pekerjaan->id_laporan_pekerjaan)->update([
                'id_projek' => $this->projek->id_projek,
                'id_schedule' => $this->id_schedule,
                'tgl' => $this->tgl,
                'jam_mulai' => $this->jam_mulai,
                'jam_selesai' => $this->jam_selesai,
                'bobot_actual' => $this->bobot_actual,
                'keterangan' => $this->keterangan,
            ]);

            foreach ($this->laporan_foto as $index => $laporan_foto) {
                if ($laporan_foto['input_foto'] !== null) {
                    $foto = time() . $index . '.' . $laporan_foto['input_foto']->extension();
                    $laporan_foto['input_foto']->storeAs('public/laporan-foto', $foto);
                    File::move('storage/laporan-foto/' . $foto, 'assets/laporan-foto/' . $foto);
                    File::delete('assets/laporan-foto/' . $laporan_foto['foto']);
                } else {
                    $foto = $laporan_foto['foto'];
                }

                if ($laporan_foto['id_foto'] == null) {
                    Laporan_Foto::create([
                        'id_laporan_pekerjaan' => $this->laporan_pekerjaan->id_laporan_pekerjaan,
                        'foto' => $foto,
                    ]);
                } else {
                    Laporan_Foto::where('id_foto', $laporan_foto['id_foto'])->update([
                        'id_laporan_pekerjaan' => $this->laporan_pekerjaan->id_laporan_pekerjaan,
                        'foto' => $foto,
                    ]);
                }
            }

            foreach ($this->laporan_pengeluaran as $laporan_pengeluaran) {
                if ($laporan_pengeluaran['id_laporan_pengeluaran'] == null) {
                    Laporan_Pengeluaran::create([
                        'id_projek' => $this->projek->id_projek,
                        'id_laporan_pekerjaan' => $this->laporan_pekerjaan->id_laporan_pekerjaan,
                        'rincian' => $laporan_pengeluaran['rincian'],
                        'id_satuan' => $laporan_pengeluaran['id_satuan'],
                        'qty' => $laporan_pengeluaran['qty'],
                        'biaya' => $laporan_pengeluaran['biaya'],
                        'total_biaya' => $laporan_pengeluaran['qty'] * $laporan_pengeluaran['biaya'],
                    ]);
                } else {
                    Laporan_Pengeluaran::where('id_laporan_pengeluaran', $laporan_pengeluaran['id_laporan_pengeluaran'])->update([
                        'id_projek' => $laporan_pengeluaran['id_projek'],
                        'id_laporan_pekerjaan' => $laporan_pengeluaran['id_laporan_pekerjaan'],
                        'rincian' => $laporan_pengeluaran['rincian'],
                        'id_satuan' => $laporan_pengeluaran['id_satuan'],
                        'qty' => $laporan_pengeluaran['qty'],
                        'biaya' => $laporan_pengeluaran['biaya'],
                        'total_biaya' => $laporan_pengeluaran['qty'] * $laporan_pengeluaran['biaya'],
                    ]);
                }
            }

            $schedule = Schedule::where('id_schedule', $this->laporan_pekerjaan->id_schedule)->first();
            // menentukan nilai bobot_schedule
            $bobot_schedule = $schedule->bobot_hari;
            $acwp = Laporan_Pengeluaran::where('id_laporan_pekerjaan', $this->laporan_pekerjaan->id_laporan_pekerjaan)->sum('total_biaya');
            $bcwp = ($this->projek->nilai_kontrak / 100) * $this->bobot_actual;
            $bcws = ($this->projek->nilai_kontrak / 100) * $bobot_schedule;

            Laporan_Pekerjaan::where('id_laporan_pekerjaan', $this->laporan_pekerjaan->id_laporan_pekerjaan)->update([
                'bobot_schedule' => $bobot_schedule,
                'acwp' => $acwp,
                'bcwp' => $bcwp,
                'bcws' => $bcws,
            ]);

            $bobot_actual_kum = Laporan_Pekerjaan::where('id_schedule', $schedule->id_schedule)->sum('bobot_actual');
            $bobot_schedule_kum = Laporan_Pekerjaan::where('id_schedule', $schedule->id_schedule)->sum('bobot_schedule');
            $acwp_kum = Laporan_Pekerjaan::where('id_schedule', $schedule->id_schedule)->sum('acwp');
            $bcwp_kum = Laporan_Pekerjaan::where('id_schedule', $schedule->id_schedule)->sum('bcwp');
            $bcws_kum = Laporan_Pekerjaan::where('id_schedule', $schedule->id_schedule)->sum('bcws');

            $jumlah_hari_pengerjaan = Laporan_Pekerjaan::where('id_projek', $this->projek->id_projek)->count();

            $cv = $bcwp_kum - $acwp_kum;
            $sv = $bcwp_kum - $bcws_kum;
            $cpi = $bcwp_kum / $acwp_kum;
            $spi = $bcwp_kum / $bcws_kum;
            $etc = ($this->projek->nilai_kontrak - $bcwp_kum) / $cpi;
            $eac = $acwp_kum + $etc;
            $te = $jumlah_hari_pengerjaan + (($this->projek->durasi_kontrak - ($jumlah_hari_pengerjaan * $spi)) / $spi);

            Earned_Value::where('id_schedule', $schedule->id_schedule)->where('id_projek', $this->projek->id_projek)->update([
                'bobot_actual_kum' => $bobot_actual_kum,
                'bobot_schedule_kum' => $bobot_schedule_kum,
                'acwp_kum' => $acwp_kum,
                'bcwp_kum' => $bcwp_kum,
                'bcws_kum' => $bcws_kum,
                'cv' => $cv,
                'sv' => $sv,
                'cpi' => $cpi,
                'spi' => $spi,
                'etc' => $etc,
                'eac' => $eac,
                'te' => $te,
            ]);
        }

        $this->dispatchBrowserEvent('swal', [
            'titleText'  => $this->modal_laporan == 'Tambah Laporan' ? 'Laporan Ditambahkan' : 'Laporan Diubah',
            'icon' => 'success',
            'toast' => true,
            'position' => 'top-end',
        ]);

        $this->emit('closeModal');
    }
}
