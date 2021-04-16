<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Item extends Model
{
    use HasFactory;

    protected $fillable = ['type', 'url', 'name', 'key', 'points'];

    public function mastered()
    {
        if(!Auth::user()) return false;
        $item = DB::table('mastered')->where('user_id', Auth::user()->id)->where('item_id', $this->id)->first();

        if($item) return true;
        return false;
    }

    public function resources()
    {
        if($this->crafting_id === null) return [];

        $recipe = Crafting::find($this->crafting_id);
        $input = json_decode($recipe->input_items);

        $resources = [];

        foreach ($input as $resourceId => $amount) {
            $item = Item::find($resourceId);
            $klass = new \stdClass();

            $klass->url = $item->url;
            $klass->amount = number_format($amount);
            $klass->name = $item->name;

            $resources[] = $klass;
        }

        $collection = collect($resources);
        $collection->sortBy(function($resource) {
            return $resource->name;
        });

        return $collection;
    }

    public function getBlueprint()
    {
        return Item::where('key', $this->key . "_blueprint")->first();
    }

    public function getColor()
    {
        if(Auth::user()) {
            if($this->mastered()) {
                return 'bg-green';
            } else {
                return 'bg-red';
            }
        }

        return 'bg-lightblue';
    }
}
