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

    public function mastered($userId = null)
    {
        if(!$userId) {
            if(!Auth::user()) return false;
            $userId = Auth::id();
        }

        $item = DB::table('mastered')->where('user_id', $userId)->where('item_id', $this->id)->first();

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

    public function getColor($userId = null)
    {
        if(Auth::user() || $userId) {
            if($this->mastered($userId)) {
                return 'bg-green';
            } else {
                return 'bg-red';
            }
        }

        return 'bg-lightblue';
    }

    public function getCraftingRecipe()
    {
        $crafting = Crafting::find($this->crafting_id);

        if($crafting) {
            $recipe = [];
            $recipeItems = json_decode($crafting->input_items);
            foreach ($recipeItems as $item => $amount) {
                $recipeItem = Item::select('key', 'name', 'id')->where('id', $item)->first();
                $recipeItem->amount = $amount;
                $recipe[$recipeItem->key] = $recipeItem;
            }

            return $recipe;
        }

        return null;
    }
}
