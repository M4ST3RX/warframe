<?php

namespace App\Console\Commands;

use App\Models\Item;
use GuzzleHttp\Client;
use Illuminate\Console\Command;
use PHPHtmlParser\Dom;
use PHPHtmlParser\Options;

class WikiScraper extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'wiki:warframe';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get all items from warframe wiki';

    protected $exclude = ['Warframes', 'Abilities', 'Blueprints/Warframe', 'Sevagoth/Abilities'];

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
        $client = new Client();
        $response = $client->request('GET', 'https://warframe.fandom.com/api/v1/Articles/List?expand=1&category=Warframes&limit=10000', ['verify' => false]);
        $body = $response->getBody();

        $json = json_decode($body);

        Item::where('type', 'warframe')->delete();

        foreach ($json->items as $item) {
            if(isset($item->type) && $item->type === 'article' && strpos($item->title, 'Main') === false
                && strpos($item->title, ' ') === false && !in_array($item->title, $this->exclude)) {
                $key = $this->titleToKey($item->title);
                Item::updateorCreate(
                    ['key' => $key, 'type' => 'warframe'],
                    ['url' => $this->processImage($key, $item->thumbnail), 'points' => 6000, 'name' => $this->titleToName($item->title)]
                );
            }
        }

        return 0;
    }

    private function titleToKey($title) {
        return strtolower(str_replace('/', '_', $title));
    }

    private function titleToName($title) {
        return str_replace('/', ' ', $title);
    }

    // https://static.wikia.nocookie.net/warframe/images/1/17/AshNewLook.png/revision/latest/smart/width/200/height/200?cb=20141124022921

    private function processImage($key, $imageURL) {
        if(strpos($imageURL, '.png') !== false) {
            $pngEnd = strpos($imageURL, '.png') + 4;
        } else if(strpos($imageURL, '.PNG') !== false) {
            $pngEnd = strpos($imageURL, '.PNG') + 4;
        } else if(strpos($imageURL, '.webp') !== false) {
            $pngEnd = strpos($imageURL, '.webp') + 5;
        } else {
            $pngEnd = strpos($imageURL, '.jpg') + 4;
        }
        $url = substr($imageURL, 0, $pngEnd);
        $date = substr($imageURL, strlen($imageURL) - 14, 15);

        $resolution = getimagesize($url . '/revision/latest?cb=' . $date);
        $imageData = file_get_contents($url . '/revision/latest?cb=' . $date);
        $src = imagecreatefromstring($imageData);
        $dest = imagecreatetruecolor($resolution[0], $resolution[1]);

        $path = "images/warframes/" . $key . ".png";

        imagecopy($dest, $src, 0, 0, 0, 0, $resolution[0], $resolution[1]);
        imagepng($dest, storage_path('app/public') . '/' . $path);

        imagedestroy($dest);
        imagedestroy($src);

        return $path;
    }
}
