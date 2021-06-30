<?php

namespace App\Console\Commands;

use App\Models\Item;
use GuzzleHttp\Client;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use PHPHtmlParser\Dom;
use PHPHtmlParser\Options;

class CreateWarframeCrafting extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'wf:crafting';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get all items from warframe wiki';

    protected $exclude = [];

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
        $warframes = Item::where('type', 'warframe')->get();

        foreach ($warframes as $warframe) {
            if($warframe->name === 'Equinox') {
                Item::updateOrCreate(['key' => $warframe->key . "_night_neuroptics_blueprint"], [
                    'name' => $warframe->name . " Night Neuroptics Blueprint",
                    'url' => 'images/components/neuroptics.webp',
                    'type' => "blueprint"
                ]);
                Item::updateOrCreate(['key' => $warframe->key . "_night_chassis_blueprint"], [
                    'name' => $warframe->name . " Night Chassis Blueprint",
                    'url' => 'images/components/chassis.webp',
                    'type' => "blueprint"
                ]);
                Item::updateOrCreate(['key' => $warframe->key . "_night_systems_blueprint"], [
                    'name' => $warframe->name . " Night System Blueprint",
                    'url' => 'images/components/systems.webp',
                    'type' => "blueprint"
                ]);
                Item::updateOrCreate(['key' => $warframe->key . "_day_neuroptics_blueprint"], [
                    'name' => $warframe->name . " Day Neuroptics Blueprint",
                    'url' => 'images/components/neuroptics.webp',
                    'type' => "blueprint"
                ]);
                Item::updateOrCreate(['key' => $warframe->key . "_day_chassis_blueprint"], [
                    'name' => $warframe->name . " Day Chassis Blueprint",
                    'url' => 'images/components/chassis.webp',
                    'type' => "blueprint"
                ]);
                Item::updateOrCreate(['key' => $warframe->key . "_day_system_blueprint"], [
                    'name' => $warframe->name . " Day System Blueprint",
                    'url' => 'images/components/systems.webp',
                    'type' => "blueprint"
                ]);

                Item::updateOrCreate(['key' => $warframe->key . "_day_aspect_blueprint"], [
                    'name' => $warframe->name . " Day Aspect Blueprint",
                    'url' => 'images/components/equinox_day_aspect.webp',
                    'type' => "blueprint"
                ]);
                Item::updateOrCreate(['key' => $warframe->key . "_night_aspect_blueprint"], [
                    'name' => $warframe->name . " Night Aspect Blueprint",
                    'url' => 'images/components/equinox_night_aspect.webp',
                    'type' => "blueprint"
                ]);

                Item::updateOrCreate(['key' => $warframe->key . "_night_neuroptics"], [
                    'name' => $warframe->name . " Night Neuroptics",
                    'url' => 'images/components/neuroptics.webp',
                    'type' => "component"
                ]);
                Item::updateOrCreate(['key' => $warframe->key . "_night_chassis"], [
                    'name' => $warframe->name . " Night Chassis",
                    'url' => 'images/components/chassis.webp',
                    'type' => "component"
                ]);
                Item::updateOrCreate(['key' => $warframe->key . "_night_systems"], [
                    'name' => $warframe->name . " Night Systems",
                    'url' => 'images/components/systems.webp',
                    'type' => "component"
                ]);
                Item::updateOrCreate(['key' => $warframe->key . "_day_neuroptics"], [
                    'name' => $warframe->name . " Day Neuroptics",
                    'url' => 'images/components/neuroptics.webp',
                    'type' => "component"
                ]);
                Item::updateOrCreate(['key' => $warframe->key . "_day_chassis"], [
                    'name' => $warframe->name . " Day Chassis",
                    'url' => 'images/components/chassis.webp',
                    'type' => "component"
                ]);
                Item::updateOrCreate(['key' => $warframe->key . "_day_systems"], [
                    'name' => $warframe->name . " Day Systems",
                    'url' => 'images/components/systems.webp',
                    'type' => "component"
                ]);

                Item::updateOrCreate(['key' => $warframe->key . "_day_aspect"], [
                    'name' => $warframe->name . " Day Aspect",
                    'url' => 'images/components/equinox_day_aspect.webp',
                    'type' => "component"
                ]);
                Item::updateOrCreate(['key' => $warframe->key . "_night_aspect"], [
                    'name' => $warframe->name . " Night Aspect",
                    'url' => 'images/components/equinox_night_aspect.webp',
                    'type' => "component"
                ]);
            } else {
                Item::updateOrCreate(['key' => $warframe->key . "_neuroptics_blueprint"], [
                    'name' => $warframe->name . " Neuroptics Blueprint",
                    'url' => 'images/components/neuroptics.webp',
                    'type' => "blueprint"
                ]);
                Item::updateOrCreate(['key' => $warframe->key . "_chassis_blueprint"], [
                    'name' => $warframe->name . " Chassis Blueprint",
                    'url' => 'images/components/chassis.webp',
                    'type' => "blueprint"
                ]);
                Item::updateOrCreate(['key' => $warframe->key . "_systems_blueprint"], [
                    'name' => $warframe->name . " Systems Blueprint",
                    'url' => 'images/components/systems.webp',
                    'type' => "blueprint"
                ]);

                Item::updateOrCreate(['key' => $warframe->key . "_systems"], [
                    'name' => $warframe->name . " Neuroptics",
                    'url' => 'images/components/neuroptics.webp',
                    'type' => "component"
                ]);
                Item::updateOrCreate(['key' => $warframe->key . "_systems"], [
                    'name' => $warframe->name . " Chassis",
                    'url' => 'images/components/chassis.webp',
                    'type' => "component"
                ]);
                Item::updateOrCreate(['key' => $warframe->key . "_systems"], [
                    'name' => $warframe->name . " Systems",
                    'url' => 'images/components/systems.webp',
                    'type' => "component"
                ]);
            }

            Item::updateOrCreate(['key' => $warframe->key . "_blueprint"], [
                'name' => $warframe->name . " Blueprint",
                'type' => "blueprint",
                'url' => $warframe->url
            ]);
        }

        $weapons = Item::whereIn('type', ['primary', 'secondary', 'melee'])->get();
        foreach ($weapons as $weapon) {
            Item::updateOrCreate(['key' => $weapon->key], [
                'name' => $weapon->name . " Blueprint",
                'type' => "blueprint",
                'url' => $weapon->url
            ]);
        }

        return 0;
    }
}
