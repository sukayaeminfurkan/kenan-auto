<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Paket extends Model
{
    protected $table = 'paketler';

    protected $fillable = [
        'model_id', 'ad', 'yakit_turu', 'vites_turu', 'motor_hacmi', 'motor_gucu', 'aktif',
    ];

    protected $casts = ['aktif' => 'boolean'];

    public function aracModel()
    {
        return $this->belongsTo(AracModel::class, 'model_id');
    }
}
