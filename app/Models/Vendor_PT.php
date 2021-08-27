<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Vendor_PT extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'vendor_pt';
    protected $primaryKey = 'id_vendor_pt';
    public $timestamps = false;

    protected $fillable = [
        'id_vendor_pt',
        'vendor',
        'alamat',
        'telp',
        'logo',
    ];

    public function vendor()
    {
        return $this->hasMany(Vendor::class, 'id_vendor_pt', 'id_vendor_pt');
    }
}
