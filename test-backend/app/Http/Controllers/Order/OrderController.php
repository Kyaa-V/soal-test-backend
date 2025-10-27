<?php

namespace App\Http\Controllers\Order;

use App\Helpers\ErrorHandler;
use App\Http\Requests\OrderItemsRequest;
use App\Http\Requests\OrderRequest;
use App\Http\Resources\Orders\MultipleOrders;
use App\Http\Resources\Orders\perUnitSoldresource;
use App\Models\Items;
use App\Models\Order;
use App\Models\OrderItems;
use App\Models\User;
use App\Models\Vendor;
use Error;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class OrderController
{

    public function createOrder(OrderRequest $request){
        Log::info('start create order controller');

        try {
            $validatedData = $request->validated();
            $payload = $request->attributes->get('payload');
            $token = $request->attributes->get('token');

            Log::info('payload');
            Log::info($payload);

            Log::info('userId: ' . $payload['id']);

            DB::beginTransaction();

            $orders = Order::create([
                'id_user' => $payload['id'],
                'tgl_order' => date('Y-m-d'),
                'no_order' => 'ORD-' . time() . '-' . $payload['id'] . '-' . Str::uuid(),
                'total_order' => $validatedData['total_order'],
            ]);

            DB::commit();

            return response()->json([
                'message' => 'create order succesfully',
                'success' => true,
                'data' => $orders,
                'token' => $token
            ]);

        } catch (\Throwable $th) {
            Log::info('error in create order controller');
            DB::rollback();
            return ErrorHandler::handle($th, 'failed create order');
        }
    }
 public function createOrderItems(OrderItemsRequest $request){
    Log::info('start');
    try {
        Log::info('starting create order');
        $validatedData = $request->validated();
        $userId = $request->attributes->get('payload')['id'];

        Log::info($userId);

        DB::beginTransaction();

        $orders = Order::where('id_order', $validatedData['id_order'])->first();
        
        if (!$orders) {
            return response()->json([
                'message' => 'Order tidak ditemukan',
                'success' => false
            ], 404);
        }

        Log::info($orders);
        $orderItems = [];
        
        foreach ($request->items as $item) {
            $orderItems[] = [
                'id_order' => $orders->id_order,
                'id_item' => $item['id_item'],
                'jumlah_item' => $item['jumlah_item'],
                'harga_item' => $item['harga_item']
            ];

            $itemModel = Items::where('id_item', $item['id_item'])->first();
            
            if($itemModel){
                if($itemModel->stock < $item['jumlah_item']){
                    DB::rollback();
                    return response()->json([
                        'message' => 'stock tidak mencukupi untuk item: ' . $itemModel->nama_item,
                        'success' => false
                    ]);
                }

                Log::info('Before update', [
                    'id_item' => $itemModel->id_item,
                    'current_stock' => $itemModel->stock,
                    'current_total_sold' => $itemModel->total_sold,
                    'jumlah_dibeli' => $item['jumlah_item']
                ]);

                $itemModel->decrement('stock', $item['jumlah_item']);
                $itemModel->increment('total_sold', $item['jumlah_item']);

                $itemModel->refresh();

                Log::info('After Updated item', [
                    'id_item' => $itemModel->id_item,
                    'new_stock' => $itemModel->stock,
                    'new_total_sold' => $itemModel->total_sold
                ]);

            } else {
                DB::rollback();
                return response()->json([
                    'message' => 'Item tidak ditemukan: ' . $item['id_item'],
                    'success' => false
                ], 404);
            }
        }

        Log::info('order items', ['data' => $orderItems]);

        $orderItem = OrderItems::insert($orderItems);

        $orders->update([
            'status_order' => 'done'
        ]);

        Log::info($orderItem);

        DB::commit();
        
        return response()->json([
            'message' => 'Order created successfully',
            'success' => true,
            'data' => [
                'order_id' => $orders->id_order,
                'no_order' => $orders->no_order,
                'status_order' => $orders->status_order,
            ]
        ]);

    } catch (\Throwable $th) {
        Log::error('error kocak di create order', ['error' => $th->getMessage()]);
        DB::rollback();
        return ErrorHandler::handle($th, 'failed create order');
    }
}
    public function getAllOrderItems(){
        $perPage = 2;
        try {
            Log::info('starting get all order item');

            $orderData = User::with([
                'orders' => function($query) {
                    $query->whereHas('orderItems');
                },
                'orders.orderItems'
            ])
            ->whereHas('orders', function($query) {
                $query->whereHas('orderItems');
            })
            ->paginate($perPage);

            Log::info($orderData);

            return new MultipleOrders(200, true, 'success get all orders item', $orderData);
            // return response()->json([
            //     'message'=> 'success get all orders vendor',
            //     'success' => true,
            //     'data' => $orderData,
            //     'total' => $orderData->total(),
            //     'perPage' => $perPage,
            //     'lastPage' => $orderData->lastPage(),
            //     'currentPage' => $orderData->currentPage(),
            // ]);
        } catch (\Throwable $th) {
            return ErrorHandler::handle($th,'failed post create order item orders' );
        }

    }

}

