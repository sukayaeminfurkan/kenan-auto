<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AracModel extends Model
{
    protected $table = 'modeller';

    protected $fillable = ['marka_id', 'ad', 'slug', 'aktif'];

    protected $casts = ['aktif' => 'boolean'];

    public function marka()
    {
        return $this->belongsTo(Marka::class, 'marka_id');
    }

    public function araclar()
    {
        return $this->hasMany(Arac::class, 'model_id');
    }

    public function paketler()
    {
        return $this->hasMany(Paket::class, 'model_id');
    }
}
