<?php

namespace App\Console\Commands;

use App\Models\Item;
use GuzzleHttp\Client;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use PHPHtmlParser\Dom;
use PHPHtmlParser\Options;

class WeaponScraper extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'wiki:weapon';

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
                $item = new Item();
                $item->type = "warframe";
                $item->name = $this->getItemName($json->name);
                $item->key = $this->getItemKey($json->name);
                $item->points = 6000;
                $item->url = $this->processImage($this->getItemKey($json->name), $json->texture, 'warframes');

                $item->save();
            } else if($json->tag === 'Weapon' && $json->category === 'LongGuns') {
                $item = new Item();
                $item->type = "primary";
                $item->name = $this->getItemName($json->name);
                $item->key = $this->getItemKey($json->name);
                $item->points = 3000;
                $item->url = $this->processImage($this->getItemKey($json->name), $json->texture, 'weapons');

                $item->save();
            } else if($json->tag === 'Weapon' && $json->category === 'Pistols') {
                $item = new Item();
                $item->type = "secondary";
                $item->name = $this->getItemName($json->name);
                $item->key = $this->getItemKey($json->name);
                $item->points = 3000;
                $item->url = $this->processImage($this->getItemKey($json->name), $json->texture, 'weapons');

                $item->save();
            } else if($json->tag === 'Weapon' && $json->category === 'Melee') {
                $item = new Item();
                $item->type = "melee";
                $item->name = $this->getItemName($json->name);
                $item->key = $this->getItemKey($json->name);
                $item->points = 3000;
                $item->url = $this->processImage($this->getItemKey($json->name), $json->texture, 'weapons');

                $item->save();
            }

            $this->info('Item #' . $i . ' processed.');
        }

        return 0;
    }

    private function getItemName($title) {
        return ucwords(strtolower($title));
    }

    private function getItemKey($title) {
        return strtolower(str_replace(' ', '_', $title));
    }

    // https://media.overframe.gg/512x/Lotus/Interface/Icons/Store/RegorAxeShield.png.webp

    private function processImage($key, $imageURL, $type) {

        $path = "images/" . $type . "/" . $key . ".png";
        $url = 'https://media.overframe.gg/512x' . $imageURL . '.webp';

        $resolution = getimagesize($url);
        $src = imagecreatefromwebp($url);
        $dest = imagecreatetruecolor($resolution[0], $resolution[1]);

        imagecopy($dest, $src, 0, 0, 0, 0, $resolution[0], $resolution[1]);

        imagepng($dest, storage_path('app/public') . '/' . $path);

        return $path;
    }
}
