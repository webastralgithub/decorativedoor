@extends('admin.layouts.app')

@section('content')
@if (auth()->user()->hasRole('Product Assembler') || auth()->user()->hasRole('Delivery User'))
<style>
    .sidebar.pe-4.pb-3 {
        display: none;
    }

    .content.pb-4 {
        margin: 0;
        width: 100%;
    }

    a.sidebar-toggler.flex-shrink-0 {
        display: none !important;
    }
</style>
@endif
<div class="mx-4 content-p-mobile" id="order-listing-assembler">
    <div class="page-header-tp">
        <h3>{{ __('Order') }} #{{ $order->order_id }}</h3>
        <div class="top-bntspg-hdr">
            <a href="javascript:void(0)" onclick="history.back()" class="btn btn-primary btn-sm">&larr; Back</a>

            @can('change-order-status')
            <!-- <div class="col-md-6">
                                                        <label class="small mb-1" for="order_status">
                                                            Order Status
                                                            <span class="text-danger">*</span>
                                                        </label>
                                                        <select class="form-select form-control-solid" id="order_status" name="order_status" onchange="updateOrderStatus()">

                                                            @foreach ($order_statuses as $status)
        @if (
            \App\Models\OrderStatus::COMPLETE == $status->id &&
                auth()->user()->can('order-status-complete'))
        <option value="{{ $status->id }}" @selected($order->order_status == $status->id)>{{ $status->name }}</option>
        @endif
                                                            @if (
                                                                \App\Models\OrderStatus::PENDING_ORDER_CONFIRMATION == $status->id &&
                                                                    auth()->user()->can('order-status-pending-order-confirmation'))
        <option value="{{ $status->id }}" @selected($order->order_status == $status->id)>{{ $status->name }}</option>
        @endif
                                                            @if (
                                                                \App\Models\OrderStatus::FAILED == $status->id &&
                                                                    auth()->user()->can('order-status-failed'))
        <option value="{{ $status->id }}" @selected($order->order_status == $status->id)>{{ $status->name }}</option>
        @endif
                                                            @if (
                                                                \App\Models\OrderStatus::READY_TO_PRODUCTION == $status->id &&
                                                                    auth()->user()->can('order-status-ready-to-production'))
        <option value="{{ $status->id }}" @selected($order->order_status == $status->id)>{{ $status->name }}</option>
        @endif
                                                            @if (
                                                                \App\Models\OrderStatus::READY_TO_DELIVER == $status->id &&
                                                                    auth()->user()->can('order-status-deliver'))
        <option value="{{ $status->id }}" @selected($order->order_status == $status->id)>{{ $status->name }}</option>
        @endif
                                                            @if (
                                                                \App\Models\OrderStatus::DISPATCHED == $status->id &&
                                                                    auth()->user()->can('order-status-dispatch'))
        <option value="{{ $status->id }}" @selected($order->order_status == $status->id)>{{ $status->name }}</option>
        @endif
        @endforeach
                                                        </select>
                                                    </div> -->
            @endcan

        </div>
    </div>

    <div class="mt-2">
        <div class="row row-cards mb-3 order-table-topb order-listing">
            <div class="order-listing-customer">
                    <label for="customer" class="form-label required">
                        <strong>{{ __('Customer') }}:</strong> {{ @$order->user->name }}
                    </label>
            </div>
            <div class="order-listing-inner">                
                    <div class="order-listing-confirm">
                        @if(!$order->order_confirm)
                        <a class="btn btn-primary" href="{{ route('order.confirm-order', $order->id) }}">Confirm
                            Order</a>
                        @endif
                    </div>
                    <div class="order-listing-signature">
                        @can('add-signature')
                        <a href="{{ route('orders.delivery_user', $order->id) }}" class="btn btn-primary  ">Take
                            Signature</a>
                        @endcan
                    </div>
                    <div class="order-listing-date">
                <label for="order_date" class="form-label required ">
                    <strong>{{ __('Order Date') }}:</strong> {{ $order->order_date->format('d-m-Y') }}
                </label>

            </div>
            </div>
            


            {{-- <div class="col">
                <label for="payment_type" class="form-label required">
                    <strong>{{ __('Payment Via') }}:</strong> {{ @$order->payment_type }}
            </label>
        </div> --}}
    </div>

    <div class="content-body inventery-createtable-btm">
        <div class="table-responsive">
            <table class="table table-striped table-bordered align-middle">
                <thead class="thead-light">
                    <tr>
                        <th scope="col" class="align-middle text-center">No.</th>
                        <th scope="col" class="align-middle text-center">Photo</th>
                        <th scope="col" class="align-middle text-center">Product Name</th>
                        <th scope="col" class="align-middle text-center">Quantity</th>
                        <th scope="col" class="align-middle text-center order-listing-production-qty">Production Ready Qty</th>
                        <th scope="col" class="align-middle text-center order-listing-backorder-qty">Backorder Qty</th>
                        @can('delivery-order-status')
                        <th scope="col" class="align-middle text-center">Delivered Qty</th>
                        <th scope="col" class="align-middle text-center">Pending Qty</th>
                        @endcan
                        @can('change-order-status')
                        <th scope="col" class="align-middle text-center order-listing-order-status">Order Status</th>
                        @endcan
                        @if (!auth()->user()->hasRole('Super Admin'))
                        @can('delivery-order-status')
                        <th scope="col" class="align-middle text-center order-listing-order-status">Order Status</th>
                        @endcan
                        @endif
                        @can('order_price')
                        <th scope="col" class="align-middle text-center">Price</th>
                        <th scope="col" class="align-middle text-center">Total</th>
                        @endcan
                    </tr>
                </thead>
                <tbody>
                    @php
                    $discount = [];
                    $finaltotal = [];
                    @endphp
                    @foreach ($order->details as $item)
                    @php
                    $discount[] = $item->discount;
                    $finaltotal[] = $item->total;


                    $pendingingtotal = getOrderDeliveryQuantity($order->id)['pendingQuantity']; 
                    //dd($pendingingtotal);
                    @endphp


                    @if (auth()->user()->hasRole('Delivery User'))
                    @if (getDeliverQuantity($item->order_id, $item->id) != 0)
                    <tr>
                        <td class="align-middle ">
                            {{ $loop->iteration }}
                        </td>
                        <td class="align-middle ">
                            <div style="max-height: 80px; max-width: 80px;">

                                <img class="img-fluid" src="{{ asset(!empty(productsInfo($item->product->id)->image->path) ? Storage::url('products/' . productsInfo($item->product->id)->image->path) : 'img/featured/feature-1.jpg') }}">
                            </div>
                        </td>
                        <td class="align-middle ">
                            {{ $item->product->title }}
                            <div>CODE:<note>{{ $item->product->code }}</note>
                            </div>
                            @if(!empty($item->door_type))
                            <div>Type:<note>{{ $item->door_type }}</note>
                            </div>
                            @endif
                            @if(!empty($item->door_location))
                            <div>Location:<note>{{ $item->door_location }}</note>
                            </div>
                            @endif
                            @if(!empty($item->door_jamb))
                            <div>Jamb:<note>{{ $item->door_jamb }}</note>
                            </div>
                            @endif
                            @if(!empty($item->door_left))
                            <div>Left:<note>{{ $item->door_left }}</note>
                            </div>
                            @endif
                            @if(!empty($item->door_right))
                            <div>Right:<note>{{ $item->door_right }}</note>
                            </div>
                            @endif
                        </td>
                        <td class="align-middle ">
                            {{ $item->quantity }}
                        </td>
                        <td class="align-middle ">
                            {{ getDeliverQuantity($item->order_id, $item->id) }}
                        </td>
                        @php
                        $backOrderQty = $item->quantity - getDeliverQuantity($item->order_id, $item->id);
                        @endphp
                        <td class="align-middle ">
                            {{ $backOrderQty }}
                        </td>
                        @can('delivery-order-status')
                        @php
                        $deliverduserdata = getOrderDetailsPendingQuantity($item->order_id, $item->id);
                        @endphp
                        <td class="align-middle ">
                            {{ mangePendingQuantity($item->order_id, $item->id)['deliverdQuantity'] }}
                        </td>
                        <td class="align-middle ">
                            @php
                            $backorder = $item->quantity - getDeliverQuantity($item->order_id, $item->id);
                            $pending = getDeliverQuantity($item->order_id, $item->id) - mangePendingQuantity($item->order_id, $item->id)['deliverdQuantity'];
                            @endphp
                            {{ $backorder + $pending }}
                        </td>
                        @endcan

                        @can('change-order-status')
                        <td class="align-middle ">
                            @php
                            $disabled =
                            (auth()
                            ->user()
                            ->hasRole('Product Assembler') &&
                            !auth()
                            ->user()
                            ->can(['order-status-pending-order-confirmation', 'order-status-complete', 'order-status-failed', 'order-status-dispatch']) &&
                            in_array($item->order_status, [\App\Models\OrderStatus::COMPLETE, \App\Models\OrderStatus::PENDING_ORDER_CONFIRMATION, \App\Models\OrderStatus::FAILED, \App\Models\OrderStatus::DISPATCHED])) ||
                            (auth()
                            ->user()
                            ->hasRole('Delivery User') &&
                            !auth()
                            ->user()
                            ->can(['order-status-pending-order-confirmation', 'order-status-complete', 'order-status-failed', 'order-status-ready-to-production']) &&
                            in_array($item->order_status, [\App\Models\OrderStatus::COMPLETE, \App\Models\OrderStatus::PENDING_ORDER_CONFIRMATION, \App\Models\OrderStatus::FAILED, \App\Models\OrderStatus::READY_TO_PRODUCTION])) ||
                            (auth()
                            ->user()
                            ->hasRole('Accountant') &&
                            !auth()
                            ->user()
                            ->can(['order-status-complete', 'order-status-dispatch']) &&
                            in_array($item->order_status, [\App\Models\OrderStatus::COMPLETE, \App\Models\OrderStatus::READY_TO_DELIVER, \App\Models\OrderStatus::DISPATCHED]));
                            @endphp
                            <select class="form-select form-control-solid" id="order_status" name="order_status" onchange="return updateSpecificProductrStatus('{{ $item->id }}',this, '{{ $item->quantity }}', '{{ getDeliverQuantity($item->order_id, $item->id) }}', '{{ getDeliverQuantity($item->order_id, $item->id) - mangePendingQuantity($item->order_id, $item->id)['deliverdQuantity'] }}','{{$item->order_status}}')" @disabled($disabled)>
                                @foreach ($order_statuses as $status)
                                @if (\App\Models\OrderStatus::COMPLETE == $status->id)
                                <option @disabled(!in_array($status->id, $access_status))
                                    value="{{ $status->id }}" @selected($item->order_status == $status->id)>
                                    {{ convertToReadableStatus($status->name) }}
                                </option>
                                @endif
                                @if (\App\Models\OrderStatus::PENDING_ORDER_CONFIRMATION == $status->id)
                                <option @disabled(!in_array($status->id, $access_status))
                                    value="{{ $status->id }}" @selected($item->order_status == $status->id)>
                                    {{ convertToReadableStatus($status->name) }}
                                </option>
                                @endif
                                @if (\App\Models\OrderStatus::FAILED == $status->id)
                                <option @disabled(!in_array($status->id, $access_status))
                                    value="{{ $status->id }}" @selected($item->order_status == $status->id)>
                                    {{ convertToReadableStatus($status->name) }}
                                </option>
                                @endif
                                @if (\App\Models\OrderStatus::READY_TO_PRODUCTION == $status->id)
                                <option @disabled(!in_array($status->id, $access_status))
                                    value="{{ $status->id }}" @selected($item->order_status == $status->id)>
                                    {{ convertToReadableStatus($status->name) }}
                                </option>
                                @endif
                                @if (\App\Models\OrderStatus::READY_TO_DELIVER == $status->id)
                                <option @disabled(!in_array($status->id, $access_status))
                                    value="{{ $status->id }}" @selected($item->order_status == $status->id)>
                                    {{ convertToReadableStatus($status->name) }}
                                </option>
                                @endif
                                @if (\App\Models\OrderStatus::DISPATCHED == $status->id)
                                <option @disabled(!in_array($status->id, $access_status))
                                    value="{{ $status->id }}" @selected($item->order_status == $status->id)>
                                    {{ convertToReadableStatus($status->name) }}
                                </option>
                                @endif
                                @endforeach
                            </select>
                        </td>
                        @endcan
                        @if (!auth()->user()->hasRole('Super Admin'))
                        @can('delivery-order-status')
                        <td>
                            <button class="btn btn-primary btn-sm" onclick="return DeleiveryupdateSpecificProductrStatus('{{ $item->id }}',this, '{{ $item->quantity }}', '{{ getDeliverQuantity($item->order_id, $item->id) - mangePendingQuantity($item->order_id, $item->id)['deliverdQuantity'] }}', '{{ $item->quantity - getDeliverQuantity($item->order_id, $item->id) }}', '{{ mangePendingQuantity($item->order_id, $item->id)['deliverdQuantity'] }}', '{{$backorder + $pending}}','{{$pendingingtotal}}')">Ready
                                to delivery</button>
                        </td>
                        @endcan
                        @endif
                        @can('order_price')
                        <td class="align-middle ">
                            ${{ number_format($item->unitcost, 2, '.', ',') }}
                        </td>

                        <td class="align-middle ">
                            ${{ number_format(abs($item->discount - $item->total), 2, '.', ',') }}
                        </td>
                        @endcan
                    </tr>
                    @endif
                    @else
                    <tr>
                        <td class="align-middle ">
                            {{ $loop->iteration }}
                        </td>
                        <td class="align-middle ">
                            <div style="max-height: 80px; max-width: 80px;">

                                <img class="img-fluid" src="{{ asset(!empty(productsInfo($item->product->id)->image->path) ? Storage::url('products/' . productsInfo($item->product->id)->image->path) : 'img/featured/feature-1.jpg') }}">
                            </div>
                        </td>
                        <td class="align-middle ">
                            {{ $item->product->title }}
                            <div>CODE:<note>{{ $item->product->code }}</note>
                            </div>
                             @if(!empty($item->door_type))
                            <div>Type:<note>{{ $item->door_type }}</note>
                            </div>
                            @endif
                            @if(!empty($item->door_location))
                            <div>Location:<note>{{ $item->door_location }}</note>
                            </div>
                            @endif
                            @if(!empty($item->door_jamb))
                            <div>Jamb:<note>{{ $item->door_jamb }}</note>
                            </div>
                            @endif
                            @if(!empty($item->door_left))
                            <div>Left:<note>{{ $item->door_left }}</note>
                            </div>
                            @endif
                            @if(!empty($item->door_right))
                            <div>Right:<note>{{ $item->door_right }}</note>
                            </div>
                            @endif
                        </td>
                        <td class="align-middle ">
                            {{ $item->quantity }}
                        </td>
                        <td class="align-middle ">
                            {{ getDeliverQuantity($item->order_id, $item->id) }}
                        </td>

                        <td class="align-middle ">
                            {{ $item->quantity - getDeliverQuantity($item->order_id, $item->id) }}
                        </td>
                        @can('delivery-order-status')
                        @php
                        $deliverduserdata = getOrderDetailsPendingQuantity($item->order_id, $item->id);
                        @endphp
                        <td class="align-middle ">
                            {{ mangePendingQuantity($item->order_id, $item->id)['deliverdQuantity'] }}
                        </td>
                        <td class="align-middle ">
                            @php
                            $backorder = $item->quantity - getDeliverQuantity($item->order_id, $item->id);
                            $pending = getDeliverQuantity($item->order_id, $item->id) - mangePendingQuantity($item->order_id, $item->id)['deliverdQuantity'];
                            @endphp
                            {{ $backorder + $pending }}
                        </td>
                        @endcan

                        @can('change-order-status')
                        <td class="align-middle ">
                            @php
                            $disabled =
                            (auth()
                            ->user()
                            ->hasRole('Product Assembler') &&
                            !auth()
                            ->user()
                            ->can(['order-status-pending-order-confirmation', 'order-status-complete', 'order-status-failed', 'order-status-dispatch']) &&
                            in_array($item->order_status, [\App\Models\OrderStatus::COMPLETE, \App\Models\OrderStatus::PENDING_ORDER_CONFIRMATION, \App\Models\OrderStatus::FAILED, \App\Models\OrderStatus::DISPATCHED])) ||
                            (auth()
                            ->user()
                            ->hasRole('Delivery User') &&
                            !auth()
                            ->user()
                            ->can(['order-status-pending-order-confirmation', 'order-status-complete', 'order-status-failed', 'order-status-ready-to-production']) &&
                            in_array($item->order_status, [\App\Models\OrderStatus::COMPLETE, \App\Models\OrderStatus::PENDING_ORDER_CONFIRMATION, \App\Models\OrderStatus::FAILED, \App\Models\OrderStatus::READY_TO_PRODUCTION])) ||
                            (auth()
                            ->user()
                            ->hasRole('Accountant') &&
                            !auth()
                            ->user()
                            ->can(['order-status-complete', 'order-status-dispatch']) &&
                            in_array($item->order_status, [\App\Models\OrderStatus::COMPLETE, \App\Models\OrderStatus::READY_TO_DELIVER, \App\Models\OrderStatus::DISPATCHED]));
                            @endphp
                            <select class="form-select form-control-solid" id="order_status" name="order_status" onchange="return updateSpecificProductrStatus('{{ $item->id }}',this, '{{ $item->quantity }}', '{{ getDeliverQuantity($item->order_id, $item->id) }}', '{{ getDeliverQuantity($item->order_id, $item->id) - mangePendingQuantity($item->order_id, $item->id)['deliverdQuantity'] }}','{{$item->order_status}}')" @disabled($disabled)>
                                @foreach ($order_statuses as $status)
                                @if (\App\Models\OrderStatus::COMPLETE == $status->id)
                                <option @disabled(!in_array($status->id, $access_status)) value="{{ $status->id }}"
                                    @selected($item->order_status == $status->id)>
                                    {{ convertToReadableStatus($status->name) }}
                                </option>
                                @endif
                                @if (\App\Models\OrderStatus::PENDING_ORDER_CONFIRMATION == $status->id)
                                <option @disabled(!in_array($status->id, $access_status)) value="{{ $status->id }}"
                                    @selected($item->order_status == $status->id)>
                                    {{ convertToReadableStatus($status->name) }}
                                </option>
                                @endif
                                @if (\App\Models\OrderStatus::FAILED == $status->id)
                                <option @disabled(!in_array($status->id, $access_status)) value="{{ $status->id }}"
                                    @selected($item->order_status == $status->id)>
                                    {{ convertToReadableStatus($status->name) }}
                                </option>
                                @endif
                                @if (\App\Models\OrderStatus::READY_TO_PRODUCTION == $status->id)
                                <option @disabled(!in_array($status->id, $access_status)) value="{{ $status->id }}"
                                    @selected($item->order_status == $status->id)>
                                    {{ convertToReadableStatus($status->name) }}
                                </option>
                                @endif
                                @if (\App\Models\OrderStatus::READY_TO_DELIVER == $status->id)
                                <option @disabled(!in_array($status->id, $access_status)) value="{{ $status->id }}"
                                    @selected($item->order_status == $status->id)>
                                    {{ convertToReadableStatus($status->name) }}
                                </option>
                                @endif
                                @if (\App\Models\OrderStatus::DISPATCHED == $status->id)
                                <option @disabled(!in_array($status->id, $access_status)) value="{{ $status->id }}"
                                    @selected($item->order_status == $status->id)>
                                    {{ convertToReadableStatus($status->name) }}
                                </option>
                                @endif
                                @endforeach
                            </select>
                        </td>
                        @endcan
                        @if (!auth()->user()->hasRole('Super Admin'))
                        @can('delivery-order-status')
                        <td>
                            <button class="btn btn-primary btn-sm" onclick="return DeleiveryupdateSpecificProductrStatus('{{ $item->id }}',this, '{{ $item->quantity }}', '{{ getDeliverQuantity($item->order_id, $item->id) - mangePendingQuantity($item->order_id, $item->id)['deliverdQuantity'] }}', '{{ $item->quantity - getDeliverQuantity($item->order_id, $item->id) }}', '{{ mangePendingQuantity($item->order_id, $item->id)['deliverdQuantity'] }}', '{{$backorder + $pending}}', '{{$pendingingtotal}}')">Ready
                                to delivery</button>
                        </td>
                        @endcan
                        @endif
                        @can('order_price')
                        <td class="align-middle ">
                            ${{ number_format($item->unitcost, 2, '.', ',') }}
                        </td>

                        <td class="align-middle ">
                            ${{ number_format(abs($item->discount - $item->total), 2, '.', ',') }}
                        </td>
                        @endcan
                    </tr>
                    @endif
                    @endforeach

                    @php
                    $finaltotal = array_sum($finaltotal);
                    $discount = array_sum($discount);
                    $finaltotal = $finaltotal - $discount;
                    $orderTotal = abs($order->due - $finaltotal);
                    @endphp
                    
                    @if(count($order->details) > 0)
                    @can('order_price')
                    <tr>
                        <td colspan="10" class="text-end">Shipping Charges:</td>
                        <td style="border-bottom: 1px solid #000 !important;">
                            ${{ number_format($order->due, 2, '.', ',') }}
                        </td>
                    </tr>
                   
                    @if (isset($_ENV['GST_HST_TAX']) || isset($_ENV['PST_RST_QST_TAX']))
                    <tr>
                        <td colspan="10" class="text-end">Total before Tax:</td>
                        <td> ${{ number_format($orderTotal, 2, '.', ',') }}</td>
                    </tr>
                    <tr>
                        @php
                        $orderTotal = $orderTotal + env('GST_HST_TAX', 11, 94);
                        @endphp
                        <td colspan="10" class="text-end">Estimated GST/HST:</td>
                        <td> ${{ number_format(env('GST_HST_TAX'), 2, '.', ',') }}</td>
                    </tr>
                    <tr>
                        @php
                        $orderTotal = $orderTotal + env('PST_RST_QST_TAX', 11, 94);
                        @endphp
                        <td colspan="10" class="text-end">Estimated PST/RST/QST:</td>
                        <td style="border-bottom: 1px solid #000 !important;">
                            ${{ number_format(env('PST_RST_QST_TAX'), 2, '.', ',') }}
                        </td>
                    </tr>
                    @endif
                    <tr>
                        <td colspan="10" class="text-end">Total:</td>
                        <td class="">${{ number_format($orderTotal, 2, '.', ',') }}</td>
                    </tr>
                    @endcan
                    @endif

                </tbody>
            </table>

            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">
                                {{ __('Add Delivery Product Quantity') }}
                            </h5>
                            <button type="button" class="close" aria-label="Close" onclick="closeModal()">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <!-- <form id="delivery_Quantity" action="{{ route('order.per.product.delivery') }}" method="Post"> -->
                            <!-- @csrf -->
                            <div class="mb-3 row delivery-products">
                                <input type="hidden" name="item_id" id="item_id" value="">
                                <input type="hidden" name="order_id" id="order_id" value="{{ $order->id }}">
                                <input type="hidden" name="new_status" id="new_status" value="">
                                <input type="hidden" name="orders_quantity" id="orders_quantity" value="">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="note" class="col-md-12 col-form-label text-md-end text-start">
                                            {{ __('Order Quantity :') }} <span id="order_quantity"></span>
                                        </label>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="note" class="col-md-12 col-form-label text-md-end text-start">
                                            {{ __('Production Ready Quantity :') }} <span id="delivery_order">0</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="note" class="col-md-12 col-form-label text-md-end text-start">
                                            {{ __('To be Delivered Quantity :') }}
                                        </label>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="col-md-12" style="line-height: 35px;">
                                            <input type="number" name="delivery_quantity" id="delivery_quantity" class="form-control example-date-input" value="{{ old('delivery_quantity') }}" required min="0">
                                            @error('delivery_quantity')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <!-- </form> -->
                            <div class="row ">
                                <div class="col-md-12 errors">
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer delivery-products-footer">
                            <div class="row">
                                <div class="col-md-12 mt-6">
                                    <input type="button" class="btn btn-primary btn-sm" onclick="return updateOrderItemQuantity();" name="submit" value="Submit">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!------------deleivered user popup ------------------------>

            <div class="modal fade" id="deliveredModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">
                                {{ __('Add Delivery Product Quantity') }}
                            </h5>
                            <button type="button" class="close" aria-label="Close" onclick="deliveredcloseModal()">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <!-- <form id="delivery_Quantity" action="{{ route('order.per.product.delivery') }}" method="Post"> -->
                            <!-- @csrf -->
                            <div class="mb-3 row delivery-products">
                                <input type="hidden" name="item_id" id="d-item_id" value="">
                                <input type="hidden" name="order_id" id="d-order_id" value="{{ $order->id }}">
                                <input type="hidden" name="new_status" id="d-new_status" value="">
                                <input type="hidden" name="backorder" id="d-bacorder" value="">
                                <input type="hidden" name="totalmainpending" id="d-totalmainpending" value="">
                                <input type="hidden" name="orders_quantity" id="d-orders_quantity" value="">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="note" class="col-md-12 col-form-label text-md-end text-start">
                                            {{ __('Order Quantity :') }} <span id="d-order_quantity"></span>
                                        </label>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="note" class="col-md-12 col-form-label text-md-end text-start">
                                            {{ __('Deliverd Quantity :') }} <span id="d-deliverd_quantity">0</span>
                                        </label>
                                    </div>
                                    <input type="hidden" value="0" id="d-delivery_order">


                                    {{-- <div class="col-md-6 mb-3">
                                            <label for="note" class="col-md-12 col-form-label text-md-end text-start">
                                                {{ __('Backorder Quantity :') }} <span id="d-missing_item">0</span>
                                    </label>
                                </div> --}}
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="note" class="col-md-12 col-form-label text-md-end text-start">
                                        {{ __('To be Delivered Quantity :') }}
                                    </label>
                                </div>
                                <div class="col-md-6">
                                    <div class="col-md-12" style="line-height: 35px;">
                                        <input type="number" name="delivery_quantity" id="d-delivery_quantity" class="form-control example-date-input" value="{{ old('delivery_quantity') }}" required min="0">
                                        @error('delivery_quantity')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                        </div>
                        <!-- </form> -->
                        <div class="row ">
                            <div class="col-md-12 errors">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer delivery-products-footer">
                        <div class="row">
                            <div class="col-md-12 mt-6">
                                <input type="button" class="btn btn-primary btn-sm" onclick="return deleiveryupdateOrderItemQuantity();" name="submit" value="Submit">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


    </div>
</div>
</div>
@endsection
@section('scripts')
<script>
    function updateSpecificProductrStatus(itemId, selectElement, order_quantity = '0', deliver_quantity = '0',
        backorder_quantity = '0', currentStatus = 0) {
        var newStatus = selectElement.value;
        if (newStatus == 5) {
            jQuery('#exampleModal').modal('show');
            jQuery('#order_quantity').text(order_quantity);
            jQuery('#delivery_order').text(deliver_quantity);
            jQuery('#item_id').val(itemId);
            jQuery('#orders_quantity').val(order_quantity);
            jQuery('#new_status').val(newStatus);
        } else {
            updateOrderItemStatus(itemId, newStatus);
        }

        jQuery('#exampleModal').on('hidden.bs.modal', function(e) {
            // Reset the selected index of the original select element
            console.log('currentStatus:', currentStatus - 1);
            selectElement.selectedIndex = currentStatus - 1;
        });
    }

    function DeleiveryupdateSpecificProductrStatus(itemId, selectElement, order_quantity = '0', deliver_quantity = '0', backorder_quantity = '0', deliverdqty = '0',  backorder = '0', totalmainpending = '0') {
        var newStatus = 6;
        jQuery('#deliveredModal').modal('show');
        jQuery('#d-delivery_quantity').val('');
        jQuery('#d-order_quantity').text(order_quantity);
        jQuery('#d-delivery_order').val(deliver_quantity);
        jQuery('#d-deliverd_quantity').text(deliverdqty);
        jQuery('#d-item_id').val(itemId);
        jQuery('#d-orders_quantity').val(order_quantity);
        jQuery('#d-new_status').val(newStatus);
        jQuery('#d-bacorder').val(backorder);
        jQuery('#d-totalmainpending').val(totalmainpending);



    }

    function updateOrderItemStatus(itemId, newStatus) {
        jQuery.ajax({
            url: '/admin/update-product-status', // Replace with your actual route
            type: 'POST',
            data: {
                item_id: itemId,
                new_status: newStatus,
                _token: '{{ csrf_token() }}' // Add CSRF token if needed
            },
            success: function(response) {

                if (response.success) {
                    jQuery('#success-message').text('Order Status Updated!').show();
                    setTimeout(() => {
                        jQuery('#success-message').hide();
                        if (result.isConfirmed) {
                            location.reload();
                        }
                    }, 2000);
                } else {
                    jQuery('#error-message').text('Order Status Error!').show();
                    setTimeout(() => {
                        jQuery('#error-message').hide();
                        if (result.isConfirmed) {
                            location.reload();
                        }
                    }, 2000);
                }
            },
            error: function(error) {
                // Handle error, if needed
                console.error('Error updating order status', error);
            }
        });
    }

    function updateOrderItemQuantity() {
        jQuery('.errors').html('');
        let order_quantity = jQuery('#order_quantity').text(); // Ordered Qty
        let delivery_order = jQuery('#delivery_order').text(); // Delivered Qty
        let delivery_quantity = jQuery('#delivery_quantity').val(); // Entered Qty
        let orderId = jQuery('#order_id').val();
        let itemId = jQuery('#item_id').val();
        let newStatus = jQuery('#new_status').val();

        if (delivery_quantity <= 0) {
            jQuery('.errors').append(`<span class="text-danger ">Delivery quantity is required!</span>`);
            hideErrors();
            return false;
        }
        console.log("order_quantity", delivery_quantity, (order_quantity - delivery_order));

        // if (delivery_quantity > (order_quantity - delivery_order) || ((delivery_order + delivery_quantity) <
        //         order_quantity)) {
        if (parseInt(delivery_quantity) > (parseInt(order_quantity) - parseInt(delivery_order)) || ((parseInt(order_quantity) - parseInt(delivery_order)) == 0)) {
            jQuery('.errors').append(
                `<span class="text-danger ">Delivery quantity must be less then Ordered quantity</span>`);
            hideErrors();
            return false;
        }
        jQuery.ajax({
            url: "{{ route('order.per.product.delivery') }}", // Replace with your actual route
            type: 'POST',
            data: {
                item_id: itemId,
                new_status: newStatus,
                order_quantity: order_quantity,
                delivery_quantity: delivery_quantity,
                delivery_order: delivery_order,
                orderId: orderId,
                _token: '{{ csrf_token() }}' // Add CSRF token if needed
            },
            success: function(response) {
                console.log("response", response);
                // Handle success, if needed
                if (response.success) {
                    jQuery('#delivery_order').text((delivery_order + delivery_quantity));
                    jQuery('#exampleModal').modal('hide');
                    jQuery('#success-message').text('Order Status and Quantity updated!').show();
                    setTimeout(() => {
                        jQuery('#success-message').hide();
                    }, 2000);
                    location.reload();
                } else if (response.error) {
                    jQuery('.errors').append(`<span class="text-danger ">${response.error}</span>`);
                    hideErrors();
                } else {
                    errorCheck = true;
                    // Iterate over the error messages
                    for (const field in response.errors) {
                        if (Object.hasOwnProperty.call(response.errors, field)) {
                            const errorMessages = response.errors[field];
                            // Print each error message
                            errorMessages.forEach(errorMessage => {
                                console.error(`${field}: ${errorMessage}`);
                                jQuery('.errors').append(
                                    `<span class="text-danger ">${errorMessage}</span>`);
                            });
                        }
                    }
                    hideErrors();
                }
            },
            error: function(error) {
                // Handle error, if needed
                console.error('Error updating order status', error);
            }
        });


    }

    function deleiveryupdateOrderItemQuantity() {
        jQuery('.errors').html('');
        let order_quantity = jQuery('#d-order_quantity').text(); // Ordered Qty
        let delivery_order = jQuery('#d-delivery_order').val(); // pending Delivered Qty
        let delivery_quantity = jQuery('#d-delivery_quantity').val(); // Entered Qty
        let orderId = jQuery('#d-order_id').val();
        let itemId = jQuery('#d-item_id').val();
        let newStatus = jQuery('#d-new_status').val();
        let backorder = jQuery('#d-bacorder').val();
        let totalmainpending = jQuery('#d-totalmainpending').val();
        let deliverd_quantity = jQuery('#d-deliverd_quantity').text();
        
        //alert(delivery_order);
        //return false;
        
        //let missingqty = jQuery('#d-missing_item').text();

        if (delivery_quantity <= 0) {
            jQuery('.errors').append(`<span class="text-danger ">Delivery quantity is required!</span>`);
            hideErrors();
            return false;
        }
        console.log("order_quantity", delivery_quantity, delivery_order);
        if (parseInt(delivery_order) < parseInt(delivery_quantity)) {
            jQuery('.errors').append(
                `<span class="text-danger">You have delivered all the quantity that was assigned by the assembler.</span>`
            );
            hideErrors();
            return false;
        }else if(delivery_order < 0){
            jQuery('.errors').append(
                `<span class="text-danger">You have delivered all the quantity that was assigned by the assembler >0.</span>`
            );
            hideErrors();
            return false;
        }else if (delivery_order <= 0) {
            jQuery('.errors').append(
                `<span class="text-danger">You have delivered all the quantity that was assigned by the assembler.</span>`
            );
            hideErrors();
            return false;
        }
        jQuery.ajax({
            url: "{{ route('order.per.product.delivery-user') }}", // Replace with your actual route
            type: 'POST',
            data: {
                orderId: orderId,
                item_id: itemId,
                new_status: newStatus,
                order_quantity: order_quantity,
                delivery_quantity: delivery_quantity,
                delivery_order: delivery_order,
                backorder: backorder,
                totalmainpending:totalmainpending,
                deliverd_quantity:deliverd_quantity,

                _token: '{{ csrf_token() }}' // Add CSRF token if needed
            },
            success: function(response) {
                console.log("response", response);
                // Handle success, if needed
                if (response.success) {
                    jQuery('#d-orders_quantity').val((delivery_order - delivery_quantity));
                    jQuery('#delivery_order').text((delivery_order + delivery_quantity));
                    jQuery('#exampleModal').modal('hide');

                    jQuery('#success-message').text('Order Status and Quantity updated!').show();
                    setTimeout(() => {
                        jQuery('#success-message').hide();
                    }, 2000);
                    location.reload();
                } else if (response.error) {
                    jQuery('.errors').append(`<span class="text-danger ">${response.error}</span>`);
                    hideErrors();
                } else {
                    errorCheck = true;
                    // Iterate over the error messages
                    for (const field in response.errors) {
                        if (Object.hasOwnProperty.call(response.errors, field)) {
                            const errorMessages = response.errors[field];
                            // Print each error message
                            errorMessages.forEach(errorMessage => {
                                console.error(`${field}: ${errorMessage}`);
                                jQuery('.errors').append(
                                    `<span class="text-danger ">${errorMessage}</span>`);
                            });
                        }
                    }
                    hideErrors();
                }
            },
            error: function(error) {
                // Handle error, if needed
                console.error('Error updating order status', error);
            }
        });
    }

    function hideErrors() {
        setTimeout(() => {
            jQuery('.errors span.text-danger').fadeOut('slow', function() {
                jQuery(this).remove();
            });
        }, 5000);
    }

    function closeModal() {
        var modal = document.getElementById('exampleModal');
        if (modal) {
            $(modal).modal('hide');

        }
    }

    function deliveredcloseModal() {
        var modal = document.getElementById('deliveredModal');
        if (modal) {
            $(modal).modal('hide');
        }
    }
    
</script>
@endsection