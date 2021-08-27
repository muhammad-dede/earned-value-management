<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Laporan_Pengeluaran extends Model
{
    use HasFactory;

    protected $table = 'laporan_pengeluaran';
    protected $primaryKey = 'id_laporan_pengeluaran';
    public $timestamps = false;

    protected $fillable = [
        'id_laporan_pengeluaran',
        'id_projek',
        'id_laporan_pekerjaan',
        'rincian',
        'id_satuan',
        'qty',
        'biaya',
        'total_biaya',
    ];

    public function laporan_pekerjaan()
    {
        return $this->belongsTo(Laporan_Pekerjaan::class, 'id_laporan_pekerjaan', 'id_laporan_pekerjaan');
    }

    public function ref_satuan()
    {
        return $this->belongsTo(Ref_Satuan::class, 'id_satuan', 'id_satuan');
    }

    public function projek()
    {
        return $this->belongsTo(Projek::class, 'id_projek', 'id_projek');
    }
}
