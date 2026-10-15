<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ServisNoktasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ServisNoktasiController extends Controller
{
    // Liste
    public function index()
    {
        $noktalari = ServisNoktasi::orderBy('sira')->get();
        return view('admin.servis-noktalari.index', compact('noktalari'));
    }

    // Yeni ekleme formu
    public function create()
    {
        return view('admin.servis-noktalari.form');
    }

    // Kaydet
    public function store(Request $request)
    {
        $request->validate([
            'ad'       => 'required|string|max:255',
            'sehir'    => 'nullable|string|max:255',
            'kategori' => 'nullable|string|max:255',
            'logo'     => 'nullable',
            'sira'     => 'nullable|integer',
        ]);

        $data = $request->only(['ad', 'sehir', 'kategori', 'sira']);
        $data['aktif'] = $request->has('aktif');

        if ($request->hasFile('logo')) {
            $data['logo'] = $request->file('logo')->store('servis-logolari', 'public');
        }

        ServisNoktasi::create($data);

        return redirect()->route('admin.servis.index')
            ->with('success', 'Servis noktası eklendi!');
    }

    // Düzenleme formu
    public function edit(ServisNoktasi $servis_noktasi)
    {
        return view('admin.servis-noktalari.form', ['servisNoktasi' => $servis_noktasi]);
    }

    public function update(Request $request, ServisNoktasi $servis_noktasi)
    {
        $request->validate([
            'ad'       => 'required|string|max:255',
            'sehir'    => 'nullable|string|max:255',
            'kategori' => 'nullable|string|max:255',
            'logo'     => 'nullable',
            'sira'     => 'nullable|integer',
        ]);

        $data = $request->only(['ad', 'sehir', 'kategori', 'sira']);
        $data['aktif'] = $request->has('aktif');

        if ($request->hasFile('logo')) {
            if ($servis_noktasi->logo) {
                Storage::disk('public')->delete($servis_noktasi->logo);
            }
            $data['logo'] = $request->file('logo')->store('servis-logolari', 'public');
        }

        $servis_noktasi->update($data);

        return redirect()->route('admin.servis.index')
            ->with('success', 'Servis noktası güncellendi!');
    }
    // Sil
    public function destroy(ServisNoktasi $servis_noktasi)
    {
        $servis_noktasi->delete();

        return redirect()->route('admin.servis.index')
            ->with('success', 'Servis noktası silindi!');
    }
}
