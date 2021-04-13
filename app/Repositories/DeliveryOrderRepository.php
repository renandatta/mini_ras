<?php

namespace App\Repositories;

use App\Models\DeliveryOrder;
use Illuminate\Http\Request;

class DeliveryOrderRepository extends Repository
{
    protected $deliveryOrder;
    public function __construct(DeliveryOrder $deliveryOrder)
    {
        $this->deliveryOrder = $deliveryOrder;
    }

    public function search(Request $request)
    {
        $deliveryOrder = $this->deliveryOrder;

        $vehicle_id = $request->input('vehicle_id') ?? '';
        if ($vehicle_id != '') $deliveryOrder = $deliveryOrder->where('vehicle_id', $vehicle_id);

        $profile_id = $request->input('profile_id') ?? '';
        if ($profile_id != '')
            $deliveryOrder = $deliveryOrder->whereHas('vehicle', function ($vehicle) use ($profile_id) {
                $vehicle->where('profile_id', $profile_id);
            });

        $paginate = $request->input('paginate') ?? null;
        if ($paginate != null) return $deliveryOrder->paginate($paginate);
        return $deliveryOrder->get();
    }

    public function find($value, $column = 'id')
    {
        return $this->deliveryOrder->where($column, $value)->first();
    }

    public function save(Request $request)
    {
        $request = $this->clean_date($request, ['date', 'arrived_date']);
        $deliveryOrder = $this->deliveryOrder->find($request->input('id'));
        if (empty($deliveryOrder)) $deliveryOrder = $this->deliveryOrder->create($request->all());
        else $deliveryOrder->update($request->all());
        return $deliveryOrder;
    }

    public function delete($id)
    {
        $deliveryOrder = $this->deliveryOrder->find($id);
        if (!empty($deliveryOrder)) $deliveryOrder->delete();
        return $deliveryOrder;
    }
}
