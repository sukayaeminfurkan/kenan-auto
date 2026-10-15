<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Marka;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class MarkaController extends Controller
{
    public function index()
    {
        $markalar = Marka::withCount('modeller')->orderBy('sira')->paginate(20);
        return view('admin.markalar.index', compact('markalar'));
    }

    public function create()
    {
        return view('admin.markalar.form', ['marka' => new Marka]);
    }

    public function store(Request $request)
    {
        $data  = $this->validated($request);
        $marka = Marka::create($data);

        if ($request->wantsJson()) {
            return response()->json(['success' => true, 'id' => $marka->id, 'ad' => $marka->ad]);
        }

        return redirect()->route('admin.marka.index')->with('success', 'Marka eklendi.');
    }

    public function edit(Marka $marka)
    {
        return view('admin.markalar.form', compact('marka'));
    }

    public function update(Request $request, Marka $marka)
    {
        $data = $this->validated($request, $marka->id);
        $marka->update($data);
        return redirect()->route('admin.marka.index')->with('success', 'Marka güncellendi.');
    }

    public function destroy(Marka $marka)
    {
        $marka->delete();
        return redirect()->route('admin.marka.index')->with('success', 'Marka silindi.');
    }

    private function validated(Request $request, ?int $ignoreId = null): array
    {
        $data = $request->validate([
            'ad'   => 'required|string|max:100|unique:markalar,ad' . ($ignoreId ? ",$ignoreId" : ''),
            'aktif' => 'nullable|boolean',
            'sira'  => 'nullable|integer|min:0',
        ]);

        $data['aktif'] = $request->boolean('aktif');
        $data['slug']  = $this->slug($data['ad']);

        return $data;
    }

    private function slug(string $str): string
    {
        $tr = ['ş','Ş','ı','İ','ğ','Ğ','ü','Ü','ö','Ö','ç','Ç'];
        $en = ['s','S','i','I','g','G','u','U','o','O','c','C'];
        return Str::slug(str_replace($tr, $en, $str));
    }
}
