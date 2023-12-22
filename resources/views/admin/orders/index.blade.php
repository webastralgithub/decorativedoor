@extends('admin.layouts.app')

@section('content')
<div class="card mx-4">
    <div class="card-header">Manage Orders</div>
    <div class="card-body">

        @can('create-user')
        <a href="{{ route('orders.create') }}" class="btn btn-primary btn-sm my-2"><i class="bi bi-plus-circle"></i> Add New Order</a>
        @endcan

        <table class="table table-striped table-bordered">
            <thead>
                <th>{{__('ID')}}</th>
                <th>{{__('Customer')}}</th>
                <th>{{__('Date')}}</th>
                <th>{{__('Payment')}}</th>
                <th>{{__('Total')}}</th>
                <th>{{__('Status')}}</th>
                <th>{{__('Action')}}</th>
            </thead>
            <tbody>
                @foreach ($orders as $order)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $order->user->name }}</td>
                    <td>{{ $order->order_date->format('d-m-Y') }}</td>
                    <td>{{ $order->payment_type }}</td>
                    <td>{{ number_format($order->total) }}</td>
                    <td>
                        <a class="{{ $order->order_status === 1 ? 'text-success' : 'text-info' }}">
                            {{ ($order->order_status == 1) ? 'Completed' : 'Pending' }}
                            <a>
                    </td>
                    <td>
                        <a class="btn btn-warning btn-sm" href="{{ route('orders.show', $order) }}"> Show</a>
                        <a class="btn btn-primary btn-sm" href="{{ route('order.downloadInvoice', $order) }}">Print</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

    </div>
</div>
@endsection