<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ isset($servisNoktasi) ? 'Düzenle' : 'Yeni Ekle' }} — Admin</title>
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

<div class="max-w-xl mx-auto py-10 px-6">

    <div class="flex items-center justify-between mb-6">
        <h1 class="text-xl font-bold text-gray-800">
            {{ isset($servisNoktasi) ? 'Servis Noktasını Düzenle' : 'Yeni Servis Noktası' }}
        </h1>
        <a href="{{ route('admin.servis.index') }}"
           class="text-sm text-gray-500 hover:text-gray-700">← Geri</a>
    </div>

    <form method="POST"
          action="{{ isset($servisNoktasi) ? route('admin.servis.update', $servisNoktasi) : route('admin.servis.store') }}"
          class="admin-card space-y-5">
        @csrf
        @if(isset($servisNoktasi)) @method('PUT') @endif

        {{-- Ad --}}
        <div>
            <label class="label">Firma Adı *</label>
            <input type="text" name="ad"
                   value="{{ old('ad', $servisNoktasi->ad ?? '') }}"
                   class="input"
                   required>
            @error('ad') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        {{-- Şehir --}}
        <div>
            <label class="label">Şehir</label>
            <input type="text" name="sehir"
                   value="{{ old('sehir', $servisNoktasi->sehir ?? '') }}"
                   class="input">
        </div>

        {{-- Kategori --}}
        <div>
            <label class="label">Kategori</label>
            <select name="kategori"
                    class="input">
                <option value="">Seçin</option>
                @foreach(['Yetkili Servis', 'Bakım Merkezi', 'Ekspertiz', 'Araç Stüdyosu', 'Araç Satış Merkezi'] as $kat)
                    <option value="{{ $kat }}"
                        {{ old('kategori', $servisNoktasi->kategori ?? '') === $kat ? 'selected' : '' }}>
                        {{ $kat }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Sıra --}}
        <div>
            <label class="label">Sıra</label>
            <input type="number" name="sira"
                   value="{{ old('sira', $servisNoktasi->sira ?? 0) }}"
                   class="input">
            <p class="text-xs text-gray-400 mt-1">Küçük sayı önce görünür.</p>
        </div>

        {{-- Aktif --}}
        <div class="flex items-center gap-2">
            <input type="checkbox" name="aktif" id="aktif" value="1"
                   {{ old('aktif', $servisNoktasi->aktif ?? true) ? 'checked' : '' }}
                   class="rounded border-gray-300">
            <label for="aktif" class="text-sm text-gray-700">Aktif (anasayfada görünsün)</label>
        </div>

        {{-- Kaydet --}}
        <div class="pt-2">
            <button type="submit"
                    class="btn-primary w-full">
                {{ isset($servisNoktasi) ? 'Güncelle' : 'Kaydet' }}
            </button>
        </div>
    </form>
</div>

</body>
</html>
