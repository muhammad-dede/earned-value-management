<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ref_Satuan extends Model
{
    use HasFactory;

    protected $table = 'ref_satuan';
    protected $primaryKey = 'id_satuan';
    public $timestamps = false;

    protected $fillable = [
        'id_satuan',
        'satuan',
    ];
}
