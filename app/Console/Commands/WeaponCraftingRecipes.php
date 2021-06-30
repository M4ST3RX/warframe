<?php

namespace App\Console\Commands;

use App\Models\Crafting;
use App\Models\Item;
use GuzzleHttp\Client;
use Illuminate\Console\Command;

class WeaponCraftingRecipes extends Command
{
    protected $itemParts = ['blade', 'hilt', 'link', 'stock', 'barrel', 'receiver', 'gauntlet', 'handle', 'chassis', 'heatsink', 'grip',
        'string', 'upper_limb', 'lower_limb', 'left_gauntlet', 'right_gauntlet', 'guard', 'rivet', 'ornament', 'head', 'disc', 'stars',
        'pouch', 'boot', 'chain', 'subcortex', 'blades', 'motor', 'core'];
    protected $recipes = [];

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

        $items = Item::whereIn('type', ['primary', 'secondary', 'melee'])->orderBy('name', 'ASC')->get();

        foreach ($items as $item) {
            $this->info($item->name);
            $client = new Client(['http_errors' => false]);
            $response = $client->request('GET', 'https://warframe.fandom.com/wiki/' . str_replace(' ', '_', $item->name), ['verify' => false]);
            $body = $response->getBody()->getContents();
            @$doc = new \DOMDocument();
            @$doc->loadHTML($body);
            $xpath = new \DOMXPath($doc);
            $foundryTableList = $xpath->query("//table[@class='foundrytable']");
            if($foundryTableList->length === 0) {
                $this->error('Missing foundry table for ' . $item->name);
                continue;
            }
            $table = $foundryTableList->item(0);
            $rows = $table->getElementsByTagName("tr");

            $ignoreAnythingAfter = false;

            foreach ($rows as $index => $row)
            {
                if($ignoreAnythingAfter) continue;

                switch ($index) {
                    case 1:
                        $this->addItemToRecipesArray($item, $row);
                        break;
                    case 2:
                        $this->addRushTimeToMainItem($item, $row);
                        break;
                    case 7:
                    case 10:
                    case 13:
                    case 4:
                        if(strpos($row->nodeValue, '•') !== false) {
                            $value = preg_replace('/\n/', '', $row->nodeValue);
                            $this->addItemPartsToRecipesArray($item, explode(' ', $value)[0], $rows[$index+1], $rows[$index+2]);
                        } else {
                            $ignoreAnythingAfter = true;
                        }
                        break;

                    default:
                        break;
                }
            }

            foreach ($this->recipes as $key => $recipe) {
                $crafting = Crafting::firstOrCreate(['output_item' => $key], [
                    'blueprint' => $key,
                    'input_items' => json_encode($recipe['recipe']),
                    'output_item' => $key,
                    'amount' => 1,
                    'price' => $recipe['price'],
                    'time' => $recipe['time'],
                    'rush' => $recipe['rush']
                ]);

                $i = Item::where('id', $item->id)->first();
                $i->crafting_id = $crafting->id;
                $i->save();
            }

            $this->recipes = [];
        }

        return 0;
    }

    public function addItemToRecipesArray($item, $row)
    {
        $cells = $row->getElementsByTagName('td');
        foreach ($cells as $cell) {
            $child = $cell->firstChild;
            if (trim($cell->nodeValue) === "" && ($child instanceof \DOMText && $child->length === 1)) continue;

            if($child instanceof \DOMText) {
                $parts = explode(' ', trim($cell->nodeValue));
                $this->recipes[$item->id]['time'] = $this->getTimeInSec($parts[1], $parts[2]);
            } else {
                $titleAttr = str_replace(' ', '_', strtolower($child->getAttribute('title')));
                $amount = (trim($cell->nodeValue) === "") ? 1 : intval(str_replace(',', '', trim($cell->nodeValue)));

                if($titleAttr === 'credits') {
                    $this->recipes[$item->id]['price'] = $amount;
                    continue;
                }

                if(in_array($titleAttr, $this->itemParts)) {
                    $titleAttr = $item->key . '_' . $titleAttr;
                    $this->createItemPart($titleAttr);
                }

                $recipeItem = Item::where('key', $titleAttr)->first();
                $recipeItemId = $recipeItem->id;

                $this->recipes[$item->id]['recipe'][$recipeItemId] = $amount;
                $this->recipes[$item->id]['blueprint'] = $item->id;
                $this->recipes[$item->id]['output'] = $item->id;
            }
        }
    }

    public function addRushTimeToMainItem($item, $row)
    {
        if(trim($row->nodeValue) === 'N/A') {
            $this->recipes[$item->id]['rush'] = 0;
            return;
        }
        $parts = explode('  ', trim($row->nodeValue));
        $this->recipes[$item->id]['rush'] = $parts[1];
    }

    public function addItemPartsToRecipesArray($item, $itemPartName, $row1, $row2)
    {
        $arrayIndex = $item->key . '_' . str_replace(' ', '_', strtolower($itemPartName));
        $cells = $row1->getElementsByTagName('td');

        $itemPart = Item::where('key', $arrayIndex)->first();

        foreach ($cells as $cell) {
            $child = $cell->firstChild;
            if (trim($cell->nodeValue) === "" && ($child instanceof \DOMText && $child->length === 1)) continue;

            if($child instanceof \DOMText) {
                $parts = explode(' ', trim($cell->nodeValue));
                $this->recipes[$itemPart->id]['time'] = $this->getTimeInSec($parts[1], $parts[2]);
            } else {
                $titleAttr = str_replace(' ', '_', strtolower($child->getAttribute('title')));
                $amount = (trim($cell->nodeValue) === "") ? 1 : intval(str_replace(',', '', trim($cell->nodeValue)));

                if($titleAttr === 'credits') {
                    $this->recipes[$itemPart->id]['price'] = $amount;
                    continue;
                }

                $recipeItem = Item::where('key', $titleAttr)->first();
                $recipeItemId = $recipeItem->id;

                $this->recipes[$itemPart->id]['recipe'][$recipeItemId] = $amount;
                $this->recipes[$itemPart->id]['blueprint'] = $itemPart->id;
                $this->recipes[$itemPart->id]['output'] = $itemPart->id;
            }
        }

        $parts = explode('  ', trim($row2->nodeValue));
        $this->recipes[$itemPart->id]['rush'] = $parts[1];
    }

    public function createItemPart($itemKey)
    {
        Item::firstOrCreate(['key' => $itemKey], [
            'type' => 'weapon_part',
            'name' => ucwords(str_replace('_', ' ', $itemKey))
        ]);
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
