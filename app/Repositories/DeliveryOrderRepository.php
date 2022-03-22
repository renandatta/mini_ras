<?php

namespace App\Repositories;

use App\Models\DeliveryOrder;
use App\Models\ShipmentOrder;
use Illuminate\Http\Request;

class DeliveryOrderRepository extends Repository {

    protected $deliveryOrder, $shipmentOrder;
    public function __construct(DeliveryOrder $deliveryOrder, ShipmentOrder $shipmentOrder)
    {
        $this->deliveryOrder = $deliveryOrder;
        $this->shipmentOrder = $shipmentOrder;
    }

    public function search(Request $request)
    {
        $deliveryOrder = $this->deliveryOrder
            ->orderBy('no_order');
        $deliveryOrder = $this->filter($request, $deliveryOrder, [
            ['value' => 'shipment_order_id']
        ]);
        $paginate = $request->input('paginate') ?? null;
        if ($paginate != null) return $deliveryOrder->paginate($paginate);
        return $deliveryOrder->get();
    }

    public function check_qty($shipment_order_id, $name)
    {
        return $this->deliveryOrder
            ->where('shipment_order_id', $shipment_order_id)
            ->where('name', $name)
            ->sum('qty');
    }

    public function find($value, $column = 'id')
    {
        return $this->deliveryOrder->where($column, $value)->first();
    }

    public function store(Request $request)
    {
        $request->merge(['status' => 'Waiting Confirmation']);
        return $this->deliveryOrder->create($request->all());
    }

    public function update(Request $request, $id)
    {
        $deliveryOrder = $this->deliveryOrder->find($id);
        $deliveryOrder->update($request->all());

        if ($deliveryOrder->status == 'Rejected')
            $deliveryOrder->update(['status' => 'Waiting Confirmation']);

        // update shipment status
        $shipmentOrder = $this->shipmentOrder->find($deliveryOrder->shipment_order_id);
        if ($deliveryOrder->finish_attachment != '') {
            $shipmentOrder->update(['status' => 'Closed']);
            $deliveryOrder->update(['status' => 'Closed']);
        } else if ($deliveryOrder->date_unloading != '' && $deliveryOrder->time_unloading != '') {
            $shipmentOrder->update(['status' => 'Unloading Completed']);
            $deliveryOrder->update(['status' => 'Unloading Completed']);
        } else if ($deliveryOrder->date_arrive != '' && $deliveryOrder->time_arrive != '') {
            $shipmentOrder->update(['status' => 'Arrive at Destination']);
            $deliveryOrder->update(['status' => 'Arrive at Destination']);
        } else if ($deliveryOrder->date_loading != '' && $deliveryOrder->time_loading != '') {
            $shipmentOrder->update(['status' => 'In Transit']);
            $deliveryOrder->update(['status' => 'Loading Completed']);
        }
        if ($deliveryOrder->date_pickup != '' && $deliveryOrder->time_pickup != '') {
            $shipmentOrder->update(['status' => 'Ready to Ship']);
        }

        return $deliveryOrder;
    }

    public function save(Request $request)
    {
        $request = $this->clean_date($request, [
            'date', 'date_eta', 'pickup_date', 'loading_date', 'arrive_date', 'unloading_date'
        ]);
        $id = $request->input('id') ?? '';
        return $id == '' ? $this->store($request) : $this->update($request, $id);
    }

    public function delete($id)
    {
        $deliveryOrder = $this->deliveryOrder->find($id);
        if (!empty($deliveryOrder)) $deliveryOrder->delete();
        return $deliveryOrder;
    }

    public function auto_no($profile_id)
    {
        $last = $this->deliveryOrder
            ->whereHas('shipment_order', function ($shipment) use ($profile_id) {
                $shipment->where('shipper_id', $profile_id);
            })
            ->orderBy('no_order', 'desc')
            ->first();
        $no = !empty($last) ? last(explode('/', $last->no_order)) + 1 : 1;
        for ($i = 1; strlen($no) <= 6; $i++) $no = '0' . $no;
        return join('/', [
            'DO', date('Y'), numberToRoman(date('n')), $no
        ]);
    }

    public function list_status()
    {
        $result = array();
        foreach (ShipmentOrder::STATUS as $value) $result[$value] = $value;
        return $result;
    }

    public function update_status($id, $status)
    {
        return $this->deliveryOrder->find($id)
            ->update(['status' => $status]);
    }
}
