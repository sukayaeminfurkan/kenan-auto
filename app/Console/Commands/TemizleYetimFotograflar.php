<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use App\Models\AracFotograf;

class TemizleYetimFotograflar extends Command
{
    protected $signature   = 'temizle:yetim-fotograflar';
    protected $description = 'DB kaydı olmayan yetim araç fotoğraflarını storage\'dan siler';

    public function handle(): int
    {
        $diskDosyalar = Storage::disk('public')->files('araclar');

        if (empty($diskDosyalar)) {
            $this->info('storage/app/public/araclar/ klasörü boş veya bulunamadı.');
            return 0;
        }

        // DB'deki kayıtlı yolları hızlı arama için flip et
        $dbYollar = AracFotograf::pluck('dosya_yolu')
            ->map(fn($p) => trim($p, '/'))
            ->flip();

        $silinen = 0;
        $korunan = 0;

        foreach ($diskDosyalar as $dosya) {
            if ($dbYollar->has($dosya)) {
                $korunan++;
            } else {
                Storage::disk('public')->delete($dosya);
                $this->line("  Silindi: {$dosya}");
                $silinen++;
            }
        }

        $this->newLine();
        $this->info("Tamamlandi — Silinen: {$silinen} | Korunan: {$korunan}");

        return 0;
    }
}
