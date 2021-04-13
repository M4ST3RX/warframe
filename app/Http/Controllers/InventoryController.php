<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InventoryController extends Controller
{
    public function index()
    {
        $items = Inventory::where('user_id', Auth::id())->get();

        return view('inventory')->with(["items" => $items]);
    }
}
