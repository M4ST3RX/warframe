<?php

namespace App\Console\Commands;

use App\Models\Item;
use GuzzleHttp\Client;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use PHPHtmlParser\Dom;
use PHPHtmlParser\Options;

class InsertResources extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'wf:resources';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get all items from warframe wiki';

    protected $items = ['Alloy Plate', 'Ferrite', 'Nano Spores', 'Salvage', 'Circuits', 'Cryotic', 'Hexenon', 'Oxium', 'Plastids', 'Polymer Bundle',
        'Rubedo', 'Argon Crystal', 'Control Module', 'Gallium', 'Morphics', 'Neural Sensors', 'Neurodes', 'Orokin Cell', 'Tellurium',
        'Detonite Ampule', 'Detonite Injector', 'Fieldron Sample', 'Fieldron', 'Mutagen Sample', 'Mutagen Mass', 'Kuva', 'Javlok Capacitor', 'Nitain Extract',
        'Kavat Genetic Code', 'Forma', 'Tempered Bapholite', 'Purified Heciphron', 'Dendrite Blastoma', 'Adramal Alloy', 'Pustulent Cognitive Nodule',
        'Fersteel Alloy', 'Nistlepod', 'Fish Scales', 'Tear Azurite', 'Pyrotic Alloy', 'Titanium', 'Carbides', 'Isos', 'Nullstones', 'Cubic Diodes',
        'Tepa Nodule', 'Heart Noctrul', 'Tromyzon Entroplasma', 'Scintillant', 'Ocular Stem-Root', 'Stellated Necrathene', 'Mytocardia Spore', 'Travocyte Alloy',
        'Scrubber Exa Brain', 'Breath Of The Eidolon', 'Marquise Veridos', 'Grokdrul', 'Irdite', 'Maprico', 'Condroc Wing', 'Kuaka Spinal Claw', 'Cetus Wisp',
        'Auroxium Alloy', 'Coprite Alloy', 'Star Crimzian', 'Esher Devar', 'Heart Nyth', 'Radian Sentirum', 'Fish Meat', 'Fish Oil', 'Charc Electroplax',
        'Cuthol Tendrils', 'Goopolla Spleen', 'Karkina Antenna', 'Khut-Khut Venom Sac', 'Mawfish Bones', 'Mortus Horn', 'Murkray Liver', 'Norg Brain',
        'Seram Beetle Shell', 'Sharrac Teeth', 'Tralok Eyes', 'Yogwun Stomach', 'Eidolon Shard', 'Gorgaricus Spore', 'Thermal Sludge', 'Atmo Systems',
        'Gyromag Systems', 'Repeller Systems', 'Axidrol Alloy', 'Hespazym Alloy', 'Travocyte Alloy', 'Venerdo Alloy', 'Goblite Tears', 'Star Amarast',
        'Heart Noctrul', 'Smooth Phasmin', 'Radiant Zodian', 'Marquise Thyst', 'Echowinder Anoscopic Sensor', 'Tink Dissipator Coil',
        'Synathid Ecosynth Analyzer', 'Tromyzon Entroplasma', 'Scrubber Exa Brain', 'Longwinder Lathe Coagulant', 'Brickie Muon Battery',
        'Recaster Neural Relay', 'Mirewinder Parallel Biode', 'Eye-Eye Rotoblade', 'Charamote Sagan Module', 'Kriller Thermal Laser', 'Sapcaddy Venedo Case',
        'Calda Toroid', 'Vega Toroid', 'Sola Toroid', 'Crizma Toroid', 'Lazulite Toroid', 'Pustulite', 'Ganglion', 'Lucent Teroglobe', 'Seriglass Shard',
        'Vome Residue', 'Fass Residue', 'Devolved Namalon', 'Thaumic Distillate', 'Purged Dagonic', 'Cabochon Embolos', 'Purified Heciphron', 'Faceted Tiametrite',
        'Trapezium Xenorhast', 'Benign Infested Tumor', 'Ferment Bladder', 'Tubercular Gill System', 'Dendrite Blastoma', 'Cranial Foremount', 'Biotic Filter',
        'Parasitic Tethermaw', 'Saturated Muscle Mass', 'Spinal Core Section', 'Sporulate Sac', 'Waxen Sebum Deposit', 'Ducats'];

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        foreach ($this->items as $item) {
            Item::firstOrCreate([
                'key' => strtolower(str_replace(' ', '_', $item))
            ], [
                'name' => $item,
                'key' => strtolower(str_replace(' ', '_', $item)),
                'type' => 'resource',
                'url' => "images/resources/".strtolower(str_replace(' ', '_', $item)).".webp"
            ]);
        }

        return 0;
    }
}
