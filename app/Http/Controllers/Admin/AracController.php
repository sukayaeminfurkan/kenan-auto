<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Arac;
use App\Models\AracFotograf;
use App\Models\Marka;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AracController extends Controller
{
    public function index()
    {
        $araclar  = Arac::with('marka', 'aracModel')->orderByDesc('created_at')->paginate(15);
        $markalar = Marka::orderBy('sira')->get();
        return view('admin.araclar.index', compact('araclar', 'markalar'));
    }

    public function create()
    {
        return view('admin.araclar.form', ['arac' => new Arac]);
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        $data['slug'] = $this->makeSlug($data['marka_id'], $data['model_id'], $data['yil']);

        $arac = Arac::create($data);

        $this->fotograflariKaydet($request, $arac);

        return redirect()->route('admin.arac.index')->with('success', 'Araç başarıyla eklendi.');
    }

    public function show(Arac $arac)
    {
        return redirect()->route('admin.arac.edit', $arac);
    }

    public function edit(Arac $arac)
    {
        $arac->load('fotograflar');
        return view('admin.araclar.form', compact('arac'));
    }

    public function update(Request $request, Arac $arac)
    {
        $data = $this->validated($request);
        $data['slug'] = $this->makeSlug($data['marka_id'], $data['model_id'], $data['yil']);

        $arac->update($data);

        $this->fotograflariKaydet($request, $arac);

        return redirect()->route('admin.arac.edit', $arac)->with('success', 'Araç başarıyla güncellendi.');
    }

    public function destroy(Arac $arac)
    {
        foreach ($arac->fotograflar()->get() as $foto) {
            Storage::delete($foto->dosya_yolu);
        }
        $arac->fotograflar()->delete();
        $arac->delete();
        return redirect()->route('admin.arac.index')->with('success', 'Araç silindi.');
    }

    public function toggleOneCikan(Arac $arac)
    {
        $arac->update(['one_cikan' => !$arac->one_cikan]);
        $mesaj = $arac->fresh()->one_cikan ? 'Öne çıkanlara eklendi.' : 'Öne çıkanlardan kaldırıldı.';
        return back()->with('success', $mesaj);
    }

    public function fotografSil(AracFotograf $foto)
    {
        $arac = $foto->arac;
        Storage::disk('public')->delete($foto->dosya_yolu);
        $wasKapak = $foto->kapak;
        $foto->delete();

        // Silinen kapaksa bir sonrakini kapak yap
        if ($wasKapak) {
            $ilk = $arac->fotograflar()->orderBy('sira')->first();
            $ilk?->update(['kapak' => true]);
        }

        return back()->with('success', 'Fotoğraf silindi.');
    }

    public function fotografKapakYap(AracFotograf $foto)
    {
        AracFotograf::where('arac_id', $foto->arac_id)->update(['kapak' => false]);
        $foto->update(['kapak' => true]);
        return back()->with('success', 'Kapak fotoğraf güncellendi.');
    }

    private function fotograflariKaydet(Request $request, Arac $arac): void
    {
        if (!$request->hasFile('fotograflar')) {
            return;
        }

        $request->validate([
            'fotograflar'   => 'array|max:10',
            'fotograflar.*' => 'image|mimes:jpg,jpeg,png,webp|max:5120',
        ]);

        $mevcutSayisi = $arac->fotograflar()->count();
        $kalanSlot    = 10 - $mevcutSayisi;
        $dosyalar     = array_slice($request->file('fotograflar'), 0, $kalanSlot);

        foreach ($dosyalar as $i => $dosya) {
            $yol = $dosya->store('araclar', 'public');

            $isKapak = ($mevcutSayisi === 0 && $i === 0);

            $arac->fotograflar()->create([
                'dosya_yolu' => $yol,
                'kapak'      => $isKapak,
                'sira'       => $mevcutSayisi + $i + 1,
            ]);
        }
    }

    private function validated(Request $request): array
    {
        $data = $request->validate([
            'marka_id'    => 'required|exists:markalar,id',
            'model_id'    => 'required|exists:modeller,id',
            'paket_id'    => 'nullable|exists:paketler,id',
            'baslik'      => 'nullable|string|max:255',
            'seri'        => 'nullable|string|max:100',
            'yil'         => 'required|integer|min:1900|max:' . (date('Y') + 1),
            'kilometre'   => 'nullable|integer|min:0',
            'fiyat'       => 'required|integer|min:0',
            'renk'        => 'nullable|string|max:50',
            'yakit_turu'  => 'nullable|string|max:50',
            'vites_turu'  => 'nullable|string|max:50',
            'kasa_tipi'   => 'nullable|string|max:50',
            'motor_hacmi' => 'nullable|string|max:20',
            'motor_gucu'  => 'nullable|integer|min:0',
            'cekis'       => 'nullable|string|max:50',
            'durum'       => 'required|string|max:50',
            'aciklama'    => 'nullable|string',
            'aktif'       => 'nullable|boolean',
            'one_cikan'   => 'nullable|boolean',
            'sira'        => 'nullable|integer|min:0',
        ]);

        $data['aktif']     = $request->boolean('aktif');
        $data['one_cikan'] = $request->boolean('one_cikan');

        return $data;
    }

    private function makeSlug(int $markaId, int $modelId, int $yil): string
    {
        $marka = \App\Models\Marka::find($markaId);
        $model = \App\Models\AracModel::find($modelId);
        $tr    = ['ş','Ş','ı','İ','ğ','Ğ','ü','Ü','ö','Ö','ç','Ç'];
        $en    = ['s','S','i','I','g','G','u','U','o','O','c','C'];
        $str   = str_replace($tr, $en, "{$marka?->ad} {$model?->ad} $yil");
        return Str::slug($str);
    }
}
