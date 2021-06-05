<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\User;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    public function index()
    {
        $types = ['warframe', 'primary', 'secondary', 'melee', 'archwing', 'companion'];
        $items = Item::whereIn('type', $types)->orderBy('name')->get();

        $items = $items->groupBy(function($item) {
            return $item['type'];
        });

        return view('items')->with(['items' => $items]);
    }

    public function view($slug)
    {
        $item = Item::where('key', $slug)->first();

        $resources = $item->resources();

        return view('item.view')->with(['item' => $item, 'resources' => $resources]);
    }

    public function viewOthers($username)
    {
        $types = ['warframe', 'primary', 'secondary', 'melee', 'archwing', 'companion'];
        $items = Item::whereIn('type', $types)->orderBy('name')->get();

        $items = $items->groupBy(function($item) {
            return $item['type'];
        });

        $user = User::where('username', $username)->first();
        if(!$user) {
            abort(404);
        }

        return view('items')->with(['items' => $items, 'userId' => $user->id]);
    }
}
