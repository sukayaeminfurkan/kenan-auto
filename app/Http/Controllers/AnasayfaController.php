<?php

namespace App\Http\Controllers;

use App\Models\Arac;
use App\Models\ServisNoktasi;

class AnasayfaController extends Controller
{
    public function index()
    {
        $servisNoktalari = ServisNoktasi::aktif()->get();

        $oneCikanAraclar = Arac::with(['kapakFoto', 'marka', 'aracModel', 'paket'])
            ->where('one_cikan', true)
            ->where('aktif', true)
            ->orderBy('sira')
            ->take(8)
            ->get();

        return view('welcome', compact('servisNoktalari', 'oneCikanAraclar'));
    }
}
