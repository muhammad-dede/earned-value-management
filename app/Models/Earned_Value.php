<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Earned_Value extends Model
{
    use HasFactory;

    protected $table = 'earned_value';
    protected $primaryKey = 'id_earned_value';
    public $timestamps = false;

    protected $fillable = [
        'id_earned_value',
        'id_projek',
        'id_schedule',
        'bobot_actual_kum',
        'bobot_schedule_kum',
        'acwp_kum',
        'bcwp_kum',
        'bcws_kum',
        'cv',
        'sv',
        'cpi',
        'spi',
        'etc',
        'eac',
        'te',
    ];

    public function projek()
    {
        return $this->belongsTo(Projek::class, 'id_projek', 'id_projek');
    }

    public function schedule()
    {
        return $this->belongsTo(Schedule::class, 'id_schedule', 'id_schedule');
    }
}
