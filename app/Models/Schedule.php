<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory;

    protected $table = 'schedule';
    protected $primaryKey = 'id_schedule';
    public $timestamps = false;

    protected $fillable = [
        'id_schedule',
        'id_projek',
        'pekerjaan',
        'tgl_mulai',
        'tgl_selesai',
        'durasi_hari',
        'biaya',
        'bobot_total',
        'bobot_hari',
    ];

    public function projek()
    {
        return $this->belongsTo(Projek::class, 'id_projek', 'id_projek');
    }

    public function earned_value()
    {
        return $this->hasMany(Earned_Value::class, 'id_schedule', 'id_schedule');
    }

    public function laporan_pekerjaan()
    {
        return $this->hasMany(Laporan_Pekerjaan::class, 'id_schedule', 'id_schedule');
    }
}
