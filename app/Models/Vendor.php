<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Vendor extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'vendor';
    protected $primaryKey = 'id_vendor';
    public $timestamps = false;

    protected $fillable = [
        'id_vendor',
        'id_vendor_pt',
        'nama',
        'telp',
        'id_user',
    ];

    public function vendor_pt()
    {
        return $this->belongsTo(Vendor_PT::class, 'id_vendor_pt', 'id_vendor_pt');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id');
    }

    public function projek()
    {
        return $this->hasMany(Projek::class, 'id_vendor', 'id_vendor');
    }
}
