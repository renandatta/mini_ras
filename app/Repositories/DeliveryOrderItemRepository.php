<?php

namespace App\Repositories;

use App\Models\DeliveryOrderItem;
use Illuminate\Http\Request;

class DeliveryOrderItemRepository extends Repository {

    protected $deliveryOrderItem;
    public function __construct(DeliveryOrderItem $deliveryOrderItem)
    {
        $this->deliveryOrderItem = $deliveryOrderItem;
    }

    public function shipment_order_item($shipment_order_id, $name)
    {
        return $this->deliveryOrderItem
            ->whereHas('delivery_order', function ($delivery) use ($shipment_order_id) {
                $delivery->where('shipment_order_id', $shipment_order_id);
            })
            ->where('name', $name)
            ->first();
    }

    public function delivery_order_item($delivery_order_id, $name)
    {
        return $this->deliveryOrderItem
            ->where('delivery_order_id', $delivery_order_id)
            ->where('name', $name)
            ->first();
    }

    public function search(Request $request)
    {
        $deliveryOrderItem = $this->deliveryOrderItem;
        $deliveryOrderItem = $this->filter($request, $deliveryOrderItem, [
            ['value' => 'delivery_order_id']
        ]);
        $paginate = $request->input('paginate');
        if ($paginate !== null) return $deliveryOrderItem->paginate($paginate);
        return $deliveryOrderItem->get();
    }

    public function save(Request $request, $delivery_order_id)
    {
        $list_name = $request->input('name');
        $list_qty = $request->input('qty');
        $list_unit = $request->input('unit');
        foreach ($list_name as $key => $name) {
            $this->deliveryOrderItem->updateOrCreate([
                'delivery_order_id' => $delivery_order_id,
                'name' => $name,
                'unit' => $list_unit[$key] ?? '',
            ], [
                'qty' => $list_qty[$key] ?? 0,
            ]);
        }
    }

}
