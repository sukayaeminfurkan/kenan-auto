<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Arac extends Model
{
    protected $table = 'araclar';

    protected $fillable = [
        'marka_id', 'model_id', 'paket_id', 'baslik', 'seri', 'yil', 'kilometre', 'fiyat',
        'renk', 'yakit_turu', 'vites_turu', 'kasa_tipi',
        'motor_hacmi', 'motor_gucu', 'cekis', 'durum',
        'aciklama', 'ozellikler', 'slug', 'goruntuleme_sayisi',
        'aktif', 'one_cikan', 'sira',
    ];

    protected $casts = [
        'aktif'     => 'boolean',
        'one_cikan' => 'boolean',
        'fiyat'     => 'integer',
    ];

    public function marka()
    {
        return $this->belongsTo(Marka::class, 'marka_id');
    }

    public function paket()
    {
        return $this->belongsTo(Paket::class, 'paket_id');
    }

    public function aracModel()
    {
        return $this->belongsTo(AracModel::class, 'model_id');
    }

    public function fotograflar()
    {
        return $this->hasMany(AracFotograf::class, 'arac_id');
    }

    public function kapakFoto()
    {
        return $this->hasOne(AracFotograf::class, 'arac_id')
            ->where('kapak', true)
            ->orderBy('sira');
    }
}
