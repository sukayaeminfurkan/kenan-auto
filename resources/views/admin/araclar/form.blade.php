<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $arac->exists ? 'Araç Düzenle' : 'Yeni Araç' }} — Admin</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100">

<nav class="bg-red-600 px-6 py-4 flex items-center justify-between">
    <div class="flex items-center gap-4">
        <a href="/admin" class="text-white font-bold text-lg">Kenan Auto — Admin</a>
        <a href="{{ route('admin.arac.index') }}" class="text-red-200 text-sm hover:text-white">/ Araçlar</a>
        <span class="text-red-200 text-sm">/ {{ $arac->exists ? 'Düzenle' : 'Yeni Ekle' }}</span>
    </div>
    <form method="POST" action="/logout">
        @csrf
        <button class="text-white text-sm hover:underline">Çıkış Yap</button>
    </form>
</nav>

<div class="max-w-3xl mx-auto py-10 px-6">

    <div class="flex items-center justify-between mb-6">
        <h1 class="text-xl font-bold text-gray-800">
            {{ $arac->exists ? $arac->marka . ' ' . $arac->model . ' Düzenle' : 'Yeni Araç Ekle' }}
        </h1>
        <a href="{{ route('admin.arac.index') }}"
           class="text-sm text-gray-500 hover:text-gray-800">← Listeye Dön</a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 text-green-800 px-4 py-3 rounded-lg mb-6 text-sm">
            {{ session('success') }}
        </div>
    @endif

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
          enctype="multipart/form-data"
          action="{{ $arac->exists ? route('admin.arac.update', $arac) : route('admin.arac.store') }}">
        @csrf
        @if($arac->exists)
            @method('PUT')
        @endif

        <div class="bg-white rounded-xl shadow divide-y divide-gray-100">

            {{-- Temel Bilgiler --}}
            <div class="px-6 py-5">
                <h2 class="text-sm font-semibold text-gray-500 uppercase tracking-wider mb-4">Temel Bilgiler</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">

                    @php
                        $markalar     = App\Models\Marka::orderBy('sira')->get();
                        $secilenMarka = (int) old('marka_id', $arac->marka_id);
                        $secilenModel = (int) old('model_id', $arac->model_id);
                    @endphp

                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-1">Marka *</label>
                        <div class="flex gap-2 items-center">
                            <select id="marka-select" name="marka_id"
                                    class="select flex-1"
                                    required>
                                <option value="">— Marka Seçin —</option>
                                @foreach($markalar as $m)
                                    <option value="{{ $m->id }}" @selected($secilenMarka === $m->id)>{{ $m->ad }}</option>
                                @endforeach
                            </select>
                            <button type="button" id="btn-ekle-marka"
                                    class="shrink-0 w-9 h-[38px] bg-red-600 hover:bg-red-700 text-white rounded-lg text-lg font-bold flex items-center justify-center"
                                    title="Yeni marka ekle">+</button>
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-1">Model *</label>
                        <div class="flex gap-2 items-center">
                            <select id="model-select" name="model_id"
                                    class="select flex-1"
                                    required>
                                @if($secilenMarka)
                                    @foreach(App\Models\AracModel::where('marka_id', $secilenMarka)->where('aktif', true)->orderBy('ad')->get() as $m)
                                        <option value="{{ $m->id }}" @selected($secilenModel === $m->id)>{{ $m->ad }}</option>
                                    @endforeach
                                @else
                                    <option value="">— Önce Marka Seçin —</option>
                                @endif
                            </select>
                            <button type="button" id="btn-ekle-model"
                                    class="shrink-0 w-9 h-[38px] bg-red-600 hover:bg-red-700 disabled:bg-gray-300 disabled:cursor-not-allowed text-white rounded-lg text-lg font-bold flex items-center justify-center"
                                    title="{{ $secilenMarka ? 'Yeni model ekle' : 'Önce marka seçin' }}"
                                    {{ $secilenMarka ? '' : 'disabled' }}>+</button>
                        </div>
                    </div>

                    <div class="sm:col-span-2">
                        <label class="block text-xs font-semibold text-gray-600 mb-1">İlan Başlığı</label>
                        <input type="text" name="baslik" value="{{ old('baslik', $arac->baslik) }}"
                               placeholder="Ör: Temiz Toyota Auris, Bakımlı Honda Civic"
                               class="input">
                    </div>

                    @php $secilenPaket = (int) old('paket_id', $arac->paket_id); @endphp

                    <div class="sm:col-span-2">
                        <label class="block text-xs font-semibold text-gray-600 mb-1">Paket</label>
                        <div class="flex gap-2 items-center">
                            <select id="paket-select" name="paket_id"
                                    class="select flex-1">
                                @if($secilenMarka && $secilenModel)
                                    <option value="">— Paket Seçin (isteğe bağlı) —</option>
                                    @foreach(App\Models\Paket::where('model_id', $secilenModel)->where('aktif', true)->orderBy('ad')->get() as $p)
                                        <option value="{{ $p->id }}"
                                                data-yakit="{{ $p->yakit_turu }}"
                                                data-vites="{{ $p->vites_turu }}"
                                                data-hacmi="{{ $p->motor_hacmi }}"
                                                data-gucu="{{ $p->motor_gucu }}"
                                                @selected($secilenPaket === $p->id)>{{ $p->ad }}</option>
                                    @endforeach
                                @else
                                    <option value="">— Önce Model Seçin —</option>
                                @endif
                            </select>
                            <button type="button" id="btn-ekle-paket"
                                    class="shrink-0 w-9 h-[38px] bg-red-600 hover:bg-red-700 disabled:bg-gray-300 disabled:cursor-not-allowed text-white rounded-lg text-lg font-bold flex items-center justify-center"
                                    title="{{ ($secilenMarka && $secilenModel) ? 'Yeni paket ekle' : 'Önce model seçin' }}"
                                    {{ ($secilenMarka && $secilenModel) ? '' : 'disabled' }}>+</button>
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-1">Seri / Donanım Paketi</label>
                        <input type="text" name="seri" value="{{ old('seri', $arac->seri) }}"
                               placeholder="Ör: 1.33 Life, 2.0 TDI Highline, 1.6 Style"
                               class="input">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-1">Yıl *</label>
                        <input type="number" name="yil" value="{{ old('yil', $arac->yil) }}"
                               min="1900" max="{{ date('Y') + 1 }}"
                               class="input"
                               required>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-1">Kilometre</label>
                        <input type="number" name="kilometre" value="{{ old('kilometre', $arac->kilometre) }}"
                               min="0"
                               class="input">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-1">Fiyat (₺) *</label>
                        <input type="number" name="fiyat" value="{{ old('fiyat', $arac->fiyat) }}"
                               min="0"
                               class="input"
                               required>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-1">Renk</label>
                        <input type="text" name="renk" value="{{ old('renk', $arac->renk) }}"
                               class="input">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-1">Durum *</label>
                        <select name="durum"
                                class="input"
                                required>
                            @foreach(['Satışta', 'Satıldı', 'Rezerve'] as $d)
                                <option value="{{ $d }}" @selected(old('durum', $arac->durum) === $d)>{{ $d }}</option>
                            @endforeach
                        </select>
                    </div>

                </div>
            </div>

            {{-- Teknik Özellikler --}}
            <div class="px-6 py-5">
                <h2 class="text-sm font-semibold text-gray-500 uppercase tracking-wider mb-4">Teknik Özellikler</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">

                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-1">Yakıt Türü</label>
                        <select name="yakit_turu"
                                class="input">
                            <option value="">— Seçin —</option>
                            @foreach(['Benzin', 'Dizel', 'LPG', 'Elektrik', 'Hibrit'] as $v)
                                <option value="{{ $v }}" @selected(old('yakit_turu', $arac->yakit_turu) === $v)>{{ $v }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-1">Vites Türü</label>
                        <select name="vites_turu"
                                class="input">
                            <option value="">— Seçin —</option>
                            @foreach(['Manuel', 'Otomatik', 'Yarı Otomatik'] as $v)
                                <option value="{{ $v }}" @selected(old('vites_turu', $arac->vites_turu) === $v)>{{ $v }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-1">Kasa Tipi</label>
                        <select name="kasa_tipi"
                                class="input">
                            <option value="">— Seçin —</option>
                            @foreach(['Sedan', 'Hatchback', 'SUV', 'Pickup', 'Coupe', 'Cabrio', 'Minivan'] as $v)
                                <option value="{{ $v }}" @selected(old('kasa_tipi', $arac->kasa_tipi) === $v)>{{ $v }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-1">Çekiş</label>
                        <input type="text" name="cekis" value="{{ old('cekis', $arac->cekis) }}"
                               placeholder="Ör: 4x4, Önden çekiş"
                               class="input">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-1">Motor Hacmi</label>
                        <input type="text" name="motor_hacmi" value="{{ old('motor_hacmi', $arac->motor_hacmi) }}"
                               placeholder="Ör: 1.6, 2.0"
                               class="input">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-1">Motor Gücü (HP)</label>
                        <input type="number" name="motor_gucu" value="{{ old('motor_gucu', $arac->motor_gucu) }}"
                               min="0"
                               class="input">
                    </div>

                </div>
            </div>

            {{-- Açıklama --}}
            <div class="px-6 py-5">
                <h2 class="text-sm font-semibold text-gray-500 uppercase tracking-wider mb-4">Açıklama</h2>
                <textarea name="aciklama" rows="4"
                          class="input">{{ old('aciklama', $arac->aciklama) }}</textarea>
            </div>

            {{-- Fotoğraflar --}}
            <div class="px-6 py-5">
                <h2 class="text-sm font-semibold text-gray-500 uppercase tracking-wider mb-4">Fotoğraflar</h2>

                {{-- Mevcut fotoğraflar (düzenleme modunda) --}}
                @if($arac->exists && $arac->fotograflar->count() > 0)
                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-3 mb-4">
                        @foreach($arac->fotograflar->sortBy('sira') as $foto)
                            <div class="relative group rounded-xl overflow-hidden border-2
                                        {{ $foto->kapak ? 'border-green-500' : 'border-transparent' }}">

                                <img src="{{ Storage::url($foto->dosya_yolu) }}"
                                     alt="{{ $foto->alt_metin ?? '' }}"
                                     class="w-full h-32 object-cover">

                                @if($foto->kapak)
                                    <span class="absolute top-1.5 left-1.5 bg-green-500 text-white
                                                 text-[10px] font-bold px-1.5 py-0.5 rounded">
                                        Kapak
                                    </span>
                                @endif

                                {{-- Hover aksiyonları --}}
                                <div class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100
                                            transition-opacity duration-150 flex items-end justify-between p-2 gap-1">

                                    @if(!$foto->kapak)
                                        <form method="POST"
                                              action="{{ route('admin.arac.fotograf.kapak', $foto) }}">
                                            @csrf
                                            <button type="submit"
                                                    class="text-[11px] bg-green-500 hover:bg-green-600
                                                           text-white px-2 py-1 rounded font-semibold">
                                                Kapak Yap
                                            </button>
                                        </form>
                                    @else
                                        <span></span>
                                    @endif

                                    <form method="POST"
                                          action="{{ route('admin.arac.fotograf.destroy', $foto) }}"
                                          onsubmit="return confirm('Bu fotoğrafı silmek istediğinize emin misiniz?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="text-[11px] bg-red-600 hover:bg-red-700
                                                       text-white px-2 py-1 rounded font-semibold">
                                            Sil
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    @php $kalanSlot = 10 - $arac->fotograflar->count(); @endphp
                    @if($kalanSlot > 0)
                        <p class="text-xs text-gray-400 mb-3">
                            {{ $arac->fotograflar->count() }}/10 fotoğraf yüklendi. {{ $kalanSlot }} fotoğraf daha ekleyebilirsiniz.
                        </p>
                    @else
                        <p class="text-xs text-orange-500 mb-3">Maksimum fotoğraf sayısına (10) ulaşıldı.</p>
                    @endif
                @endif

                {{-- Yeni fotoğraf yükle --}}
                @php $kalanSlot = $arac->exists ? (10 - $arac->fotograflar->count()) : 10; @endphp
                @if($kalanSlot > 0)
                    <label class="block">
                        <div class="border-2 border-dashed border-gray-300 rounded-xl px-6 py-8
                                    text-center cursor-pointer hover:border-red-400 hover:bg-red-50
                                    transition-colors duration-150" id="dropzone">
                            <svg class="mx-auto mb-2 text-gray-400" width="32" height="32" fill="none"
                                 viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                      d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            <p class="text-sm text-gray-500 font-medium">Fotoğraf seç veya sürükle bırak</p>
                            <p class="text-xs text-gray-400 mt-1">
                                JPG, PNG, WebP · Maks. 5 MB · En fazla {{ $kalanSlot }} fotoğraf
                            </p>
                            <p class="text-xs text-gray-400 mt-0.5" id="secilen-dosya-adi"></p>
                        </div>
                        <input type="file" name="fotograflar[]" multiple accept="image/jpeg,image/png,image/webp"
                               class="sr-only" id="fotograf-input">
                    </label>

                    {{-- Önizleme grid --}}
                    <div class="grid grid-cols-3 gap-2 mt-3 hidden" id="preview-grid"></div>
                @endif
            </div>

            {{-- Yayın Ayarları --}}
            <div class="px-6 py-5">
                <h2 class="text-sm font-semibold text-gray-500 uppercase tracking-wider mb-4">Yayın Ayarları</h2>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">

                    <label class="flex items-center gap-3 cursor-pointer">
                        <input type="checkbox" name="aktif" value="1"
                               @checked(old('aktif', $arac->aktif ?? true))
                               class="w-4 h-4 rounded border-gray-300 text-red-600 focus:ring-red-500">
                        <span class="text-sm font-medium text-gray-700">Aktif</span>
                    </label>

                    <label class="flex items-center gap-3 cursor-pointer">
                        <input type="checkbox" name="one_cikan" value="1"
                               @checked(old('one_cikan', $arac->one_cikan))
                               class="w-4 h-4 rounded border-gray-300 text-red-600 focus:ring-red-500">
                        <span class="text-sm font-medium text-gray-700">Öne Çıkan</span>
                    </label>

                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-1">Sıra</label>
                        <input type="number" name="sira" value="{{ old('sira', $arac->sira ?? 0) }}"
                               min="0"
                               class="input">
                    </div>

                </div>
            </div>

            {{-- Kaydet --}}
            <div class="px-6 py-5 flex justify-end gap-3">
                <a href="{{ route('admin.arac.index') }}"
                   class="px-5 py-2 rounded-lg border border-gray-300 text-sm text-gray-600 hover:bg-gray-50">
                    İptal
                </a>
                <button type="submit"
                        class="btn-primary">
                    {{ $arac->exists ? 'Güncelle' : 'Kaydet' }}
                </button>
            </div>

        </div>
    </form>
</div>

<script>
// Marka → Model AJAX cascade
(function () {
    var markaEl = document.getElementById('marka-select');
    var modelEl = document.getElementById('model-select');
    var paketEl = document.getElementById('paket-select');
    if (!markaEl || !modelEl) return;

    markaEl.addEventListener('change', function () {
        var markaId = this.value;
        if (!markaId) {
            modelEl.innerHTML = '<option value="">— Önce Marka Seçin —</option>';
            if (paketEl) paketEl.innerHTML = '<option value="">— Önce Model Seçin —</option>';
            return;
        }
        modelEl.innerHTML = '<option value="">Yükleniyor...</option>';
        modelEl.disabled = true;

        fetch('{{ route("admin.api.modeller", ":id") }}'.replace(':id', markaId))
            .then(function (r) { return r.json(); })
            .then(function (modeller) {
                modelEl.innerHTML = modeller.length
                    ? modeller.map(function (m) {
                        return '<option value="' + m.id + '">' + m.ad + '</option>';
                    }).join('')
                    : '<option value="">Model bulunamadı</option>';
                modelEl.disabled = false;
                // Yeni model seçilince paketleri yükle
                modelEl.dispatchEvent(new Event('change'));
            })
            .catch(function () {
                modelEl.innerHTML = '<option value="">Hata oluştu</option>';
                modelEl.disabled = false;
            });
    });

    // Model → Paket AJAX cascade
    if (paketEl) {
        modelEl.addEventListener('change', function () {
            var modelId = this.value;
            if (!modelId) {
                paketEl.innerHTML = '<option value="">— Önce Model Seçin —</option>';
                return;
            }
            paketEl.innerHTML = '<option value="">Yükleniyor...</option>';
            paketEl.disabled = true;

            fetch('{{ route("admin.api.paketler", ":id") }}'.replace(':id', modelId))
                .then(function (r) { return r.json(); })
                .then(function (paketler) {
                    var opts = '<option value="">— Paket Seçin (isteğe bağlı) —</option>';
                    paketler.forEach(function (p) {
                        opts += '<option value="' + p.id + '"'
                            + ' data-yakit="' + (p.yakit_turu || '') + '"'
                            + ' data-vites="' + (p.vites_turu || '') + '"'
                            + ' data-hacmi="' + (p.motor_hacmi || '') + '"'
                            + ' data-gucu="' + (p.motor_gucu || '') + '"'
                            + '>' + p.ad + '</option>';
                    });
                    paketEl.innerHTML = opts;
                    paketEl.disabled = false;
                })
                .catch(function () {
                    paketEl.innerHTML = '<option value="">Hata oluştu</option>';
                    paketEl.disabled = false;
                });
        });

        // Paket seçilince teknik alanları doldur
        paketEl.addEventListener('change', function () {
            var opt = this.options[this.selectedIndex];
            var yakit  = opt.dataset.yakit  || '';
            var vites  = opt.dataset.vites  || '';
            var hacmi  = opt.dataset.hacmi  || '';
            var gucu   = opt.dataset.gucu   || '';

            setSelectVal('select[name="yakit_turu"]', yakit);
            setSelectVal('select[name="vites_turu"]', vites);
            setInputVal('input[name="motor_hacmi"]', hacmi);
            setInputVal('input[name="motor_gucu"]', gucu);
        });
    }

    function setSelectVal(selector, val) {
        var el = document.querySelector(selector);
        if (!el || !val) return;
        for (var i = 0; i < el.options.length; i++) {
            if (el.options[i].value === val) { el.selectedIndex = i; break; }
        }
    }

    function setInputVal(selector, val) {
        var el = document.querySelector(selector);
        if (el) el.value = val;
    }
}());

// Fotoğraf yükleme
(function () {
    var input     = document.getElementById('fotograf-input');
    var grid      = document.getElementById('preview-grid');
    var label     = document.getElementById('secilen-dosya-adi');
    var dropzone  = document.getElementById('dropzone');
    if (!input) return;

    var MAX = {{ $kalanSlot ?? 10 }};

    input.addEventListener('change', function () {
        showPreviews(this.files);
    });

    // Drag & drop
    dropzone.addEventListener('dragover', function (e) {
        e.preventDefault();
        this.classList.add('border-red-500', 'bg-red-50');
    });
    dropzone.addEventListener('dragleave', function () {
        this.classList.remove('border-red-500', 'bg-red-50');
    });
    dropzone.addEventListener('drop', function (e) {
        e.preventDefault();
        this.classList.remove('border-red-500', 'bg-red-50');
        var dt = new DataTransfer();
        var files = Array.from(e.dataTransfer.files).slice(0, MAX);
        files.forEach(function (f) { dt.items.add(f); });
        input.files = dt.files;
        showPreviews(input.files);
    });

    function showPreviews(files) {
        grid.innerHTML = '';
        if (!files || files.length === 0) {
            grid.classList.add('hidden');
            label.textContent = '';
            return;
        }
        label.textContent = files.length + ' dosya seçildi';
        grid.classList.remove('hidden');
        Array.from(files).slice(0, MAX).forEach(function (file, i) {
            var reader = new FileReader();
            reader.onload = function (e) {
                var wrap = document.createElement('div');
                wrap.className = 'relative rounded-lg overflow-hidden border-2 ' +
                    (i === 0 ? 'border-green-500' : 'border-transparent');
                var img = document.createElement('img');
                img.src = e.target.result;
                img.className = 'w-full h-24 object-cover';
                wrap.appendChild(img);
                if (i === 0) {
                    var badge = document.createElement('span');
                    badge.className = 'absolute top-1 left-1 bg-green-500 text-white text-[10px] font-bold px-1.5 py-0.5 rounded';
                    badge.textContent = 'Kapak';
                    wrap.appendChild(badge);
                }
                grid.appendChild(wrap);
            };
            reader.readAsDataURL(file);
        });
    }
}());
</script>

{{-- ===================== MODALLER ===================== --}}

{{-- Modal: Yeni Marka --}}
<div id="modal-marka" class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 hidden" role="dialog" aria-modal="true">
    <div class="bg-white rounded-xl shadow-xl w-full max-w-md mx-4 p-6">
        <h2 class="text-lg font-bold text-red-600 mb-4">Yeni Marka Ekle</h2>
        <div id="modal-marka-hata" class="hidden mb-3 bg-red-50 text-red-700 text-sm px-4 py-3 rounded-lg"></div>
        <div class="mb-4">
            <label class="block text-xs font-semibold text-gray-600 mb-1">Marka Adı *</label>
            <input type="text" id="modal-marka-ad" placeholder="Ör: Volkswagen"
                   class="input">
        </div>
        <div class="flex justify-end gap-3">
            <button type="button" onclick="closeModal('modal-marka')"
                    class="px-4 py-2 rounded-lg border border-gray-300 text-sm text-gray-600 hover:bg-gray-50">İptal</button>
            <button type="button" id="btn-marka-kaydet" onclick="submitMarka()"
                    class="btn-primary">Kaydet</button>
        </div>
    </div>
</div>

{{-- Modal: Yeni Model --}}
<div id="modal-model" class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 hidden" role="dialog" aria-modal="true">
    <div class="bg-white rounded-xl shadow-xl w-full max-w-md mx-4 p-6">
        <h2 class="text-lg font-bold text-red-600 mb-4">Yeni Model Ekle</h2>
        <div id="modal-model-hata" class="hidden mb-3 bg-red-50 text-red-700 text-sm px-4 py-3 rounded-lg"></div>
        <div class="mb-4">
            <label class="block text-xs font-semibold text-gray-600 mb-1">Model Adı *</label>
            <input type="text" id="modal-model-ad" placeholder="Ör: Golf"
                   class="input">
        </div>
        <div class="flex justify-end gap-3">
            <button type="button" onclick="closeModal('modal-model')"
                    class="px-4 py-2 rounded-lg border border-gray-300 text-sm text-gray-600 hover:bg-gray-50">İptal</button>
            <button type="button" id="btn-model-kaydet" onclick="submitModel()"
                    class="btn-primary">Kaydet</button>
        </div>
    </div>
</div>

{{-- Modal: Yeni Paket --}}
<div id="modal-paket" class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 hidden" role="dialog" aria-modal="true">
    <div class="bg-white rounded-xl shadow-xl w-full max-w-md mx-4 p-6">
        <h2 class="text-lg font-bold text-red-600 mb-4">Yeni Paket Ekle</h2>
        <div id="modal-paket-hata" class="hidden mb-3 bg-red-50 text-red-700 text-sm px-4 py-3 rounded-lg"></div>
        <div class="grid grid-cols-1 gap-3 mb-4">
            <div>
                <label class="block text-xs font-semibold text-gray-600 mb-1">Paket Adı *</label>
                <input type="text" id="modal-paket-ad" placeholder="Ör: 1.6 TDI 115 Trendline"
                       class="input">
            </div>
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1">Yakıt Türü</label>
                    <select id="modal-paket-yakit"
                            class="input">
                        <option value="">— Seçin —</option>
                        <option>Benzin</option>
                        <option>Dizel</option>
                        <option>Hibrit</option>
                        <option>Elektrik</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1">Vites</label>
                    <select id="modal-paket-vites"
                            class="input">
                        <option value="">— Seçin —</option>
                        <option>Manuel</option>
                        <option>Otomatik</option>
                    </select>
                </div>
            </div>
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1">Motor Hacmi</label>
                    <input type="text" id="modal-paket-hacmi" placeholder="Ör: 1.6"
                           class="input">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1">Motor Gücü (HP)</label>
                    <input type="number" id="modal-paket-gucu" placeholder="Ör: 115" min="0"
                           class="input">
                </div>
            </div>
        </div>
        <div class="flex justify-end gap-3">
            <button type="button" onclick="closeModal('modal-paket')"
                    class="px-4 py-2 rounded-lg border border-gray-300 text-sm text-gray-600 hover:bg-gray-50">İptal</button>
            <button type="button" id="btn-paket-kaydet" onclick="submitPaket()"
                    class="btn-primary">Kaydet</button>
        </div>
    </div>
</div>

<script>
(function () {
    var csrfToken = '{{ csrf_token() }}';

    // ---- Modal helpers ----
    window.openModal = function (id) {
        var el = document.getElementById(id);
        if (!el) return;
        el.classList.remove('hidden');
        // Reset hata
        var hata = document.getElementById(id + '-hata');
        if (hata) { hata.classList.add('hidden'); hata.textContent = ''; }
        // Focus ilk input
        var first = el.querySelector('input[type=text], input[type=number]');
        if (first) setTimeout(function () { first.focus(); }, 50);
    };

    window.closeModal = function (id) {
        var el = document.getElementById(id);
        if (el) el.classList.add('hidden');
    };

    // ESC ile kapat
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') {
            ['modal-marka', 'modal-model', 'modal-paket'].forEach(function (id) {
                closeModal(id);
            });
        }
    });

    // Overlay tıklaması ile kapat
    ['modal-marka', 'modal-model', 'modal-paket'].forEach(function (id) {
        var el = document.getElementById(id);
        if (!el) return;
        el.addEventListener('click', function (e) {
            if (e.target === el) closeModal(id);
        });
    });

    // ---- Buton bağlantıları ----
    var btnMarka = document.getElementById('btn-ekle-marka');
    var btnModel = document.getElementById('btn-ekle-model');
    var btnPaket = document.getElementById('btn-ekle-paket');
    var markaEl  = document.getElementById('marka-select');
    var modelEl  = document.getElementById('model-select');

    if (btnMarka) btnMarka.addEventListener('click', function () { openModal('modal-marka'); });
    if (btnModel) btnModel.addEventListener('click', function () {
        if (!this.disabled) openModal('modal-model');
    });
    if (btnPaket) btnPaket.addEventListener('click', function () {
        if (!this.disabled) openModal('modal-paket');
    });

    // Marka değişince model butonunu aç/kapat
    if (markaEl && btnModel) {
        markaEl.addEventListener('change', function () {
            var secilenVar = !!this.value;
            btnModel.disabled = !secilenVar;
            btnModel.title = secilenVar ? 'Yeni model ekle' : 'Önce marka seçin';
            if (btnPaket) { btnPaket.disabled = true; btnPaket.title = 'Önce model seçin'; }
        });
    }

    // Model değişince paket butonunu aç/kapat
    if (modelEl && btnPaket) {
        modelEl.addEventListener('change', function () {
            var secilenVar = !!this.value;
            btnPaket.disabled = !secilenVar;
            btnPaket.title = secilenVar ? 'Yeni paket ekle' : 'Önce model seçin';
        });
    }

    // ---- AJAX yardımcısı ----
    function ajaxPost(url, data, btnEl, btnLabel, onSuccess, onError) {
        btnEl.disabled = true;
        btnEl.textContent = 'Kaydediliyor...';

        fetch(url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json',
            },
            body: JSON.stringify(data),
        })
        .then(function (r) { return r.json().then(function (d) { return { ok: r.ok, data: d }; }); })
        .then(function (res) {
            btnEl.disabled = false;
            btnEl.textContent = btnLabel;
            if (res.ok && res.data.success) {
                onSuccess(res.data);
            } else {
                var msg = res.data.message || (res.data.errors ? Object.values(res.data.errors).flat().join(' ') : 'Bir hata oluştu.');
                onError(msg);
            }
        })
        .catch(function () {
            btnEl.disabled = false;
            btnEl.textContent = btnLabel;
            onError('Sunucu hatası. Lütfen tekrar deneyin.');
        });
    }

    function showHata(modalId, msg) {
        var el = document.getElementById(modalId + '-hata');
        if (!el) return;
        el.textContent = msg;
        el.classList.remove('hidden');
    }

    function addOption(selectEl, id, ad, dataAttrs) {
        var opt = document.createElement('option');
        opt.value = id;
        opt.textContent = ad;
        if (dataAttrs) {
            Object.keys(dataAttrs).forEach(function (k) { opt.dataset[k] = dataAttrs[k] || ''; });
        }
        selectEl.appendChild(opt);
        selectEl.value = id;
    }

    // ---- Marka kaydet ----
    window.submitMarka = function () {
        var adEl = document.getElementById('modal-marka-ad');
        var btn  = document.getElementById('btn-marka-kaydet');
        if (!adEl.value.trim()) { showHata('modal-marka', 'Marka adı zorunludur.'); return; }

        ajaxPost(
            '/admin/markalar',
            { ad: adEl.value.trim(), aktif: true, sira: 0 },
            btn, 'Kaydet',
            function (data) {
                var markaSelect = document.getElementById('marka-select');
                addOption(markaSelect, data.id, data.ad, null);
                markaSelect.dispatchEvent(new Event('change'));
                closeModal('modal-marka');
                adEl.value = '';
            },
            function (msg) { showHata('modal-marka', msg); }
        );
    };

    // ---- Model kaydet ----
    window.submitModel = function () {
        var adEl    = document.getElementById('modal-model-ad');
        var btn     = document.getElementById('btn-model-kaydet');
        var markaId = document.getElementById('marka-select').value;
        if (!adEl.value.trim()) { showHata('modal-model', 'Model adı zorunludur.'); return; }
        if (!markaId) { showHata('modal-model', 'Önce marka seçin.'); return; }

        ajaxPost(
            '/admin/markalar/' + markaId + '/modeller',
            { ad: adEl.value.trim(), aktif: true },
            btn, 'Kaydet',
            function (data) {
                var modelSelect = document.getElementById('model-select');
                // Eğer "Önce Marka Seçin" placeholder varsa temizle
                if (modelSelect.options.length === 1 && !modelSelect.options[0].value) {
                    modelSelect.innerHTML = '';
                }
                addOption(modelSelect, data.id, data.ad, null);
                modelSelect.dispatchEvent(new Event('change'));
                closeModal('modal-model');
                adEl.value = '';
            },
            function (msg) { showHata('modal-model', msg); }
        );
    };

    // ---- Paket kaydet ----
    window.submitPaket = function () {
        var adEl    = document.getElementById('modal-paket-ad');
        var btn     = document.getElementById('btn-paket-kaydet');
        var modelId = document.getElementById('model-select').value;
        if (!adEl.value.trim()) { showHata('modal-paket', 'Paket adı zorunludur.'); return; }
        if (!modelId) { showHata('modal-paket', 'Önce model seçin.'); return; }

        ajaxPost(
            '/admin/api/paketler/' + modelId,
            {
                ad:          adEl.value.trim(),
                yakit_turu:  document.getElementById('modal-paket-yakit').value || null,
                vites_turu:  document.getElementById('modal-paket-vites').value || null,
                motor_hacmi: document.getElementById('modal-paket-hacmi').value || null,
                motor_gucu:  document.getElementById('modal-paket-gucu').value  || null,
            },
            btn, 'Kaydet',
            function (data) {
                var paketSelect = document.getElementById('paket-select');
                // Placeholder temizle
                if (paketSelect.options.length === 1 && !paketSelect.options[0].value) {
                    paketSelect.innerHTML = '<option value="">— Paket Seçin (isteğe bağlı) —</option>';
                }
                addOption(paketSelect, data.id, data.ad, {
                    yakit: data.yakit_turu,
                    vites: data.vites_turu,
                    hacmi: data.motor_hacmi,
                    gucu:  data.motor_gucu,
                });
                paketSelect.dispatchEvent(new Event('change'));
                closeModal('modal-paket');
                // Formu sıfırla
                adEl.value = '';
                document.getElementById('modal-paket-yakit').value = '';
                document.getElementById('modal-paket-vites').value = '';
                document.getElementById('modal-paket-hacmi').value = '';
                document.getElementById('modal-paket-gucu').value  = '';
            },
            function (msg) { showHata('modal-paket', msg); }
        );
    };

    // Enter tuşu ile kaydet (modaller)
    ['modal-marka', 'modal-model', 'modal-paket'].forEach(function (id) {
        var el = document.getElementById(id);
        if (!el) return;
        el.addEventListener('keydown', function (e) {
            if (e.key === 'Enter') {
                if (id === 'modal-marka') submitMarka();
                else if (id === 'modal-model') submitModel();
                else if (id === 'modal-paket') submitPaket();
            }
        });
    });
}());
</script>

</body>
</html>
