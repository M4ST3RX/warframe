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
                $neuro = new Item();
                $neuro->name = $warframe->name . " Night Neuroptics Blueprint";
                $neuro->key = $warframe->key . "_night_neuroptics_blueprint";
                $neuro->type = "blueprint";
                $neuro->save();

                $chassis = new Item();
                $chassis->name = $warframe->name . " Night Chassis Blueprint";
                $chassis->key = $warframe->key . "_night_chassis_blueprint";
                $chassis->type = "blueprint";
                $chassis->save();

                $sys = new Item();
                $sys->name = $warframe->name . " Night System Blueprint";
                $sys->key = $warframe->key . "_night_system_blueprint";
                $sys->type = "blueprint";
                $sys->save();

                $neuro = new Item();
                $neuro->name = $warframe->name . " Day Neuroptics Blueprint";
                $neuro->key = $warframe->key . "_day_neuroptics_blueprint";
                $neuro->type = "blueprint";
                $neuro->save();

                $chassis = new Item();
                $chassis->name = $warframe->name . " Day Chassis Blueprint";
                $chassis->key = $warframe->key . "_day_chassis_blueprint";
                $chassis->type = "blueprint";
                $chassis->save();

                $sys = new Item();
                $sys->name = $warframe->name . " Day System Blueprint";
                $sys->key = $warframe->key . "_day_system_blueprint";
                $sys->type = "blueprint";
                $sys->save();

                $bp = new Item();
                $bp->name = $warframe->name . " Day Aspect Blueprint";
                $bp->key = $warframe->key . "_day_aspect_blueprint";
                $bp->type = "blueprint";
                $bp->save();

                $bp = new Item();
                $bp->name = $warframe->name . " Night Aspect Blueprint";
                $bp->key = $warframe->key . "_night_aspect_blueprint";
                $bp->type = "blueprint";
                $bp->save();

                $neuro = new Item();
                $neuro->name = $warframe->name . " Night Neuroptics";
                $neuro->key = $warframe->key . "_night_neuroptics";
                $neuro->type = "blueprint";
                $neuro->save();

                $chassis = new Item();
                $chassis->name = $warframe->name . " Night Chassis";
                $chassis->key = $warframe->key . "_night_chassis";
                $chassis->type = "blueprint";
                $chassis->save();

                $sys = new Item();
                $sys->name = $warframe->name . " Night System";
                $sys->key = $warframe->key . "_night_system";
                $sys->type = "blueprint";
                $sys->save();

                $neuro = new Item();
                $neuro->name = $warframe->name . " Day Neuroptics";
                $neuro->key = $warframe->key . "_day_neuroptics";
                $neuro->type = "blueprint";
                $neuro->save();

                $chassis = new Item();
                $chassis->name = $warframe->name . " Day Chassis";
                $chassis->key = $warframe->key . "_day_chassis";
                $chassis->type = "blueprint";
                $chassis->save();

                $sys = new Item();
                $sys->name = $warframe->name . " Day System";
                $sys->key = $warframe->key . "_day_system";
                $sys->type = "blueprint";
                $sys->save();

                $bp = new Item();
                $bp->name = $warframe->name . " Day Aspect";
                $bp->key = $warframe->key . "_day_aspect";
                $bp->type = "blueprint";
                $bp->save();

                $bp = new Item();
                $bp->name = $warframe->name . " Night Aspect";
                $bp->key = $warframe->key . "_night_aspect";
                $bp->type = "blueprint";
                $bp->save();
            } else {
                $neuro = new Item();
                $neuro->name = $warframe->name . " Neuroptics Blueprint";
                $neuro->key = $warframe->key . "_neuroptics_blueprint";
                $neuro->type = "blueprint";
                $neuro->save();

                $chassis = new Item();
                $chassis->name = $warframe->name . " Chassis Blueprint";
                $chassis->key = $warframe->key . "_chassis_blueprint";
                $chassis->type = "blueprint";
                $chassis->save();

                $sys = new Item();
                $sys->name = $warframe->name . " System Blueprint";
                $sys->key = $warframe->key . "_system_blueprint";
                $sys->type = "blueprint";
                $sys->save();

                $neuro = new Item();
                $neuro->name = $warframe->name . " Neuroptics";
                $neuro->key = $warframe->key . "_neuroptics";
                $neuro->type = "component";
                $neuro->save();

                $chassis = new Item();
                $chassis->name = $warframe->name . " Chassis";
                $chassis->key = $warframe->key . "_chassis";
                $chassis->type = "component";
                $chassis->save();

                $sys = new Item();
                $sys->name = $warframe->name . " System";
                $sys->key = $warframe->key . "_system";
                $sys->type = "component";
                $sys->save();
            }

            $item = new Item();
            $item->name = $warframe->name . " Blueprint";
            $item->key = $warframe->key . "_blueprint";
            $item->url = $warframe->url;
            $item->type = "blueprint";
            $item->save();
        }

        $weapons = Item::whereIn('type', ['primary', 'secondary', 'melee'])->get();
        foreach ($weapons as $weapon) {
            $item = new Item();
            $item->name = $weapon->name . " Blueprint";
            $item->key = $weapon->key . "_blueprint";
            $item->url = $weapon->url;
            $item->type = "blueprint";
            $item->save();
        }

        return 0;
    }
}
