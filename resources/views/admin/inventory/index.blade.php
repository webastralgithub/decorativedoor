@extends('admin.layouts.app')

@section('content')
<div class="mx-4 content-p-mobile">
    <div class="page-header-tp">
        <h3>Inventory Information</h3>
        <div class="top-bntspg-hdr">
            <a href="{{ route('category.index') }}" class="btn btn-primary btn-sm">&larr; Back</a>
        </div>
    </div>
    <div class="content-body">
        <div class="row">
            <div class="col-md-12">
                <div class="card mb-4">
                    <div class="card-header">
                        <h4 class="card-title">{{__('Statistics_by_Quantity_(TOP 15)')}}</h4>
                    </div>
                    <div class="card-body">
                        <table class="table">
                            <thead>
                                <th>{{__('ID')}}</th>
                                <th>{{__('Category')}}</th>
                                <th>{{__('Name')}}</th>
                                <th>{{__('stock')}}</th>
                                <th>{{__('Annual_Sales')}}</th>
                                <th>{{__('Average_Price')}}</th>
                                <th>{{__('Annual_income')}}</th>
                                <th></th>
                            </thead>
                            <tbody>
                                @foreach($soldproductsbystock as $soldproduct)
                                <tr>
                                    <td><a href="{{ route('products.show', $soldproduct->product) }}">{{ $soldproduct->product_id }}</a></td>
                                    <td><a href="{{ route('categories.show', $soldproduct->product->category) }}">{{ $soldproduct->product->category->name }}</a></td>
                                    <td>{{ $soldproduct->product->name }}</td>
                                    <td>{{ $soldproduct->product->stock }}</td>
                                    <td>{{ $soldproduct->total_qty }}</td>
                                    <td>{{ format_money(round($soldproduct->avg_price, 2)) }}</td>
                                    <td>{{ format_money($soldproduct->incomes) }}</td>
                                    <td class="td-actions text-right">
                                        <a href="{{ route('products.show', $soldproduct->product) }}" class="btn btn-link" data-toggle="tooltip" data-placement="bottom" title="More Details">
                                            <i class="tim-icons icon-zoom-split"></i>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="card card-tasks">
                    <div class="card-header">
                        <h4 class="card-title">{{__('Statistics_by_Income_(TOP 15)')}}</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-full-width table-responsive">
                            <table class="table">
                                <thead>
                                    <th>{{__('ID')}}</th>
                                    <th>{{__('Category')}}</th>
                                    <th>{{__('Name')}}</th>
                                    <th>{{__('Sold')}}</th>
                                    <th>{{__('Income')}}</th>
                                </thead>
                                <tbody>
                                    @foreach ($soldproductsbyincomes as $soldproduct)
                                    <tr>
                                        <td>{{ $soldproduct->product_id }}</td>
                                        <td><a href="{{ route('categories.show', $soldproduct->product->category) }}">{{ $soldproduct->product->category->name }}</a></td>
                                        <td><a href="{{ route('products.show', $soldproduct->product) }}">{{ $soldproduct->product->name }}</a></td>
                                        <td>{{ $soldproduct->total_qty }}</td>
                                        <td>{{ format_money($soldproduct->incomes) }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card card-tasks">
                    <div class="card-header">
                        <h4 class="card-title">{{__('Statistics_by_Average_Price_(TOP 15)')}}</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-full-width table-responsive">
                            <table class="table">
                                <thead>
                                    <th>{{__('ID')}}</th>
                                    <th>{{__('Category')}}</th>
                                    <th>{{__('Name')}}</th>
                                    <th>{{__('Sold')}}</th>
                                    <th>{{__('Average_Price')}}</th>
                                </thead>
                                <tbody>
                                    @foreach ($soldproductsbyavgprice as $soldproduct)
                                    <tr>
                                        <td>{{ $soldproduct->product_id }}</td>
                                        <td><a href="{{ route('categories.show', $soldproduct->product->category) }}">{{ $soldproduct->product->category->name }}</a></td>
                                        <td><a href="{{ route('products.show', $soldproduct->product) }}">{{ $soldproduct->product->name }}</a></td>
                                        <td>{{ $soldproduct->total_qty }}</td>
                                        <td>{{ format_money(round($soldproduct->avg_price, 2)) }}</td>
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
</div>
@endsection