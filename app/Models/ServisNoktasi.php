<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServisNoktasi extends Model
{
    protected $table = 'servis_noktalari';

    protected $fillable = [
        'ad',
        'sehir',
        'kategori',
        'logo',
        'sira',
        'aktif',
    ];

    protected $casts = [
        'aktif' => 'boolean',
    ];

    public function scopeAktif($query)
    {
        return $query->where('aktif', true)->orderBy('sira');
    }
}
