<?php

namespace App\Http\Controllers\Vendor;

use App\Helpers\ErrorHandler;
use App\Http\Resources\Vendor\MultipleVendorItem;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class VendorController
{
    public function createVendor(Request $request){

        try {
            $payload = $request->attributes->get('payload');
            $userId = $payload['id'];

            DB::beginTransaction();

            if(Vendor::where('id_user', $userId)->exists()){
                return response()->json([
                    'message' => 'Vendor already exists',
                    'success' => false
                ]);
            }

            $vendor = Vendor::create([
                'kode_vendor' => 'VND-' . $userId,
                'nama_vendor' => $payload['name'],
                'id_user' => $userId
            ]);

            DB::commit();

            return response()->json([
                'message' => 'vendor created successfully',
                'success' => true,
                'payload' => $vendor
            ]);
        } catch (\Throwable $th) {
            DB::rollback();
            return ErrorHandler::handle($th, 'failed created vendor');
        }

    }
    public function getAllVendors(Request $request){
        try {
            $page = request()->query('page', 1);
            $perPage = request()->query('per_page', 5);

            $vendorData = Vendor::with('items')->paginate($perPage, ['*'], 'page', $page);

            Log::info('Per Page:', [$perPage]);
            Log::info('Current Page:', [$page]);
            Log::info('Total Items:', [$vendorData->count()]);

            Log::info($vendorData);

            return new MultipleVendorItem(200, true, 'success get all data vendor', $vendorData);
            
            // return response()->json([
            //     'message' => 'success get all vendors',
            //     'success' => true,
            //     'payload' => $vendorData
            // ]);
        } catch (\Throwable $th) {
            return ErrorHandler::handle($th, 'failed get vendor');
        }
    }
}
