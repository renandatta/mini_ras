<?php

namespace App\Repositories;

use App\Models\ShipmentOrder;
use Illuminate\Http\Request;

class ShipmentOrderRepository extends Repository {

    protected $shipmentOrder;
    public function __construct(ShipmentOrder $shipmentOrder)
    {
        $this->shipmentOrder = $shipmentOrder;
    }

    public function search(Request $request)
    {
        $shipmentOrder = $this->shipmentOrder->with(['shipper', 'items']);
        $shipmentOrder = $this->filter($request, $shipmentOrder, [
            ['value' => 'shipper_id'],
            ['value' => 'customer_id'],
            ['value' => 'status'],
            ['value' => 'no_order', 'operator' => 'like'],
            ['value' => 'date_start', 'operator' => '>=', 'column' => 'date'],
            ['value' => 'date_end', 'operator' => '<=', 'column' => 'date'],
        ]);
        $item_name = $request->input('item_name', '');
        $qty_start = $request->input('qty_start', '');
        $qty_end = $request->input('qty_end', '');
        if ($item_name != '' || $qty_start != '' || $qty_end != '') {
            $shipmentOrder->whereHas('items', function ($items) use ($item_name, $qty_start, $qty_end) {
                if ($item_name != '') $items->where('name', 'like', "%$item_name%");
                if ($qty_start != '') $items->where('qty', '>=', $qty_start);
                if ($qty_end != '') $items->where('qty', '<=', $qty_end);
            });
        }

        $paginate = $request->input('paginate') ?? null;
        if ($paginate != null) return $shipmentOrder->paginate($paginate);
        return $shipmentOrder->get();
    }

    public function find($value, $column = 'id')
    {
        return $this->shipmentOrder->where($column, $value)->first();
    }

    public function store(Request $request)
    {
        $request->merge(['status' => 'Order In Progress']);
        return $this->shipmentOrder->create($request->all());
    }

    public function update(Request $request, $id)
    {
        $shipmentOrder = $this->shipmentOrder->find($id);
        $shipmentOrder->update($request->all());
        return $shipmentOrder;
    }

    public function save(Request $request)
    {
        $request = $this->clean_date($request, ['date']);
        $id = $request->input('id') ?? '';
        return $id == '' ? $this->store($request) : $this->update($request, $id);
    }

    public function delete($id)
    {
        $shipmentOrder = $this->shipmentOrder->find($id);
        if (!empty($shipmentOrder)) $shipmentOrder->delete();
        return $shipmentOrder;
    }

    public function auto_no($profile_id)
    {
        $last = $this->shipmentOrder
            ->where('shipper_id', $profile_id)
            ->orderBy('no_order', 'desc')
            ->first();
        $no = !empty($last) ? $last->no_order + 1 : 1;
        for ($i = 1; strlen($no) <= 6; $i++) $no = '0' . $no;
        return $no;
    }

    public function list_status()
    {
        $result = array();
        foreach (ShipmentOrder::STATUS as $value) $result[$value] = $value;
        return $result;
    }

    public function update_status($id, $status)
    {
        return $this->shipmentOrder->find($id)
            ->update(['status' => $status]);
    }
}
