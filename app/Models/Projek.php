<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Projek extends Model
{
    use HasFactory;

    protected $table = 'projek';
    protected $primaryKey = 'id_projek';
    public $timestamps = false;

    protected $fillable = [
        'id_projek',
        'id_vendor_pt',
        'no_kontrak',
        'nama',
        'tgl_kontrak',
        'tgl_mulai',
        'tgl_selesai',
        'durasi_kontrak',
        'nilai_kontrak',
        'file_izin_kerja',
        'file_kontrak',
        'approved_by',
        'id_status',
    ];

    public function vendor_pt()
    {
        return $this->belongsTo(Vendor_PT::class, 'id_vendor_pt', 'id_vendor_pt');
    }

    public function approve()
    {
        return $this->belongsTo(Pegawai::class, 'approved_by', 'id_pegawai');
    }

    public function status()
    {
        return $this->belongsTo(Ref_Status::class, 'id_status', 'id_status');
    }

    public function plan()
    {
        return $this->hasMany(_Plan::class, 'id_projek', 'id_projek');
    }

    public function earned_value()
    {
        return $this->hasMany(Earned_Value::class, 'id_projek', 'id_projek');
    }

    public function actual()
    {
        return $this->hasMany(_Actual::class, 'id_projek', 'id_projek');
    }

    public function projek_pegawai()
    {
        return $this->hasMany(Projek_Pegawai::class, 'id_projek', 'id_projek');
    }

    public function laporan_pekerjaan()
    {
        return $this->hasMany(Laporan_Pekerjaan::class, 'id_projek', 'id_projek');
    }

    public function surat_jalan()
    {
        return $this->hasMany(Surat_Jalan::class, 'id_projek', 'id_projek');
    }
}
