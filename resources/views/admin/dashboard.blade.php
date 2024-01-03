@extends('admin.layouts.app')
@section('content')
<!-- Sale & Revenue Start -->
<div class="container-fluid px-4">
    <div class="row g-4">
        <div class="col-sm-6 col-xl-4">
            <div class="box-stats bg-light rounded d-flex align-items-start justify-content-between p-4">
                <div class="">
                    <h6 class="text-start">{{productsTotal()}}</h6>
                    <p class="">Products</p>
                </div>
                <img src="{{asset('img/user-square.svg')}}" class="img" />
            </div>
        </div>

        <div class="col-sm-6 col-xl-4">
            <div class="box-stats bg-light rounded d-flex align-items-start justify-content-between p-4">
                <div class="">
                    <h6 class="">{{ordersTotal()}}</h6>
                    <p class="">Orders</p>
                </div>
                <img src="{{asset('img/empty-wallet-tick.svg')}}" class="img" />
            </div>
        </div>
    </div>
</div>
<!-- Sale & Revenue End -->
@endsection