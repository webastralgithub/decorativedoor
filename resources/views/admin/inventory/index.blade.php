@extends('admin.layouts.app')

@section('content')
<div class="mx-4 content-p-mobile">
    <div class="page-header-tp">
        <h3>Inventory Information</h3>
        <div class="top-bntspg-hdr">
            <a href="{{ route('inventory.create') }}" class="btn btn-primary btn-sm"> Add Inventory</a>
            <a href="{{ route('inventory.index') }}" class="btn btn-primary btn-sm">&larr; Back</a>
        </div> 
    </div>
    @if(\Session::has('error'))
    <div>
        <li class="alert alert-danger">{!! \Session::get('error') !!}</li>
    </div>
    @endif
    
    @if(\Session::has('success'))
    <div>
        <li class="alert alert-success">{!! \Session::get('success') !!}</li>
    </div>
    @endif
    <div class="content-body">
        <div class="row">
            <div class="col-md-12">
                <div class="card mb-4">
                    {{-- <div class="card-header">
                        <h4 class="card-title">{{__('Statistics_by_Quantity_(TOP 15)')}}</h4>
                    </div> --}}
                    <div class="card-body">
                        <table class="table">
                            <thead>
                                <th>{{__('Product')}}</th>
                                <th>{{__('Inventory Quantity')}}</th>
                                <th>{{__('Order Quantity')}}</th>
                                <th>{{__('Total')}}</th>
                            </thead>
                            <tbody>
                                @foreach($products as $product)
                                @php
                                $inventoryquantity = 0;
                                $orderdetails = 0
                                @endphp
                                @foreach($product->inventories as $inventory)
                                    @php
                                    $inventoryquantity += $inventory->quantity;
                                    @endphp
                                @endforeach
                                @foreach($product->orderdetails as $order)
                                @php
                                $orderdetails += $order->quantity;
                                @endphp
                            @endforeach
                                <tr>
                                    <td>{{ $product->title }}</td>
                                    <td>{{ $inventoryquantity }}</td>
                                    <td>{{ $orderdetails }}</td>
                                    <td>{{ $inventoryquantity - $orderdetails }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection