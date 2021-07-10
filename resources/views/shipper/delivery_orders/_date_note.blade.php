@if($mode == 'Loading')
    <h4 class="mb-3"># Loading</h4>
    <div class="row">
        <div class="col-md-4">
            <x-form-group caption="Loading Date">
                <x-input name="date_loading" class="datepicker" :value="format_date($delivery_order->date_loading ?? date('Y-m-d'))" />
            </x-form-group>
            <x-form-group caption="Loading Time">
                <x-input name="time_loading" class="timepicker" :value="$delivery_order->time_loading ?? date('H:i:s')" />
            </x-form-group>
        </div>
        <div class="col-md-8">
            <x-form-group caption="Loading Note">
                <x-textarea name="note_loading" rows="7" :value="$delivery_order->note_loading ?? ''" />
            </x-form-group>
        </div>
    </div>
@endif
@if($mode == 'Arrive')
    <h4 class="mb-3"># Arrive</h4>
    <div class="row">
        <div class="col-md-4">
            <x-form-group caption="Arrive Date">
                <x-input name="date_arrive" class="datepicker" :value="format_date($delivery_order->date_arrive ?? date('Y-m-d'))" />
            </x-form-group>
            <x-form-group caption="Arrive Time">
                <x-input name="time_arrive" class="timepicker" :value="$delivery_order->time_arrive ?? date('H:i:s')" />
            </x-form-group>
        </div>
        <div class="col-md-8">
            <x-form-group caption="Arrive Note">
                <x-textarea name="note_arrive" rows="7" :value="$delivery_order->note_arrive ?? ''" />
            </x-form-group>
        </div>
    </div>
@endif
@if($mode == 'Unloading')
    <h4 class="mb-3"># Unloading</h4>
    <div class="row">
        <div class="col-md-4">
            <x-form-group caption="Unloading Date">
                <x-input name="date_unloading" class="datepicker" :value="format_date($delivery_order->date_unloading ?? date('Y-m-d'))" />
            </x-form-group>
            <x-form-group caption="Unloading Time">
                <x-input name="time_unloading" class="timepicker" :value="$delivery_order->time_unloading ?? date('H:i:s')" />
            </x-form-group>
        </div>
        <div class="col-md-8">
            <x-form-group caption="Unloading Note">
                <x-textarea name="note_unloading" rows="7" :value="$delivery_order->note_unloading ?? ''" />
            </x-form-group>
        </div>
    </div>
@endif
@if($mode == 'Close')
    <h4 class="mb-3"># Close Order</h4>
    <x-form-group caption="Attachment">
        <x-input type="file" name="delivery_order_attachment" class="dropify" />
    </x-form-group>
@endif
