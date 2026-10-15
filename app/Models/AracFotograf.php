<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AracFotograf extends Model
{
    protected $table = 'arac_fotograflar';

    protected $fillable = ['arac_id', 'dosya_yolu', 'alt_metin', 'kapak', 'sira'];

    protected $casts = ['kapak' => 'boolean'];

    public function arac()
    {
        return $this->belongsTo(Arac::class, 'arac_id');
    }
}
