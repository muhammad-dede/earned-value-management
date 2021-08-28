<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Surat_Jalan extends Model
{
    use HasFactory;

    protected $table = 'surat_jalan';
    protected $primaryKey = 'no_surat_jalan';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'no_surat_jalan',
        'id_projek',
        'keterangan',
        'tgl_surat',
        'file_surat',
    ];

    public function projek()
    {
        return $this->belongsTo(Projek::class, 'id_projek', 'id_projek');
    }
}
