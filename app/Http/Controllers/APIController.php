<?php

namespace App\Http\Controllers;

use App\Models\Crafting;
use App\Models\Inventory;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class APIController extends Controller
{
    public function getItems(Request $request)
    {
        if($request->has('types')) {
            $types = explode(',', $request->get('types'));
            $items = Item::whereIn('type', $types)->get();
        } else {
            $items = Item::all();
        }

        if($request->has('group') && $request->get('group')) {
            $items = $items->groupBy(function($item){
                return $item->type;
            })->all();
        }

        return json_encode($items);
    }

    public function getInventory()
    {
        $inventory = Inventory::where('user_id', Auth::id())->get();
        $items = [];

        foreach ($inventory as $key => $item) {
            $items[] = Item::find($item->item_id);;
        }

        return json_encode($items);
    }

    public function createRecipe(Request $request)
    {
        $items = $request->toArray();
        $inputItems = [];
        $itemId = $items['blueprint'];

        $item = Item::find($itemId);

        $recipe = new Crafting();
        $recipe->output_item = $items['output-resource'];
        $recipe->amount = $items['output-amount'];
        $recipe->blueprint = $itemId;

        unset($items['blueprint']);

        $i = (count($items) - 2) / 2;

        for($k = 1; $k <= $i; $k++) {
            $inputItems[$items['resource-'.$k]] = $items['amount-'.$k];
        }

        $recipe->input_items = json_encode($inputItems);
        $recipe->save();

        $item->crafting_id = $recipe->id;
        $item->save();

        return json_encode(['error' => false]);
    }

    public function updateItem(Request $request, $id)
    {
        $action = $request->get('action');

        switch ($action) {
            case 'mastered':
                $return = $this->updateMastered($id);
                break;
            default:
                $return = ['error' => true, 'message' => 'Something went wrong.'];
        }

        return json_encode($return);
    }

    public function updateMastered($itemId)
    {
        $item = Item::find($itemId);
        if(!$item) return ['error' => true, 'message' => 'Something went wrong.'];

        $masteredItem = DB::table('mastered')->where('user_id', Auth::id())->where('item_id', $itemId)->first();

        if($masteredItem) {
            DB::table('mastered')->where('user_id', Auth::id())->where('item_id', $itemId)->delete();
            $mastered = false;
        } else {
            DB::table('mastered')->insert([
                'user_id' => Auth::id(),
                'item_id' => $itemId
            ]);
            $mastered = true;
        }

        return ['error' => false, 'data' => ['mastered' => $mastered]];
    }

    public function addItemInventory(Request $request)
    {
        $itemId = $request->get('item_id');
        $amount = $request->get('amount');

        $item = Item::find($itemId);

        if(!$item) return ['error' => true, 'message' => 'Item does not exists'];

        $invItem = Inventory::updateOrCreate([
            'user_id' => Auth::id(),
            'item_id' => $itemId
        ], [
            'amount' => $amount
        ]);

        return json_encode(['error' => false, 'data' => ['item' => $item]]);
    }
}
