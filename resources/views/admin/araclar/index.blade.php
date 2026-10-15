<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Araçlar — Admin</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100">

<nav class="bg-red-600 px-6 py-4 flex items-center justify-between">
    <div class="flex items-center gap-4">
        <a href="/admin" class="text-white font-bold text-lg">Kenan Auto — Admin</a>
        <span class="text-red-200 text-sm">/ Araçlar</span>
    </div>
    <form method="POST" action="/logout">
        @csrf
        <button class="text-white text-sm hover:underline">Çıkış Yap</button>
    </form>
</nav>

<div class="max-w-6xl mx-auto py-10 px-6">

    <div class="flex items-center justify-between mb-6">
        <h1 class="text-xl font-bold text-gray-800">Araçlar</h1>
        <a href="{{ route('admin.arac.create') }}"
           class="btn-primary">
            + Yeni Ekle
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 text-green-800 px-4 py-3 rounded-lg mb-6 text-sm">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-xl shadow overflow-hidden">
        @if($araclar->isEmpty())
            <div class="text-center py-16 text-gray-400">Henüz araç eklenmemiş.</div>
        @else
            <table class="w-full text-sm">
                <thead class="bg-gray-50 border-b border-gray-200">
                <tr>
                    <th class="text-left px-5 py-3 text-gray-600 font-semibold">Araç</th>
                    <th class="text-left px-5 py-3 text-gray-600 font-semibold">Yıl</th>
                    <th class="text-left px-5 py-3 text-gray-600 font-semibold">Fiyat</th>
                    <th class="text-left px-5 py-3 text-gray-600 font-semibold">Durum</th>
                    <th class="text-left px-5 py-3 text-gray-600 font-semibold">Aktif</th>
                    <th class="text-left px-5 py-3 text-gray-600 font-semibold">Öne Çıkan</th>
                    <th class="text-right px-5 py-3"></th>
                </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                @foreach($araclar as $arac)
                    <tr class="hover:bg-gray-50">
                        <td class="px-5 py-3 font-medium text-gray-800">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded bg-red-100 flex items-center justify-center
                                            text-red-600 font-bold text-xs flex-shrink-0">
                                    {{ strtoupper(substr($arac->marka?->ad ?? '?', 0, 1)) }}
                                </div>
                                <span>{{ $arac->marka?->ad }} {{ $arac->aracModel?->ad }}</span>
                            </div>
                        </td>
                        <td class="px-5 py-3 text-gray-500">{{ $arac->yil }}</td>
                        <td class="px-5 py-3 text-gray-700 font-medium">
                            {{ number_format($arac->fiyat, 0, ',', '.') }} ₺
                        </td>
                        <td class="px-5 py-3">
                            @php
                                $renkler = ['Satışta' => 'blue', 'Satıldı' => 'gray', 'Rezerve' => 'yellow'];
                                $r = $renkler[$arac->durum] ?? 'gray';
                            @endphp
                            <span class="bg-{{ $r }}-100 text-{{ $r }}-700 px-2 py-0.5 rounded text-xs font-medium">
                                {{ $arac->durum }}
                            </span>
                        </td>
                        <td class="px-5 py-3">
                            @if($arac->aktif)
                                <span class="badge-green">Aktif</span>
                            @else
                                <span class="badge-gray">Pasif</span>
                            @endif
                        </td>
                        <td class="px-5 py-3">
                            <form method="POST" action="{{ route('admin.arac.toggleOneCikan', $arac) }}" class="inline">
                                @csrf
                                <button type="submit"
                                        title="{{ $arac->one_cikan ? 'Öne çıkandan kaldır' : 'Öne çıkar' }}"
                                        class="text-xl leading-none transition-colors duration-150
                                               {{ $arac->one_cikan ? 'text-yellow-400 hover:text-gray-400' : 'text-gray-300 hover:text-yellow-400' }}">
                                    ★
                                </button>
                            </form>
                        </td>
                        <td class="px-5 py-3 text-right whitespace-nowrap">
                            <a href="{{ route('admin.arac.edit', $arac) }}"
                               class="text-blue-600 hover:underline text-xs mr-3">Düzenle</a>
                            <form method="POST" action="{{ route('admin.arac.destroy', $arac) }}"
                                  class="inline"
                                  onsubmit="return confirm('Bu aracı silmek istediğinize emin misiniz?')">
                                @csrf
                                @method('DELETE')
                                <button class="text-red-500 hover:underline text-xs">Sil</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>

            @if($araclar->hasPages())
                <div class="px-5 py-4 border-t border-gray-100">
                    {{ $araclar->links() }}
                </div>
            @endif
        @endif
    </div>
</div>

</body>
</html>
