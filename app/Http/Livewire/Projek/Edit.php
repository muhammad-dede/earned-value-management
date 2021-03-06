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

class Edit extends Component
{
    use WithFileUploads;

    public $projek;

    public $no_kontrak, $nama, $id_vendor_pt, $tgl_kontrak, $tgl_mulai, $tgl_selesai, $durasi_kontrak, $nilai_kontrak, $file_izin_kerja, $file_kontrak, $approved_by;

    public $projek_pegawai = [];

    public function mount($projek)
    {
        $this->projek = $projek;
        $this->no_kontrak = $projek->no_kontrak;
        $this->nama = $projek->nama;
        $this->id_vendor_pt = $projek->id_vendor_pt;
        $this->tgl_kontrak = $projek->tgl_kontrak;
        $this->tgl_mulai = $projek->tgl_mulai;
        $this->tgl_selesai = $projek->tgl_selesai;
        $this->durasi_kontrak = $projek->durasi_kontrak;
        $this->nilai_kontrak = $projek->nilai_kontrak;
        $this->approved_by = $projek->approved_by;

        foreach ($this->projek->projek_pegawai as $row) {
            $this->projek_pegawai[] = [
                'id_projek_pegawai' => $row->id_projek_pegawai,
                'id_projek' => $row->id_projek,
                'id_pegawai' => $row->id_pegawai,
            ];
        }
    }

    public function render()
    {
        return view('livewire.projek.edit', [
            'data_vendor_pt' => Vendor_PT::all(),
            'data_pegawai' => Pegawai::where('id_jabatan', 1)->get(),
            'data_projek_pegawai' => Pegawai::where('id_user', '!=', null)->get(),
        ]);
    }

    public function tambah_pegawai()
    {
        $this->projek_pegawai[] = [
            'id_projek_pegawai' => null,
            'id_projek' => $this->projek->id_projek,
            'id_pegawai' => null,
        ];
    }

    public function hapus_pegawai($index)
    {
        Projek_Pegawai::where('id_projek_pegawai', $this->projek_pegawai[$index]['id_projek_pegawai'])->delete();
        unset($this->projek_pegawai[$index]);
        $this->projek_pegawai = array_values($this->projek_pegawai);
    }

    public function save()
    {
        $this->validate([
            'no_kontrak' => 'required|unique:projek,no_kontrak,' . $this->projek->id_projek . ',id_projek',
            'nama' => 'required',
            'id_vendor_pt' => 'required',
            'tgl_kontrak' => 'required|date',
            'tgl_mulai' => 'required|date',
            'tgl_selesai' => 'required|date',
            'durasi_kontrak' => 'required|numeric',
            'nilai_kontrak' => 'required|numeric',
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
            $this->validate([
                'file_izin_kerja' => 'required|mimes:png,jpeg,jpg|max:2048',
            ]);

            $file_izin_kerja = 'Izin-Kerja-' . time() . '.' . $this->file_izin_kerja->extension();
            $this->file_izin_kerja->storeAs('public/projek', $file_izin_kerja);
            File::move('storage/projek/' . $file_izin_kerja, 'assets/projek/' . $file_izin_kerja);
            File::delete('assets/projek/' . $this->projek->file_izin_kerja);
        } else {
            $file_izin_kerja = $this->projek->file_izin_kerja;
        }

        if ($this->file_kontrak !== null) {
            $this->validate([
                'file_kontrak' => 'required|mimes:png,jpeg,jpg|max:2048',
            ]);

            $file_kontrak = 'Kontrak-' . time() . '.' . $this->file_kontrak->extension();
            $this->file_kontrak->storeAs('public/projek', $file_kontrak);
            File::move('storage/projek/' . $file_kontrak, 'assets/projek/' . $file_kontrak);
            File::delete('assets/projek/' . $this->projek->file_kontrak);
        } else {
            $file_kontrak = $this->projek->file_kontrak;
        }

        Projek::where('id_projek', $this->projek->id_projek)->update([
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
        ]);

        foreach ($this->projek_pegawai as $row) {
            if ($row['id_projek_pegawai'] == null) {
                Projek_Pegawai::create([
                    'id_projek' => $row['id_projek'],
                    'id_pegawai' => $row['id_pegawai'],
                ]);
            } else {
                Projek_Pegawai::where('id_projek_pegawai', $row['id_projek_pegawai'])->update([
                    'id_projek' => $row['id_projek'],
                    'id_pegawai' => $row['id_pegawai'],
                ]);
            }
        }

        session()->flash('toast_success', 'Berhasil Menambahkan Projek Baru');
        return redirect()->route('projek.index');
    }
}
