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
        for($i = 1; $i < 6000; $i++) {
            $client = new Client(['http_errors' => false]);
            $response = $client->request('GET', 'https://overframe.gg/api/v1/items/' . $i, ['verify' => false]);
            $body = $response->getBody();
            $json = json_decode($body);

            if($response->getStatusCode() === 404) {
                $this->warn('Item #' . $i . ' missing.');
                continue;
            }
            if($json->tag === 'Warframe' && $json->category === 'Suits') {
                Item::updateOrCreate(['key' => $this->getItemKey($json->name)], [
                    'name' => $this->getItemName($json->name),
                    'type' => "warframe",
                    'points' => 6000,
                    'url' => $this->processImage($this->getItemKey($json->name), $json->texture, 'warframes')
                ]);
            } else if($json->tag === 'Warframe' && $json->category === 'SpaceSuits') {
                Item::updateOrCreate(['key' => $this->getItemKey($json->name)], [
                    'name' => $this->getItemName($json->name),
                    'type' => "archwing",
                    'points' => 6000,
                    'url' => $this->processImage($this->getItemKey($json->name), $json->texture, 'archwings')
                ]);
            } else if($json->tag === 'Weapon' && $json->category === 'LongGuns') {
                Item::updateOrCreate(['key' => $this->getItemKey($json->name)], [
                    'name' => $this->getItemName($json->name),
                    'type' => "primary",
                    'points' => 3000,
                    'url' => $this->processImage($this->getItemKey($json->name), $json->texture, 'weapons')
                ]);
            } else if($json->tag === 'Weapon' && $json->category === 'Pistols') {
                Item::updateOrCreate(['key' => $this->getItemKey($json->name)], [
                    'name' => $this->getItemName($json->name),
                    'type' => "secondary",
                    'points' => 3000,
                    'url' => $this->processImage($this->getItemKey($json->name), $json->texture, 'weapons')
                ]);
            } else if($json->tag === 'Weapon' && $json->category === 'Melee') {
                Item::updateOrCreate(['key' => $this->getItemKey($json->name)], [
                    'name' => $this->getItemName($json->name),
                    'type' => "melee",
                    'points' => 3000,
                    'url' => $this->processImage($this->getItemKey($json->name), $json->texture, 'weapons')
                ]);
            } else if($json->tag === 'Weapon' && $json->category === 'SpaceSuits') {
                Item::updateOrCreate(['key' => $this->getItemKey($json->name)], [
                    'name' => $this->getItemName($json->name),
                    'type' => "archwing",
                    'points' => 3000,
                    'url' => $this->processImage($this->getItemKey($json->name), $json->texture, 'archwings')
                ]);
            } else if($json->tag === 'Sentinel' && $json->category === 'Sentinels') {
                Item::updateOrCreate(['key' => $this->getItemKey($json->name)], [
                    'name' => $this->getItemName($json->name),
                    'type' => "companion",
                    'points' => 6000,
                    'url' => $this->processImage($this->getItemKey($json->name), $json->texture, 'companions')
                ]);
            }

            $this->info('Item #' . $i . ' processed.');
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
        $title = str_replace('<archwing>_', '', $title);
        return $title;
    }

    // https://media.overframe.gg/512x/Lotus/Interface/Icons/Store/RegorAxeShield.png.webp

    private function processImage($key, $imageURL, $type) {

        $path = "images/" . $type . "/" . $key . ".webp";
        $url = 'https://media.overframe.gg/512x' . $imageURL . '.webp';

        $resolution = getimagesize($url);
        $src = imagecreatefromwebp($url);
        $dest = imagecreatetruecolor($resolution[0], $resolution[1]);

        imagecopyresized($dest, $src, 0, 0, 0, 0, 512, 341, $resolution[0], $resolution[1]);

        imagewebp($dest, storage_path('app/public') . '/' . $path, 80);

        return $path;
    }
}
