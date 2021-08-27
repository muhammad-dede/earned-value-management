<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pegawai extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'pegawai';
    protected $primaryKey = 'id_pegawai';
    public $timestamps = false;

    protected $fillable = [
        'id_pegawai',
        'nama',
        'jk',
        'tempat_lahir',
        'tgl_lahir',
        'alamat',
        'file_ktp',
        'file_asuransi',
        'file_foto',
        'id_jabatan',
        'id_user',
    ];

    public function ref_jabatan()
    {
        return $this->belongsTo(Ref_Jabatan::class, 'id_jabatan', 'id_jabatan');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id');
    }
}
