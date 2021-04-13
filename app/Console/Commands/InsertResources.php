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
        'Kavat Genetic Code', 'Forma'];

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
            $items = new Item();
            $items->name = $item;
            $items->key = strtolower(str_replace(' ', '_', $item));
            $items->type = "resource";
            $items->url = "images/resources/".strtolower(str_replace(' ', '_', $item)).".png";
            $items->save();
        }

        return 0;
    }
}
