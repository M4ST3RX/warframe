<?php

namespace App\Console\Commands;

use App\Models\Crafting;
use App\Models\Item;
use GuzzleHttp\Client;
use Illuminate\Console\Command;

class WeaponCraftingRecipes extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'wf:weapon_recipes';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get all items from warframe wiki';

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
        $items = Item::whereIn('type', ['primary', 'secondary', 'melee'])->get();

        foreach ($items as $item) {
            if($item->key === 'voidrig' || $item->key === 'bonewidow' || $item->key === 'equinox' || $item->key === 'excalibur_prime') continue;

            $client = new Client(['http_errors' => false]);
            $response = $client->request('GET', 'https://warframe.fandom.com/wiki/' . str_replace(' ', '/', $item->name), ['verify' => false]);
            $body = $response->getBody()->getContents();

            @$doc = new \DOMDocument();
            @$doc->loadHTML($body);

            $xpath = new \DOMXPath($doc);

            $table = $xpath->query("//table[@class='foundrytable']")->item(0);

            $rows = $table->getElementsByTagName("tr");


            $item_recipes = [
                'warframe' => [],
                'neuroptics' => [],
                'chassis' => [],
                'systems' => []
            ];

            foreach ($rows as $index => $row) {
                if ($index === 1 || $index === 2) {
                    array_push($item_recipes['warframe'], $row);
                } else if ($index === 5 || $index === 6) {
                    array_push($item_recipes['neuroptics'], $row);
                } else if ($index === 8 || $index === 9) {
                    array_push($item_recipes['chassis'], $row);
                } else if ($index === 11 || $index === 12) {
                    array_push($item_recipes['systems'], $row);
                }
            }

            foreach($item_recipes as $key => $rows) {
                if($key !== 'warframe') {
                    $bp = Item::where('key', $item->key . "_" . $key)->first();
                } else {
                    $bp = Item::where('key', $item->key)->first();
                }
                $recipe = new Crafting();
                $recipe->blueprint = $bp->id;
                $recipe->output_item = $item->id;
                $recipe->amount = 1;

                $input_items = [];

                foreach ($rows as $row) {
                    $cells = $row->getElementsByTagName('td');
                    foreach($cells as $cell) {
                        $child = $cell->firstChild;
                        if (trim($cell->nodeValue) === "" && ($child instanceof \DOMText && $child->length === 1)) continue;

                        if($child instanceof \DOMText) {
                            $parts = explode(' ', trim($cell->nodeValue));

                            if($parts[0] === 'Time:') {
                                $recipe->time = $this->getTimeInSec($parts[1], $parts[2]);
                            } else {
                                $recipe->rush = $parts[2];
                            }
                        } else {
                            if($child->hasAttribute('title')) {
                                $title = strtolower($cell->getElementsByTagName('a')[0]->getAttribute('title'));
                                $title = str_replace('warframe ', '', $title);
                                if($title === "neuroptics" || $title === "systems" || $title === "chassis") {
                                    $title = $item->key . "_" . $title;
                                } else if($title === "credits") {
                                    $recipe->price = intval(str_replace(',', '', trim($cell->nodeValue)));
                                    continue;
                                } else {
                                    $title = str_replace(' ', '_', $title);
                                }

                                $resource = Item::where('key', $title)->first();
                                if(trim($cell->nodeValue) === "") {
                                    $amount = 1;
                                } else {
                                    $amount = intval(str_replace(',', '', trim($cell->nodeValue)));
                                }
                                $input_items[$resource->id] = $amount;
                            }
                        }
                    }
                }

                $recipe->input_items = json_encode($input_items);
                $recipe->save();

                $bp->crafting_id = $recipe->id;
                $bp->save();
            }
        }

        return 0;
    }

    public function getTimeInSec($time, $name)
    {
        switch ($name) {
            case "hrs":
                return intval($time) * 60 * 60;
            case "min":
                return intval($time) * 60;
            default:
                return intval($time);
        }
    }
}
