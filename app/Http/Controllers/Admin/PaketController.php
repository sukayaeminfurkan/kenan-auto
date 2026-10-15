<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AracModel;
use App\Models\Marka;
use App\Models\Paket;
use Illuminate\Http\Request;

class PaketController extends Controller
{
    public function index(Marka $marka, AracModel $aracModel)
    {
        $paketler = $aracModel->paketler()->orderBy('ad')->get();
        return view('admin.paketler.index', compact('marka', 'aracModel', 'paketler'));
    }

    public function create(Marka $marka, AracModel $aracModel)
    {
        return view('admin.paketler.form', [
            'marka'     => $marka,
            'aracModel' => $aracModel,
            'paket'     => new Paket,
        ]);
    }

    public function store(Request $request, Marka $marka, AracModel $aracModel)
    {
        $data = $this->validated($request);
        $aracModel->paketler()->create($data);
        return redirect()
            ->route('admin.paket.index', [$marka, $aracModel])
            ->with('success', 'Paket eklendi.');
    }

    public function edit(Marka $marka, AracModel $aracModel, Paket $paket)
    {
        return view('admin.paketler.form', compact('marka', 'aracModel', 'paket'));
    }

    public function update(Request $request, Marka $marka, AracModel $aracModel, Paket $paket)
    {
        $data = $this->validated($request);
        $paket->update($data);
        return redirect()
            ->route('admin.paket.index', [$marka, $aracModel])
            ->with('success', 'Paket güncellendi.');
    }

    public function destroy(Marka $marka, AracModel $aracModel, Paket $paket)
    {
        $paket->delete();
        return redirect()
            ->route('admin.paket.index', [$marka, $aracModel])
            ->with('success', 'Paket silindi.');
    }

    public function apiByModel(AracModel $model)
    {
        $paketler = $model->paketler()
            ->where('aktif', true)
            ->orderBy('ad')
            ->get(['id', 'ad', 'yakit_turu', 'vites_turu', 'motor_hacmi', 'motor_gucu']);

        return response()->json($paketler);
    }

    public function apiStore(Request $request, AracModel $model)
    {
        $data  = $this->validated($request);
        $paket = $model->paketler()->create($data);

        return response()->json([
            'success'     => true,
            'id'          => $paket->id,
            'ad'          => $paket->ad,
            'yakit_turu'  => $paket->yakit_turu,
            'vites_turu'  => $paket->vites_turu,
            'motor_hacmi' => $paket->motor_hacmi,
            'motor_gucu'  => $paket->motor_gucu,
        ]);
    }

    private function validated(Request $request): array
    {
        $data = $request->validate([
            'ad'          => 'required|string|max:150',
            'yakit_turu'  => 'nullable|string|max:50',
            'vites_turu'  => 'nullable|string|max:50',
            'motor_hacmi' => 'nullable|string|max:20',
            'motor_gucu'  => 'nullable|integer|min:0',
        ]);

        $data['aktif'] = $request->boolean('aktif');

        return $data;
    }
}
