<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Laporan_Foto extends Model
{
    use HasFactory;

    protected $table = 'laporan_foto';
    protected $primaryKey = 'id_foto';
    public $timestamps = false;

    protected $fillable = [
        'id_foto',
        'id_laporan_pekerjaan',
        'foto',
    ];

    public function laporan_pekerjaan()
    {
        return $this->belongsTo(Laporan_Pekerjaan::class, 'id_laporan_pekerjaan', 'id_laporan_pekerjaan');
    }
}
