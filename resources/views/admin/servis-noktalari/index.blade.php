<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Servis Noktaları — Admin</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100">

<nav class="bg-red-600 px-6 py-4 flex items-center justify-between">
    <div class="flex items-center gap-4">
        <a href="/admin" class="text-white font-bold text-lg">Kenan Auto — Admin</a>
        <span class="text-red-200 text-sm">/ Servis Noktaları</span>
    </div>
    <form method="POST" action="/logout">
        @csrf
        <button class="text-white text-sm hover:underline">Çıkış Yap</button>
    </form>
</nav>

<div class="max-w-4xl mx-auto py-10 px-6">

    {{-- Başlık --}}
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-xl font-bold text-gray-800">Servis Noktaları</h1>
        <a href="{{ route('admin.servis.create') }}"
           class="btn-primary">
            + Yeni Ekle
        </a>
    </div>

    {{-- Başarı mesajı --}}
    @if(session('success'))
        <div class="bg-green-100 text-green-800 px-4 py-3 rounded-lg mb-6 text-sm">
            {{ session('success') }}
        </div>
    @endif

    {{-- Tablo --}}
    <div class="bg-white rounded-xl shadow overflow-hidden">
        @if($noktalari->isEmpty())
            <div class="text-center py-16 text-gray-400">
                Henüz servis noktası eklenmemiş.
            </div>
        @else
            <table class="w-full text-sm">
                <thead class="bg-gray-50 border-b border-gray-200">
                <tr>
                    <th class="text-left px-5 py-3 text-gray-600 font-semibold">Ad</th>
                    <th class="text-left px-5 py-3 text-gray-600 font-semibold">Şehir</th>
                    <th class="text-left px-5 py-3 text-gray-600 font-semibold">Kategori</th>
                    <th class="text-left px-5 py-3 text-gray-600 font-semibold">Sıra</th>
                    <th class="text-left px-5 py-3 text-gray-600 font-semibold">Durum</th>
                    <th class="text-right px-5 py-3"></th>
                </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                @foreach($noktalari as $nokta)
                    <tr class="hover:bg-gray-50">
                        <td class="px-5 py-3 font-medium text-gray-800">
                            <div class="flex items-center gap-3">
                                @if($nokta->logo)
                                    <img src="{{ Storage::url($nokta->logo) }}"
                                         class="w-8 h-8 rounded object-contain bg-gray-100">
                                @else
                                    <div class="w-8 h-8 rounded bg-red-100 flex items-center justify-center
                                                    text-red-600 font-bold text-xs">
                                        {{ strtoupper(substr($nokta->ad, 0, 1)) }}
                                    </div>
                                @endif
                                {{ $nokta->ad }}
                            </div>
                        </td>
                        <td class="px-5 py-3 text-gray-500">{{ $nokta->sehir ?? '—' }}</td>
                        <td class="px-5 py-3 text-gray-500">{{ $nokta->kategori ?? '—' }}</td>
                        <td class="px-5 py-3 text-gray-500">{{ $nokta->sira }}</td>
                        <td class="px-5 py-3">
                            @if($nokta->aktif)
                                <span class="badge-green">Aktif</span>
                            @else
                                <span class="badge-gray">Pasif</span>
                            @endif
                        </td>
                        <td class="px-5 py-3 text-right">
                            <a href="{{ route('admin.servis.edit', $nokta) }}"
                               class="text-blue-600 hover:underline text-xs mr-3">Düzenle</a>
                            <form method="POST"
                                  action="{{ route('admin.servis.destroy', $nokta) }}"
                                  class="inline"
                                  onsubmit="return confirm('Silmek istediğinize emin misiniz?')">
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
