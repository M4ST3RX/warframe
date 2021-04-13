<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    public function index()
    {
        $items = [];

        $items['warframes'] = Item::where('type', 'warframe')->orderBy('name')->get();
        $items['primary'] = Item::where('type', 'primary')->orderBy('name')->get();
        $items['secondary'] = Item::where('type', 'secondary')->orderBy('name')->get();
        $items['melee'] = Item::where('type', 'melee')->orderBy('name')->get();

        return view('items')->with(['items' => $items]);
    }

    public function view($slug)
    {
        $item = Item::where('key', $slug)->first();

        $resources = $item->resources();

        return view('item.view')->with(['item' => $item, 'resources' => $resources]);
    }
}
