<?php

namespace App\Http\Resources\Orders;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Pagination\AbstractPaginator;

class MultipleOrders extends JsonResource
{
    private $statusCode, $success, $message, $data;

    public function __construct($statusCode, $success, $message, $data)
    {
        $this->data = $data;
        $this->statusCode = $statusCode;
        $this->success = $success;
        $this->message = $message;
    }
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'payload' => [
                'message' => $this->message,
                'success' => $this->success,
                // 'data' => $this->data->items(),
                'data' => UserOrders::collection($this->data->items()),
                'meta' => $this->data instanceof AbstractPaginator ? [
                    'current_page' => $this->data->currentPage(),
                    'last_page' => $this->data->lastPage(),
                    'per_page' => $this->data->perPage(),
                    'total' => $this->data->total(),
                ] : null,
            ]
        ];
    }
}
