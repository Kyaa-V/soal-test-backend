<?php

namespace App\Http\Controllers\Item;

use App\Models\Items;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ItemController
{
    public function getAllItems(Request $request){
        $data = Items::all();

        return response()->json([
            'message' => 'success get all item',
            'success' => true,
            'data' => $data
        ]);
    }

    public function getOrderItem(Request $request){
        $order = $request->order;

        Log::info($order);

        $data = Items::orderBy('total_sold', $order)->get();

        return response()->json([
            'message' => 'success get all item',
            'success' => true,
            'data' => $data
        ]);
    }
}
