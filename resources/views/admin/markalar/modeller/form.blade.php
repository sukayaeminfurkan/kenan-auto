<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $aracModel->exists ? 'Model Düzenle' : 'Yeni Model' }} — Admin</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100">

<nav class="bg-red-600 px-6 py-4 flex items-center justify-between">
    <div class="flex items-center gap-4">
        <a href="/admin" class="text-white font-bold text-lg">Kenan Auto — Admin</a>
        <a href="{{ route('admin.marka.index') }}" class="text-red-200 text-sm hover:text-white">/ Markalar</a>
        <a href="{{ route('admin.marka.modeller.index', $marka) }}" class="text-red-200 text-sm hover:text-white">/ {{ $marka->ad }}</a>
        <span class="text-red-200 text-sm">/ {{ $aracModel->exists ? 'Düzenle' : 'Yeni' }}</span>
    </div>
    <form method="POST" action="/logout">
        @csrf
        <button class="text-white text-sm hover:underline">Çıkış Yap</button>
    </form>
</nav>

<div class="max-w-lg mx-auto py-10 px-6">

    <div class="flex items-center justify-between mb-6">
        <h1 class="text-xl font-bold text-gray-800">
            {{ $marka->ad }} — {{ $aracModel->exists ? $aracModel->ad . ' Düzenle' : 'Yeni Model' }}
        </h1>
        <a href="{{ route('admin.marka.modeller.index', $marka) }}"
           class="text-sm text-gray-500 hover:text-gray-800">← Geri</a>
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
          action="{{ $aracModel->exists
              ? route('admin.marka.modeller.update', [$marka, $aracModel])
              : route('admin.marka.modeller.store', $marka) }}">
        @csrf
        @if($aracModel->exists) @method('PUT') @endif

        <div class="bg-white rounded-xl shadow divide-y divide-gray-100">
            <div class="px-6 py-5 space-y-4">

                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1">Model Adı *</label>
                    <input type="text" name="ad" value="{{ old('ad', $aracModel->ad) }}"
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-red-500"
                           required>
                </div>

                <label class="flex items-center gap-3 cursor-pointer">
                    <input type="checkbox" name="aktif" value="1"
                           @checked(old('aktif', $aracModel->aktif ?? true))
                           class="w-4 h-4 rounded border-gray-300 text-red-600 focus:ring-red-500">
                    <span class="text-sm font-medium text-gray-700">Aktif</span>
                </label>

            </div>

            <div class="px-6 py-5 flex justify-end gap-3">
                <a href="{{ route('admin.marka.modeller.index', $marka) }}"
                   class="px-5 py-2 rounded-lg border border-gray-300 text-sm text-gray-600 hover:bg-gray-50">
                    İptal
                </a>
                <button type="submit"
                        class="px-6 py-2 bg-red-600 text-white rounded-lg text-sm font-semibold hover:bg-red-700">
                    {{ $aracModel->exists ? 'Güncelle' : 'Kaydet' }}
                </button>
            </div>
        </div>
    </form>
</div>

</body>
</html>
