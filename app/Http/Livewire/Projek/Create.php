<?php

namespace App\Http\Livewire\Projek;

use App\Models\Pegawai;
use App\Models\Projek;
use App\Models\Projek_Pegawai;
use App\Models\Vendor;
use App\Models\Vendor_PT;
use Illuminate\Support\Facades\File;
use Livewire\Component;
use Livewire\WithFileUploads;

class Create extends Component
{
    use WithFileUploads;

    public $no_kontrak, $nama, $id_vendor_pt, $tgl_kontrak, $tgl_mulai, $tgl_selesai, $durasi_kontrak, $nilai_kontrak, $file_izin_kerja, $file_kontrak, $approved_by;

    public $projek_pegawai = [];

    public function mount()
    {
        $this->projek_pegawai[] = [
            'id_pegawai' => null,
        ];
    }

    public function render()
    {
        return view('livewire.projek.create', [
            'data_vendor_pt' => Vendor_PT::all(),
            'data_pegawai' => Pegawai::where('id_jabatan', 1)->get(),
            'data_projek_pegawai' => Pegawai::where('id_user', '!=', null)->get(),
        ]);
    }

    public function tambah_pegawai()
    {
        $this->projek_pegawai[] = [
            'id_pegawai' => null,
        ];
    }

    public function hapus_pegawai($index)
    {
        unset($this->projek_pegawai[$index]);
        $this->projek_pegawai = array_values($this->projek_pegawai);
    }

    public function save()
    {
        $this->validate([
            'no_kontrak' => 'required|unique:projek,no_kontrak',
            'nama' => 'required',
            'id_vendor_pt' => 'required',
            'tgl_kontrak' => 'required|date',
            'tgl_mulai' => 'required|date',
            'tgl_selesai' => 'required|date',
            'durasi_kontrak' => 'required|numeric',
            'nilai_kontrak' => 'required|numeric',
            'file_izin_kerja' => 'required|mimes:png,jpeg,jpg|max:2048',
            'file_kontrak' => 'required|mimes:png,jpeg,jpg|max:2048',
            'approved_by' => 'required',
        ]);

        foreach ($this->projek_pegawai as $index => $row) {
            $this->validate([
                'projek_pegawai.' . $index . '.id_pegawai' => 'required',
            ], [
                'projek_pegawai.' . $index . '.id_pegawai.required' => 'Wajib Isi',
            ]);
        }

        if ($this->file_izin_kerja !== null) {
            $file_izin_kerja = 'Izin-Kerja-' . time() . '.' . $this->file_izin_kerja->extension();
            $this->file_izin_kerja->storeAs('public/projek', $file_izin_kerja);
            File::move('storage/projek/' . $file_izin_kerja, 'assets/projek/' . $file_izin_kerja);
        }

        if ($this->file_kontrak !== null) {
            $file_kontrak = 'Kontrak-' . time() . '.' . $this->file_kontrak->extension();
            $this->file_kontrak->storeAs('public/projek', $file_kontrak);
            File::move('storage/projek/' . $file_kontrak, 'assets/projek/' . $file_kontrak);
        }

        $projek = Projek::create([
            'no_kontrak' => $this->no_kontrak,
            'nama' => ucwords($this->nama),
            'id_vendor_pt' => $this->id_vendor_pt,
            'tgl_kontrak' => $this->tgl_kontrak,
            'tgl_mulai' => $this->tgl_mulai,
            'tgl_selesai' => $this->tgl_selesai,
            'durasi_kontrak' => $this->durasi_kontrak,
            'nilai_kontrak' => $this->nilai_kontrak,
            'file_izin_kerja' => $file_izin_kerja,
            'file_kontrak' => $file_kontrak,
            'approved_by' => $this->approved_by,
            'id_status' => 1,
        ]);

        foreach ($this->projek_pegawai as $row) {
            Projek_Pegawai::create([
                'id_projek' => $projek->id_projek,
                'id_pegawai' => $row['id_pegawai'],
            ]);
        }

        session()->flash('toast_success', 'Berhasil Menambahkan Projek Baru');
        return redirect()->route('projek.index');
    }
}
