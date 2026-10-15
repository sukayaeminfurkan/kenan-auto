<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Marka extends Model
{
    protected $table = 'markalar';

    protected $fillable = ['ad', 'slug', 'aktif', 'sira'];

    protected $casts = ['aktif' => 'boolean'];

    public function modeller()
    {
        return $this->hasMany(AracModel::class, 'marka_id')->orderBy('ad');
    }

    public function araclar()
    {
        return $this->hasMany(Arac::class, 'marka_id');
    }
}
