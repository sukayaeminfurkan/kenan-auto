<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $aracModel->ad }} — Paketler — Admin</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100">

<nav class="bg-red-600 px-6 py-4 flex items-center justify-between">
    <div class="flex items-center gap-4">
        <a href="/admin" class="text-white font-bold text-lg">Kenan Auto — Admin</a>
        <a href="{{ route('admin.marka.index') }}" class="text-red-200 text-sm hover:text-white">/ Markalar</a>
        <a href="{{ route('admin.marka.modeller.index', $marka) }}" class="text-red-200 text-sm hover:text-white">/ {{ $marka->ad }}</a>
        <span class="text-red-200 text-sm">/ {{ $aracModel->ad }}</span>
    </div>
    <form method="POST" action="/logout">
        @csrf
        <button class="text-white text-sm hover:underline">Çıkış Yap</button>
    </form>
</nav>

<div class="max-w-4xl mx-auto py-10 px-6">

    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-xl font-bold text-gray-800">{{ $aracModel->ad }} — Paketler</h1>
            <a href="{{ route('admin.marka.modeller.index', $marka) }}"
               class="text-sm text-gray-500 hover:text-gray-800">← Modellere Dön</a>
        </div>
        <a href="{{ route('admin.paket.create', [$marka, $aracModel]) }}"
           class="bg-red-600 text-white px-4 py-2 rounded-lg text-sm font-semibold hover:bg-red-700">
            + Yeni Paket
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 text-green-800 px-4 py-3 rounded-lg mb-6 text-sm">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-xl shadow overflow-hidden">
        @if($paketler->isEmpty())
            <div class="text-center py-16 text-gray-400">Bu modele ait paket yok.</div>
        @else
            <table class="w-full text-sm">
                <thead class="bg-gray-50 border-b border-gray-200">
                <tr>
                    <th class="text-left px-5 py-3 text-gray-600 font-semibold">Paket Adı</th>
                    <th class="text-left px-5 py-3 text-gray-600 font-semibold">Yakıt</th>
                    <th class="text-left px-5 py-3 text-gray-600 font-semibold">Vites</th>
                    <th class="text-left px-5 py-3 text-gray-600 font-semibold">Hacim</th>
                    <th class="text-left px-5 py-3 text-gray-600 font-semibold">Güç (HP)</th>
                    <th class="text-left px-5 py-3 text-gray-600 font-semibold">Durum</th>
                    <th class="text-right px-5 py-3"></th>
                </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                @foreach($paketler as $paket)
                    <tr class="hover:bg-gray-50">
                        <td class="px-5 py-3 font-medium text-gray-800">{{ $paket->ad }}</td>
                        <td class="px-5 py-3 text-gray-500">{{ $paket->yakit_turu ?? '—' }}</td>
                        <td class="px-5 py-3 text-gray-500">{{ $paket->vites_turu ?? '—' }}</td>
                        <td class="px-5 py-3 text-gray-500">{{ $paket->motor_hacmi ?? '—' }}</td>
                        <td class="px-5 py-3 text-gray-500">{{ $paket->motor_gucu ?? '—' }}</td>
                        <td class="px-5 py-3">
                            @if($paket->aktif)
                                <span class="bg-green-100 text-green-700 px-2 py-0.5 rounded text-xs font-medium">Aktif</span>
                            @else
                                <span class="bg-gray-100 text-gray-500 px-2 py-0.5 rounded text-xs font-medium">Pasif</span>
                            @endif
                        </td>
                        <td class="px-5 py-3 text-right whitespace-nowrap">
                            <a href="{{ route('admin.paket.edit', [$marka, $aracModel, $paket]) }}"
                               class="text-blue-600 hover:underline text-xs mr-3">Düzenle</a>
                            <form method="POST"
                                  action="{{ route('admin.paket.destroy', [$marka, $aracModel, $paket]) }}"
                                  class="inline"
                                  onsubmit="return confirm('Bu paketi silmek istediğinize emin misiniz?')">
                                @csrf
                                @method('DELETE')
                                <button class="text-red-500 hover:underline text-xs">Sil</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @endif
    </div>
</div>

</body>
</html>
