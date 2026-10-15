<?php

namespace Database\Seeders;

use App\Models\AracModel;
use App\Models\Marka;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class MarkaModelSeeder extends Seeder
{
    public function run(): void
    {
        $veri = [
            'BMW'           => ['1 Serisi','2 Serisi','3 Serisi','4 Serisi','5 Serisi','7 Serisi','X1','X3','X5','X6'],
            'Mercedes-Benz' => ['A Serisi','B Serisi','C Serisi','E Serisi','S Serisi','GLA','GLC','GLE','CLA','Vito'],
            'Audi'          => ['A1','A3','A4','A5','A6','Q2','Q3','Q5','Q7','TT'],
            'Toyota'        => ['Corolla','Yaris','Camry','RAV4','C-HR','Land Cruiser','Hilux','Auris','Prius','Verso'],
            'Honda'         => ['Civic','Jazz','CR-V','HR-V','Accord','City','FR-V','Legend','Insight','Element'],
            'Ford'          => ['Fiesta','Focus','Mondeo','Puma','Kuga','Edge','Ranger','Transit','EcoSport','Mustang'],
            'Volkswagen'    => ['Polo','Golf','Passat','Tiguan','T-Roc','T-Cross','Touareg','Caddy','Transporter','Arteon'],
            'Renault'       => ['Clio','Megane','Kadjar','Captur','Scenic','Talisman','Zoe','Twingo','Laguna','Symbol'],
            'Fiat'          => ['500','Egea','Tipo','Doblo','Panda','Bravo','Linea','Freemont','500X','Punto'],
            'Hyundai'       => ['i10','i20','i30','Elantra','Tucson','Santa Fe','Kona','Sonata','Accent','Ioniq'],
            'Kia'           => ['Picanto','Rio','Ceed','Sportage','Sorento','Stinger','Niro','Stonic','Carnival','EV6'],
            'Opel'          => ['Corsa','Astra','Insignia','Mokka','Crossland','Grandland','Meriva','Zafira','Vectra','Combo'],
            'Peugeot'       => ['208','308','508','2008','3008','5008','Partner','Expert','108','107'],
            'Citroen'       => ['C1','C3','C4','C5','C3 Aircross','C5 Aircross','Berlingo','Jumpy','DS3','DS4'],
            'Nissan'        => ['Micra','Note','Juke','Qashqai','X-Trail','Navara','Pulsar','Leaf','370Z','Pathfinder'],
            'Volvo'         => ['S40','S60','S90','V40','V60','XC40','XC60','XC90','V90','C30'],
            'Skoda'         => ['Fabia','Octavia','Superb','Rapid','Scala','Kamiq','Karoq','Kodiaq','Citigo','Enyaq'],
            'Seat'          => ['Ibiza','Leon','Toledo','Arona','Ateca','Tarraco','Alhambra','Mii','Altea','Exeo'],
            'Dacia'         => ['Sandero','Logan','Duster','Lodgy','Dokker','Spring','Jogger','Logan MCV','Bigster','Pick-Up'],
            'Mitsubishi'    => ['Colt','Lancer','Outlander','ASX','Eclipse Cross','Pajero','L200','Galant','Carisma','Space Star'],
            'Mazda'         => ['Mazda2','Mazda3','Mazda6','CX-3','CX-5','CX-30','MX-5','CX-60','BT-50','RX-8'],
            'Subaru'        => ['Impreza','Legacy','Outback','Forester','XV','WRX','BRZ','Tribeca','Levorg','Ascent'],
            'Jeep'          => ['Renegade','Compass','Cherokee','Grand Cherokee','Wrangler','Gladiator','Commander','Avenger','Patriot','Liberty'],
            'Land Rover'    => ['Discovery','Discovery Sport','Defender','Freelander','Range Rover','Range Rover Sport','Range Rover Evoque','Range Rover Velar','Series I','Series II'],
            'Porsche'       => ['911','Cayenne','Macan','Panamera','Taycan','Cayman','Boxster','718 Cayman','718 Boxster','Cayenne Coupe'],
            'Alfa Romeo'    => ['Giulia','Stelvio','Tonale','Giulietta','159','147','MiTo','156','Brera','Spider'],
        ];

        $sira = 1;
        foreach ($veri as $markaAd => $modeller) {
            $marka = Marka::firstOrCreate(
                ['slug' => $this->slug($markaAd)],
                ['ad' => $markaAd, 'aktif' => true, 'sira' => $sira++]
            );

            foreach ($modeller as $modelAd) {
                AracModel::firstOrCreate(
                    ['marka_id' => $marka->id, 'slug' => $this->slug($modelAd)],
                    ['ad' => $modelAd, 'aktif' => true]
                );
            }
        }
    }

    private function slug(string $str): string
    {
        $tr = ['ş','Ş','ı','İ','ğ','Ğ','ü','Ü','ö','Ö','ç','Ç'];
        $en = ['s','S','i','I','g','G','u','U','o','O','c','C'];
        return Str::slug(str_replace($tr, $en, $str));
    }
}
