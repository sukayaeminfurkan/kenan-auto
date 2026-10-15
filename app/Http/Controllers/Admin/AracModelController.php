<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AracModel;
use App\Models\Marka;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AracModelController extends Controller
{
    public function index(Marka $marka)
    {
        $modeller = $marka->modeller()->paginate(20);
        return view('admin.markalar.modeller.index', compact('marka', 'modeller'));
    }

    public function create(Marka $marka)
    {
        return view('admin.markalar.modeller.form', ['marka' => $marka, 'aracModel' => new AracModel]);
    }

    public function store(Request $request, Marka $marka)
    {
        $data  = $this->validated($request, $marka);
        $model = $marka->modeller()->create($data);

        if ($request->wantsJson()) {
            return response()->json(['success' => true, 'id' => $model->id, 'ad' => $model->ad]);
        }

        return redirect()->route('admin.marka.modeller.index', $marka)->with('success', 'Model eklendi.');
    }

    public function edit(Marka $marka, AracModel $aracModel)
    {
        return view('admin.markalar.modeller.form', compact('marka', 'aracModel'));
    }

    public function update(Request $request, Marka $marka, AracModel $aracModel)
    {
        $data = $this->validated($request, $marka, $aracModel->id);
        $aracModel->update($data);
        return redirect()->route('admin.marka.modeller.index', $marka)->with('success', 'Model güncellendi.');
    }

    public function destroy(Marka $marka, AracModel $aracModel)
    {
        $aracModel->delete();
        return redirect()->route('admin.marka.modeller.index', $marka)->with('success', 'Model silindi.');
    }

    public function apiModeller(Marka $marka)
    {
        return response()->json(
            $marka->modeller()->where('aktif', true)->get(['id', 'ad'])
        );
    }

    private function validated(Request $request, Marka $marka, ?int $ignoreId = null): array
    {
        $slug = $this->slug($request->input('ad', ''));

        $data = $request->validate([
            'ad'    => 'required|string|max:100',
            'aktif' => 'nullable|boolean',
        ]);

        // Unique slug per marka
        $request->validate([
            'ad' => "unique:modeller,slug,$ignoreId,id,marka_id,$marka->id",
        ]);

        $data['aktif'] = $request->boolean('aktif');
        $data['slug']  = $slug;

        return $data;
    }

    private function slug(string $str): string
    {
        $tr = ['ş','Ş','ı','İ','ğ','Ğ','ü','Ü','ö','Ö','ç','Ç'];
        $en = ['s','S','i','I','g','G','u','U','o','O','c','C'];
        return Str::slug(str_replace($tr, $en, $str));
    }
}
