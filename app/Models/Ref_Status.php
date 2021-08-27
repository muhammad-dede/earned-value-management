<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ref_Status extends Model
{
    use HasFactory;

    protected $table = 'ref_status';
    protected $primaryKey = 'id_status';
    public $timestamps = false;

    protected $fillable = [
        'id_status',
        'status',
        'color',
    ];
}
