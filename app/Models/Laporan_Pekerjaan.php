<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Laporan_Pekerjaan extends Model
{
    use HasFactory;

    protected $table = 'laporan_pekerjaan';
    protected $primaryKey = 'id_laporan_pekerjaan';
    public $timestamps = false;

    protected $fillable = [
        'id_laporan_pekerjaan',
        'id_projek',
        'id_schedule',
        'tgl',
        'jam_mulai',
        'jam_selesai',
        'bobot_actual',
        'bobot_schedule',
        'acwp',
        'bcwp',
        'bcws',
        'keterangan',
    ];

    public function laporan_pengeluaran()
    {
        return $this->hasMany(Laporan_pengeluaran::class, 'id_laporan_pekerjaan', 'id_laporan_pekerjaan');
    }

    public function laporan_foto()
    {
        return $this->hasMany(Laporan_Foto::class, 'id_laporan_pekerjaan', 'id_laporan_pekerjaan');
    }

    public function projek()
    {
        return $this->belongsTo(Projek::class, 'id_projek', 'id_projek');
    }

    public function schedule()
    {
        return $this->belongsTo(Schedule::class, 'id_schedule', 'id_schedule');
    }
}
