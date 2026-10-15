<?php

namespace Database\Seeders;

use App\Models\AracModel;
use App\Models\Marka;
use App\Models\Paket;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PaketSeeder extends Seeder
{
    public function run(): void
    {
        $veri = [
            'Dacia' => [
                'Duster' => [
                    '1.0 TCe 90 Essential Manuel',
                    '1.0 TCe 90 Expression Manuel',
                    '1.2 TCe 130 Expression Manuel',
                    '1.2 TCe 130 Expression Otomatik',
                    '1.2 TCe 130 Extreme Otomatik',
                ],
                'Sandero Stepway' => [
                    '1.0 SCe 65 Essential Manuel',
                    '1.0 TCe 90 Expression Manuel',
                    '1.0 TCe 90 Extreme Manuel',
                ],
            ],
            'Renault' => [
                'Megane' => [
                    '1.3 TCe 140 Joy Manuel',
                    '1.3 TCe 140 Touch Manuel',
                    '1.3 TCe 140 Touch Otomatik',
                    '1.3 TCe 160 RS Line Otomatik',
                    '1.6 E-Tech 160 Plug-in Hybrid',
                ],
                'Clio' => [
                    '1.0 SCe 65 Joy Manuel',
                    '1.0 TCe 90 Joy Manuel',
                    '1.0 TCe 90 Touch Manuel',
                    '1.0 TCe 90 RS Line Manuel',
                    '1.6 E-Tech 140 Hibrit Otomatik',
                ],
                'Taliant' => [
                    '1.0 TCe 90 Joy Manuel',
                    '1.0 TCe 90 Touch Manuel',
                    '1.0 TCe 90 Touch Otomatik',
                    '1.3 TCe 130 Touch Otomatik',
                ],
            ],
            'Volkswagen' => [
                'Golf' => [
                    '1.0 TSI 110 Life Manuel',
                    '1.0 TSI 110 Style Otomatik',
                    '1.5 TSI 130 Life Manuel',
                    '1.5 TSI 150 Style Otomatik',
                    '1.5 TSI 150 R-Line Otomatik',
                    '2.0 TSI 245 GTI Otomatik',
                ],
                'Passat' => [
                    '1.5 TSI 150 Elegance Otomatik',
                    '2.0 TDI 150 Business Otomatik',
                    '2.0 TDI 150 Elegance Otomatik',
                    '2.0 TDI 200 R-Line Otomatik',
                ],
                'Tiguan' => [
                    '1.5 TSI 130 Life Manuel',
                    '1.5 TSI 150 Elegance Otomatik',
                    '1.5 TSI 150 R-Line Otomatik',
                    '2.0 TDI 150 Life Otomatik',
                    '2.0 TDI 200 R-Line Otomatik',
                ],
                'Taigo' => [
                    '1.0 TSI 95 Life Manuel',
                    '1.0 TSI 110 Style Otomatik',
                    '1.5 TSI 150 R-Line Otomatik',
                ],
            ],
            'Skoda' => [
                'Octavia' => [
                    '1.0 TSI 110 Active Manuel',
                    '1.5 TSI 150 Ambition Otomatik',
                    '1.5 TSI 150 Style Otomatik',
                    '2.0 TDI 150 Style Otomatik',
                    '2.0 TSI 245 RS Otomatik',
                ],
                'Fabia' => [
                    '1.0 MPI 65 Active Manuel',
                    '1.0 TSI 95 Ambition Manuel',
                    '1.0 TSI 110 Style Manuel',
                    '1.0 TSI 110 Style Otomatik',
                ],
                'Kamiq' => [
                    '1.0 TSI 95 Active Manuel',
                    '1.0 TSI 110 Ambition Otomatik',
                    '1.5 TSI 150 Style Otomatik',
                ],
                'Kodiaq' => [
                    '2.0 TDI 150 Ambition Otomatik',
                    '2.0 TDI 200 Style Otomatik',
                    '2.0 TSI 190 Sportline Otomatik',
                ],
            ],
            'Ford' => [
                'Focus' => [
                    '1.0 EcoBoost 100 Trend Manuel',
                    '1.0 EcoBoost 125 Trend Otomatik',
                    '1.5 EcoBlue 120 Titanium Manuel',
                    '1.5 EcoBlue 120 ST-Line Otomatik',
                    '2.3 EcoBoost 280 ST Otomatik',
                ],
                'Puma' => [
                    '1.0 EcoBoost 125 Trend Manuel',
                    '1.0 EcoBoost 125 Titanium Otomatik',
                    '1.0 EcoBoost 155 ST-Line Otomatik',
                    '1.0 EcoBoost mHEV 155 ST-Line Otomatik',
                ],
                'Kuga' => [
                    '1.5 EcoBoost 150 Trend Otomatik',
                    '1.5 EcoBoost 150 Titanium Otomatik',
                    '2.5 Duratec PHEV 225 ST-Line Otomatik',
                    '2.5 Duratec PHEV 225 Titanium Otomatik',
                ],
                'Fiesta' => [
                    '1.0 EcoBoost 95 Trend Manuel',
                    '1.0 EcoBoost 125 Titanium Manuel',
                    '1.5 TDCi 85 Trend Manuel',
                ],
            ],
            'Toyota' => [
                'Corolla' => [
                    '1.8 Hybrid 122 Dream Otomatik',
                    '1.8 Hybrid 122 Flame Otomatik',
                    '1.8 Hybrid 122 Vision Otomatik',
                    '2.0 Hybrid 196 GR Sport Otomatik',
                ],
                'Yaris' => [
                    '1.5 Hybrid 116 Dream Otomatik',
                    '1.5 Hybrid 116 Flame Otomatik',
                    '1.5 Hybrid 116 Vision Otomatik',
                    '1.5 Hybrid 116 GR Sport Otomatik',
                ],
                'C-HR' => [
                    '1.8 Hybrid 122 Flame Otomatik',
                    '2.0 Hybrid 184 GR Sport Otomatik',
                    '2.0 Hybrid 184 Premiere Otomatik',
                ],
                'RAV4' => [
                    '2.5 Hybrid 218 Dream Otomatik',
                    '2.5 Hybrid 218 Flame Otomatik',
                    '2.5 PHEV 306 GR Sport Otomatik',
                ],
            ],
            'Honda' => [
                'Civic' => [
                    '1.0 VTEC Turbo 126 Elegance Manuel',
                    '1.5 VTEC Turbo 182 Sport Otomatik',
                    '1.5 VTEC Turbo 182 Executive Otomatik',
                    '2.0 e:HEV 184 Advance Otomatik',
                ],
                'HR-V' => [
                    '1.5 e:HEV 131 Elegance Otomatik',
                    '1.5 e:HEV 131 Advance Otomatik',
                ],
            ],
            'Hyundai' => [
                'i20' => [
                    '1.0 T-GDI 100 Style Manuel',
                    '1.0 T-GDI 120 Elite Manuel',
                    '1.0 T-GDI 120 Elite Otomatik',
                ],
                'Tucson' => [
                    '1.6 T-GDI 150 Style Otomatik',
                    '1.6 T-GDI 230 Elite Hibrit Otomatik',
                    '1.6 CRDi 136 Style Otomatik',
                ],
                'i30' => [
                    '1.0 T-GDI 120 Style Manuel',
                    '1.5 T-GDI 160 Elite Otomatik',
                    '2.0 T-GDI 280 N Otomatik',
                ],
            ],
            'Kia' => [
                'Sportage' => [
                    '1.6 T-GDI 150 Concept Manuel',
                    '1.6 T-GDI 230 GT-Line Hibrit Otomatik',
                    '1.6 CRDi 136 Concept Otomatik',
                ],
                'Ceed' => [
                    '1.0 T-GDI 120 Cool Manuel',
                    '1.5 T-GDI 160 GT-Line Otomatik',
                ],
            ],
            'Opel' => [
                'Astra' => [
                    '1.2 Turbo 110 Edition Manuel',
                    '1.2 Turbo 130 GS Line Otomatik',
                    '1.5 CDTi 130 GS Line Otomatik',
                    '1.6 Hybrid 180 GS Line Otomatik',
                ],
                'Crossland' => [
                    '1.2 PureTech 83 Edition Manuel',
                    '1.2 Turbo 110 GS Line Otomatik',
                    '1.5 CDTi 110 Edition Manuel',
                ],
            ],
            'Peugeot' => [
                '308' => [
                    '1.2 PureTech 130 Active Otomatik',
                    '1.5 BlueHDi 130 Allure Otomatik',
                    '1.6 HYbrid 180 GT Otomatik',
                ],
                '2008' => [
                    '1.2 PureTech 100 Active Manuel',
                    '1.2 PureTech 130 Allure Otomatik',
                    '1.5 BlueHDi 130 GT Otomatik',
                ],
            ],
            'Citroen' => [
                'C3' => [
                    '1.2 PureTech 83 Feel Manuel',
                    '1.2 PureTech 110 Shine Otomatik',
                ],
                'C5 Aircross' => [
                    '1.2 PureTech 130 Feel Otomatik',
                    '1.5 BlueHDi 130 Shine Otomatik',
                    '1.6 Hybrid 225 Shine Otomatik',
                ],
            ],
            'Nissan' => [
                'Qashqai' => [
                    '1.3 DIG-T 140 Visia Manuel',
                    '1.3 DIG-T 158 Acenta Otomatik',
                    '1.5 e-Power 190 N-Connecta Otomatik',
                    '1.5 e-Power 190 Tekna Otomatik',
                ],
                'Juke' => [
                    '1.0 DIG-T 114 Visia Manuel',
                    '1.0 DIG-T 114 Acenta Otomatik',
                    '1.6 Hybrid 143 N-Connecta Otomatik',
                ],
            ],
            'Seat' => [
                'Ibiza' => [
                    '1.0 MPI 80 Reference Manuel',
                    '1.0 TSI 95 Style Manuel',
                    '1.0 TSI 110 FR Otomatik',
                ],
                'Leon' => [
                    '1.0 TSI 110 Reference Manuel',
                    '1.5 TSI 150 FR Otomatik',
                    '1.5 TSI 150 Xcellence Otomatik',
                    '2.0 TSI 300 Cupra Otomatik',
                ],
            ],
            'BMW' => [
                '3 Serisi' => [
                    '318i 136 Advantage Otomatik',
                    '320i 184 M Sport Otomatik',
                    '330i 258 M Sport Otomatik',
                    '320d 190 Luxury Line Otomatik',
                ],
                '5 Serisi' => [
                    '520i 170 Luxury Line Otomatik',
                    '530i 252 M Sport Otomatik',
                    '520d 190 Luxury Line Otomatik',
                ],
                '1 Serisi' => [
                    '116i 109 Edition Otomatik',
                    '118i 136 M Sport Otomatik',
                ],
            ],
            'Mercedes-Benz' => [
                'C-Class' => [
                    'C 180 170 Avantgarde Otomatik',
                    'C 200 204 AMG Line Otomatik',
                    'C 220d 200 AMG Line Otomatik',
                    'C 300 258 AMG Line Otomatik',
                ],
                'E-Class' => [
                    'E 200 204 Avantgarde Otomatik',
                    'E 220d 200 AMG Line Otomatik',
                    'E 300 258 AMG Line Otomatik',
                ],
                'A-Class' => [
                    'A 180 136 Style Otomatik',
                    'A 200 163 AMG Line Otomatik',
                    'A 35 AMG 306 AMG Otomatik',
                ],
            ],
            'Audi' => [
                'A3' => [
                    '30 TFSI 110 Advanced Manuel',
                    '35 TFSI 150 S Line Otomatik',
                    '40 TDI 200 S Line Otomatik',
                ],
                'A4' => [
                    '35 TFSI 150 Advanced Otomatik',
                    '40 TDI 204 S Line Otomatik',
                    '45 TFSI 245 S Line Otomatik',
                ],
                'Q3' => [
                    '35 TFSI 150 Advanced Otomatik',
                    '40 TDI 200 S Line Otomatik',
                ],
            ],
        ];

        foreach ($veri as $markaAd => $modeller) {
            $marka = Marka::firstOrCreate(
                ['slug' => $this->slug($markaAd)],
                ['ad' => $markaAd, 'aktif' => true, 'sira' => 0]
            );

            foreach ($modeller as $modelAd => $paketler) {
                $model = AracModel::firstOrCreate(
                    ['marka_id' => $marka->id, 'slug' => $this->slug($modelAd)],
                    ['ad' => $modelAd, 'aktif' => true]
                );

                foreach ($paketler as $paketAd) {
                    Paket::firstOrCreate(
                        ['model_id' => $model->id, 'ad' => $paketAd],
                        $this->parseAd($paketAd)
                    );
                }
            }
        }
    }

    private function parseAd(string $ad): array
    {
        $vites = null;
        if (str_ends_with($ad, 'Manuel')) {
            $vites = 'Manuel';
        } elseif (str_ends_with($ad, 'Otomatik')) {
            $vites = 'Otomatik';
        }

        // Motor hacmi: başta ondalıklı sayı (ör. "1.5", "2.0")
        $motorHacmi = null;
        if (preg_match('/^(\d+\.\d+)\s/', $ad, $m)) {
            $motorHacmi = $m[1];
        }

        // Motor gücü: string içindeki ilk tam sayı (HP değeri)
        $motorGucu = null;
        if (preg_match('/\b(\d{2,3})\b/', $ad, $m)) {
            $motorGucu = (int) $m[1];
        }

        $yakit = $this->inferYakit($ad);

        return [
            'yakit_turu'  => $yakit,
            'vites_turu'  => $vites,
            'motor_hacmi' => $motorHacmi,
            'motor_gucu'  => $motorGucu,
            'aktif'       => true,
        ];
    }

    private function inferYakit(string $ad): string
    {
        $lower = strtolower($ad);

        $dizel = ['tdi', 'cdti', 'tdci', 'bluehdi', 'crdi', 'ecoblue', '220d', '320d', '520d', '40 tdi', '40tdi'];
        foreach ($dizel as $k) {
            if (str_contains($lower, $k)) {
                return 'Dizel';
            }
        }

        $hibrit = ['hybrid', 'hibrit', 'e-tech', 'e:hev', 'e-power', 'phev', 'mhev'];
        foreach ($hibrit as $k) {
            if (str_contains($lower, $k)) {
                return 'Hibrit';
            }
        }

        return 'Benzin';
    }

    private function slug(string $str): string
    {
        $tr = ['ş', 'Ş', 'ı', 'İ', 'ğ', 'Ğ', 'ü', 'Ü', 'ö', 'Ö', 'ç', 'Ç'];
        $en = ['s', 'S', 'i', 'I', 'g', 'G', 'u', 'U', 'o', 'O', 'c', 'C'];
        return Str::slug(str_replace($tr, $en, $str));
    }
}
