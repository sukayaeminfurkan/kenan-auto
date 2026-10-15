<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Markalar — Admin</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100">

<nav class="bg-red-600 px-6 py-4 flex items-center justify-between">
    <div class="flex items-center gap-4">
        <a href="/admin" class="text-white font-bold text-lg">Kenan Auto — Admin</a>
        <span class="text-red-200 text-sm">/ Markalar</span>
    </div>
    <form method="POST" action="/logout">
        @csrf
        <button class="text-white text-sm hover:underline">Çıkış Yap</button>
    </form>
</nav>

<div class="max-w-3xl mx-auto py-10 px-6">

    <div class="flex items-center justify-between mb-6">
        <h1 class="text-xl font-bold text-gray-800">Markalar</h1>
        <a href="{{ route('admin.marka.create') }}"
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
        @if($markalar->isEmpty())
            <div class="text-center py-16 text-gray-400">Henüz marka eklenmemiş.</div>
        @else
            <table class="w-full text-sm">
                <thead class="bg-gray-50 border-b border-gray-200">
                <tr>
                    <th class="text-left px-5 py-3 text-gray-600 font-semibold">Marka</th>
                    <th class="text-left px-5 py-3 text-gray-600 font-semibold">Model Sayısı</th>
                    <th class="text-left px-5 py-3 text-gray-600 font-semibold">Sıra</th>
                    <th class="text-left px-5 py-3 text-gray-600 font-semibold">Durum</th>
                    <th class="text-right px-5 py-3"></th>
                </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                @foreach($markalar as $marka)
                    <tr class="hover:bg-gray-50">
                        <td class="px-5 py-3">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded bg-red-100 flex items-center justify-center
                                            text-red-600 font-bold text-xs flex-shrink-0">
                                    {{ strtoupper(substr($marka->ad, 0, 1)) }}
                                </div>
                                <span class="font-medium text-gray-800">{{ $marka->ad }}</span>
                            </div>
                        </td>
                        <td class="px-5 py-3 text-gray-500">
                            <a href="{{ route('admin.marka.modeller.index', $marka) }}"
                               class="text-blue-600 hover:underline font-medium">
                                {{ $marka->modeller_count }} model
                            </a>
                        </td>
                        <td class="px-5 py-3 text-gray-500">{{ $marka->sira }}</td>
                        <td class="px-5 py-3">
                            @if($marka->aktif)
                                <span class="bg-green-100 text-green-700 px-2 py-0.5 rounded text-xs font-medium">Aktif</span>
                            @else
                                <span class="bg-gray-100 text-gray-500 px-2 py-0.5 rounded text-xs font-medium">Pasif</span>
                            @endif
                        </td>
                        <td class="px-5 py-3 text-right whitespace-nowrap">
                            <a href="{{ route('admin.marka.modeller.index', $marka) }}"
                               class="text-gray-500 hover:underline text-xs mr-3">Modeller</a>
                            <a href="{{ route('admin.marka.edit', $marka) }}"
                               class="text-blue-600 hover:underline text-xs mr-3">Düzenle</a>
                            <form method="POST" action="{{ route('admin.marka.destroy', $marka) }}"
                                  class="inline"
                                  onsubmit="return confirm('Bu markayı silmek istediğinize emin misiniz? Tüm modeller de silinir.')">
                                @csrf
                                @method('DELETE')
                                <button class="text-red-500 hover:underline text-xs">Sil</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>

            @if($markalar->hasPages())
                <div class="px-5 py-4 border-t border-gray-100">
                    {{ $markalar->links() }}
                </div>
            @endif
        @endif
    </div>
</div>

</body>
</html>
