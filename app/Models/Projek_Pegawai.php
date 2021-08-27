<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Projek_Pegawai extends Model
{
    use HasFactory;

    protected $table = 'projek_pegawai';
    protected $primaryKey = 'id_projek_pegawai';
    public $timestamps = false;

    protected $fillable = [
        'id_projek_pegawai',
        'id_projek',
        'id_pegawai',
    ];

    public function projek()
    {
        return $this->belongsTo(Projek::class, 'id_projek', 'id_projek');
    }

    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class, 'id_pegawai', 'id_pegawai');
    }
}
