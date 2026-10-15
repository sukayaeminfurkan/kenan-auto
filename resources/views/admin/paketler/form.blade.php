<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $paket->exists ? 'Paket Düzenle' : 'Yeni Paket' }} — Admin</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100">

<nav class="bg-red-600 px-6 py-4 flex items-center justify-between">
    <div class="flex items-center gap-4">
        <a href="/admin" class="text-white font-bold text-lg">Kenan Auto — Admin</a>
        <a href="{{ route('admin.marka.index') }}" class="text-red-200 text-sm hover:text-white">/ Markalar</a>
        <a href="{{ route('admin.marka.modeller.index', $marka) }}" class="text-red-200 text-sm hover:text-white">/ {{ $marka->ad }}</a>
        <a href="{{ route('admin.paket.index', [$marka, $aracModel]) }}" class="text-red-200 text-sm hover:text-white">/ {{ $aracModel->ad }}</a>
        <span class="text-red-200 text-sm">/ {{ $paket->exists ? 'Düzenle' : 'Yeni Paket' }}</span>
    </div>
    <form method="POST" action="/logout">
        @csrf
        <button class="text-white text-sm hover:underline">Çıkış Yap</button>
    </form>
</nav>

<div class="max-w-2xl mx-auto py-10 px-6">

    <div class="flex items-center justify-between mb-6">
        <h1 class="text-xl font-bold text-gray-800">
            {{ $paket->exists ? 'Paket Düzenle' : 'Yeni Paket Ekle' }}
        </h1>
        <a href="{{ route('admin.paket.index', [$marka, $aracModel]) }}"
           class="text-sm text-gray-500 hover:text-gray-800">← Listeye Dön</a>
    </div>

    @if($errors->any())
        <div class="bg-red-50 text-red-700 px-4 py-3 rounded-lg mb-6 text-sm">
            <ul class="list-disc list-inside space-y-1">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST"
          action="{{ $paket->exists
              ? route('admin.paket.update', [$marka, $aracModel, $paket])
              : route('admin.paket.store', [$marka, $aracModel]) }}">
        @csrf
        @if($paket->exists)
            @method('PUT')
        @endif

        <div class="bg-white rounded-xl shadow divide-y divide-gray-100">

            <div class="px-6 py-5">
                <h2 class="text-sm font-semibold text-gray-500 uppercase tracking-wider mb-4">Paket Bilgileri</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">

                    <div class="sm:col-span-2">
                        <label class="block text-xs font-semibold text-gray-600 mb-1">Paket Adı *</label>
                        <input type="text" name="ad" value="{{ old('ad', $paket->ad) }}"
                               placeholder="Ör: 1.5 TCe 115 Expression Manuel"
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-red-500"
                               required>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-1">Yakıt Türü</label>
                        <select name="yakit_turu"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-red-500">
                            <option value="">— Seçin —</option>
                            @foreach(['Benzin', 'Dizel', 'Hibrit', 'Elektrik'] as $v)
                                <option value="{{ $v }}" @selected(old('yakit_turu', $paket->yakit_turu) === $v)>{{ $v }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-1">Vites Türü</label>
                        <select name="vites_turu"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-red-500">
                            <option value="">— Seçin —</option>
                            @foreach(['Manuel', 'Otomatik'] as $v)
                                <option value="{{ $v }}" @selected(old('vites_turu', $paket->vites_turu) === $v)>{{ $v }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-1">Motor Hacmi</label>
                        <input type="text" name="motor_hacmi" value="{{ old('motor_hacmi', $paket->motor_hacmi) }}"
                               placeholder="Ör: 1.5, 2.0"
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-red-500">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-1">Motor Gücü (HP)</label>
                        <input type="number" name="motor_gucu" value="{{ old('motor_gucu', $paket->motor_gucu) }}"
                               min="0"
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-red-500">
                    </div>

                </div>
            </div>

            <div class="px-6 py-5">
                <label class="flex items-center gap-3 cursor-pointer">
                    <input type="checkbox" name="aktif" value="1"
                           @checked(old('aktif', $paket->aktif ?? true))
                           class="w-4 h-4 rounded border-gray-300 text-red-600 focus:ring-red-500">
                    <span class="text-sm font-medium text-gray-700">Aktif</span>
                </label>
            </div>

            <div class="px-6 py-5 flex justify-end gap-3">
                <a href="{{ route('admin.paket.index', [$marka, $aracModel]) }}"
                   class="px-5 py-2 rounded-lg border border-gray-300 text-sm text-gray-600 hover:bg-gray-50">
                    İptal
                </a>
                <button type="submit"
                        class="px-6 py-2 bg-red-600 text-white rounded-lg text-sm font-semibold hover:bg-red-700">
                    {{ $paket->exists ? 'Güncelle' : 'Kaydet' }}
                </button>
            </div>

        </div>
    </form>
</div>

</body>
</html>
