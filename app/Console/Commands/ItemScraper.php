<?php

namespace App\Console\Commands;

use App\Models\Item;
use GuzzleHttp\Client;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use PHPHtmlParser\Dom;
use PHPHtmlParser\Options;

class ItemScraper extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'wf:items';

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
        $client = new Client(['http_errors' => false]);
        $response = $client->request('GET', 'https://api.warframestat.us/items?remove=abilities,patchlogs' , ['verify' => false]);

        $body = $response->getBody();
        $json = json_decode($body);

        foreach($json as $item) {
            if ($item->category === "Warframes" || $item->category === "Primary" || $item->category === "Secondary" || $item->category === "Melee" || $item->category === "Sentinels" || $item->category === "Arch-Gun" ){
                $this->warn('Item ' . $item->name . ' processing...');
                if($item->type === 'Warframe' && $item->productCategory === 'Suits') {
                    $key = $this->getItemKey($item->name);
                    Item::updateOrCreate(['key' => $key], [
                        'name' => $item->name,
                        'type' => "warframe",
                        'points' => 6000,
                        'url' => $this->processImage($item->name, 'warframes')
                    ]);

                } else if($item->type === 'Warframe' && $item->productCategory === 'SpaceSuits') {
                    Item::updateOrCreate(['key' => $this->getItemKey($item->name)], [
                        'name' => $item->name,
                        'type' => "vehicle",
                        'points' => 6000,
                        'url' => $this->processImage($item->name, 'vehicles')
                    ]);


                } else if($item->type === 'Warframe' && $item->productCategory === 'MechSuits') {
                    Item::updateOrCreate(['key' => $this->getItemKey($item->name)], [
                        'name' => $item->name,
                        'type' => "vehicle",
                        'points' => 6000,
                        'url' => $this->processImage($item->name, 'vehicles')
                    ]);


                } else if($item->type === 'Rifle' && $item->productCategory === 'LongGuns') {
                    Item::updateOrCreate(['key' => $this->getItemKey($item->name)], [
                        'name' => $item->name,
                        'type' => "primary",
                        'points' => 3000,
                        'url' => $this->processImage($item->name, 'weapons')
                    ]);


                } else if($item->type === 'Rifle' && $item->productCategory === 'Pistols') {
                    Item::updateOrCreate(['key' => $this->getItemKey($item->name)], [
                        'name' => $item->name,
                        'type' => "secondary",
                        'points' => 3000,
                        'url' => $this->processImage($item->name, 'weapons')
                    ]);


                } else if($item->type === 'Melee' && $item->productCategory === 'Melee') {
                    Item::updateOrCreate(['key' => $this->getItemKey($item->name)], [
                        'name' => $item->name,
                        'type' => "melee",
                        'points' => 3000,
                        'url' => $this->processImage($item->name, 'weapons')
                    ]);


                } else if($item->type === 'Arch-Gun' && $item->productCategory === 'SpaceGuns') {
                    Item::updateOrCreate(['key' => $this->getItemKey($item->name)], [
                        'name' => $item->name,
                        'type' => "archgun",
                        'points' => 3000,
                        'url' => $this->processImage($item->name, 'archguns')
                    ]);


                } else if($item->type === 'Sentinel' && $item->productCategory === 'Sentinels') {
                    Item::updateOrCreate(['key' => $this->getItemKey($item->name)], [
                        'name' => $item->name,
                        'type' => "companion",
                        'points' => 6000,
                        'url' => $this->processImage($item->name, 'companions')
                    ]);


                } else if($item->type === 'Companion Weapon' && $item->productCategory === 'SentinelWeapons') {
                    Item::updateOrCreate(['key' => $this->getItemKey($item->name)], [
                        'name' => $item->name,
                        'type' => "companion",
                        'points' => 6000,
                        'url' => $this->processImage($item->name, 'companions')
                    ]);

                }
                $this->info('Item ' . $item->name . ' processed.');
            }
        }

        return 0;
    }

    private function getItemName($title) {
        $title = strtolower($title);
        $title = str_replace('<archwing> ', '', $title);
        $title = ucwords($title);
        return $title;
    }

    private function getItemKey($title) {
        $title = strtolower($title);
        $title = str_replace(' ', '_', $title);
        $title = str_replace('-', '_', $title);
        $title = str_replace('<archwing>_', '', $title);
        return $title;
    }

    private function getItemWikiUrl($name)
    {
        $name = str_replace('Mk1', 'MK1', $name);
        switch($name) {
            case "Dark Split-Sword":
                $name = "Dark Split Sword Dual Swords";
                break;
            case "Mk1-Braton":
                $name = "Braton";
                break;
        }

        $name = str_replace(' ', '', $name);
        $hash = md5($name . ".png");

        return "https://static.wikia.nocookie.net/warframe/images/" . substr($hash , 0, 1) . "/" . substr($hash , 0, 2) . "/" . $name . ".png";
    }
    // https://static.wikia.nocookie.net/warframe/images/1/1a/Akaten.png/revision/latest?cb=20210719052622
    // https://media.overframe.gg/512x/Lotus/Interface/Icons/Store/RegorAxeShield.png.webp
    // https://static.wikia.nocookie.net/warframe/images/3/34/VaubanPrime.png/revision/latest?cb=20221110213420

    private function processImage($name, $type) {

        $path = "images/" . $type . "/" . $this->getItemKey($name) . ".webp";
        $url = $this->getItemWikiUrl($name);

        $resolution = getimagesize($url);
        $src = @imagecreatefrompng($url);

        $dest = imagecreatetruecolor(512, 341);

        imagecopyresized($dest, $src, 0, 0, 0, 0, 512, 341, $resolution[0], $resolution[1]);

        imagewebp($dest, storage_path('app/public') . '/' . $path, 80);

        return $path;
    }

}
