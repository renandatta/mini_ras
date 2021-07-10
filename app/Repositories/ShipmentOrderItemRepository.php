<?php

namespace App\Repositories;

use App\Models\ShipmentOrderItem;
use Illuminate\Http\Request;

class ShipmentOrderItemRepository extends Repository {

    protected $shipmentOrderItem;
    public function __construct(ShipmentOrderItem $shipmentOrderItem)
    {
        $this->shipmentOrderItem = $shipmentOrderItem;
    }

    public function search(Request $request)
    {
        $shipmentOrderItem = $this->shipmentOrderItem;
        $shipmentOrderItem = $this->filter($request, $shipmentOrderItem, [
            ['value' => 'consignee_id'],
            ['value' => 'shipment_order_id'],
        ]);
        $paginate = $request->input('paginate') ?? null;
        if ($paginate != null) return $shipmentOrderItem->paginate($paginate);
        return $shipmentOrderItem->get();
    }

    public function find($value, $column = 'id')
    {
        return $this->shipmentOrderItem->where($column, $value)->first();
    }

    public function store(Request $request)
    {
        return $this->shipmentOrderItem->create($request->all());
    }

    public function update(Request $request, $id)
    {
        $shipmentOrderItem = $this->shipmentOrderItem->find($id);
        $shipmentOrderItem->update($request->all());
        return $shipmentOrderItem;
    }

    public function save(Request $request)
    {
        $request = $this->clean_number($request, ['qty', 'volume']);
        $id = $request->input('id') ?? '';
        return $id == '' ? $this->store($request) : $this->update($request, $id);
    }

    public function delete($id)
    {
        $shipmentOrderItem = $this->shipmentOrderItem->find($id);
        if (!empty($shipmentOrderItem)) $shipmentOrderItem->delete();
        return $shipmentOrderItem;
    }

}
