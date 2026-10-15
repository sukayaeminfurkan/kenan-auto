<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $marka->ad }} Modelleri — Admin</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100">

<nav class="bg-red-600 px-6 py-4 flex items-center justify-between">
    <div class="flex items-center gap-4">
        <a href="/admin" class="text-white font-bold text-lg">Kenan Auto — Admin</a>
        <a href="{{ route('admin.marka.index') }}" class="text-red-200 text-sm hover:text-white">/ Markalar</a>
        <span class="text-red-200 text-sm">/ {{ $marka->ad }}</span>
    </div>
    <form method="POST" action="/logout">
        @csrf
        <button class="text-white text-sm hover:underline">Çıkış Yap</button>
    </form>
</nav>

<div class="max-w-2xl mx-auto py-10 px-6">

    <div class="flex items-center justify-between mb-6">
        <h1 class="text-xl font-bold text-gray-800">{{ $marka->ad }} — Modeller</h1>
        <a href="{{ route('admin.marka.modeller.create', $marka) }}"
           class="bg-red-600 text-white px-4 py-2 rounded-lg text-sm font-semibold hover:bg-red-700">
            + Yeni Ekle
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 text-green-800 px-4 py-3 rounded-lg mb-6 text-sm">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-xl shadow overflow-hidden">
        @if($modeller->isEmpty())
            <div class="text-center py-16 text-gray-400">Bu markaya ait model yok.</div>
        @else
            <table class="w-full text-sm">
                <thead class="bg-gray-50 border-b border-gray-200">
                <tr>
                    <th class="text-left px-5 py-3 text-gray-600 font-semibold">Model Adı</th>
                    <th class="text-left px-5 py-3 text-gray-600 font-semibold">Durum</th>
                    <th class="text-right px-5 py-3"></th>
                </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                @foreach($modeller as $aracModel)
                    <tr class="hover:bg-gray-50">
                        <td class="px-5 py-3 font-medium text-gray-800">{{ $aracModel->ad }}</td>
                        <td class="px-5 py-3">
                            @if($aracModel->aktif)
                                <span class="bg-green-100 text-green-700 px-2 py-0.5 rounded text-xs font-medium">Aktif</span>
                            @else
                                <span class="bg-gray-100 text-gray-500 px-2 py-0.5 rounded text-xs font-medium">Pasif</span>
                            @endif
                        </td>
                        <td class="px-5 py-3 text-right whitespace-nowrap">
                            <a href="{{ route('admin.paket.index', [$marka, $aracModel]) }}"
                               class="text-purple-600 hover:underline text-xs mr-3">Paketler</a>
                            <a href="{{ route('admin.marka.modeller.edit', [$marka, $aracModel]) }}"
                               class="text-blue-600 hover:underline text-xs mr-3">Düzenle</a>
                            <form method="POST"
                                  action="{{ route('admin.marka.modeller.destroy', [$marka, $aracModel]) }}"
                                  class="inline"
                                  onsubmit="return confirm('Bu modeli silmek istediğinize emin misiniz?')">
                                @csrf
                                @method('DELETE')
                                <button class="text-red-500 hover:underline text-xs">Sil</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>

            @if($modeller->hasPages())
                <div class="px-5 py-4 border-t border-gray-100">
                    {{ $modeller->links() }}
                </div>
            @endif
        @endif
    </div>
</div>

</body>
</html>
