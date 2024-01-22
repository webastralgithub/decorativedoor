@extends('frontend.layouts.app')
@section('content')
<style>


    .sucess-pag-pop h1 {
        color: #88B04B;
        font-family: "Nunito Sans", "Helvetica Neue", sans-serif;
        font-weight: 900;
        font-size: 40px;
        margin-bottom: 10px;
    }

    .sucess-pag-pop p {
        color: #404F5E;
        font-family: "Nunito Sans", "Helvetica Neue", sans-serif;
        font-size: 20px;
        margin: 0;
    }

    .sucess-pag-pop i {
        color: #39a946;
    font-size: 65px;
    line-height: 82px;
    margin-left: -6px;
    }

    .sucess-pag-pop{
        background: white;
        padding: 60px;
        display: inline-block;
        margin: 0 auto;
        border:unset !important;
    }

    .sucess-pag-pop{
        margin-top: 60px;
    border: 2px solid #39a946 !important;
    margin-bottom: 60px;
    box-shadow: 0 8px 26px #0000002e;
    border-radius: 10px;
    display: flex;
    flex-wrap: nowrap;
    flex-direction: row;
    max-width: 1200px;
    padding: 20px 30px;
    gap: 20px;
    align-items: center;
    }

    .sucess-pop-cnt h1{
        font-size: 30px;
    }

    .sucess-pop-cnt h1,
    .sucess-pop-cnt p{
        color: #39a946;
        text-align: left;
    }

    .sucess-pop-cnt p{
        font-size: 17px;
        line-height: 18px;
    }

    @media (max-width: 900px) {
        .sucess-pag-pop{
            max-width: 90%;
        }
    }


    @media (max-width: 600px) {
        .sucess-pag-pop{
            flex-direction: column;
        }

        .sucess-pop-cnt h1,
        .sucess-pop-cnt p{
            text-align: center;
        }
    }
</style>
<div class="card sucess-pag-pop">
    <div style="border-radius:200px;height: 90px;width: 90px;background: #F8FAF5;border: 4px solid #39a946;text-align: center;">
        <i class="checkmark">✓</i>
    </div>

    <div class="sucess-pop-cnt">
    <h1>Success</h1>
    <h2><strong>{{$orderId}}</strong></h2>
    <p>Thank you for processing the order. We will be in touch with you shortly!</p>
    </div>
</div>
@endsection