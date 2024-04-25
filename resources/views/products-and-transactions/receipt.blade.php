@extends('layouts.admin')

@section('title', 'CiptaPOS | Receipt')

@section('content')
    @include('layouts.navbar')
    <div class="activearea mt-5" style="width: 30%; box-shadow: 5px 5px 5px lightgray; border: 1px solid lightgray; padding: 2%; display: flex; flex-direction: column; margin: 0 auto;">
        <div class="header" style="display: flex; gap: 0px; align-items: center; flex-direction: column;">
            <div class="headeritem" style="display: flex; margin-top: -3%;">
                <img src="{{ asset('storage/image/ciptaposlogoonly.png') }}" class="img-fluid" alt="CiptaPOSLogo" style="max-height: 40px;">
            </div>
            <div class="headeritem" style="display: flex;">
                <h2 style="margin: 0;"> CiptaPOS </h2>
            </div>
        </div>
        <div class="capper" style="margin-top: -3%;">
            <hr style="border: 1px; border-bottom: 1px solid grey;">
        </div>
        <div class="details">
            <div class="dcolumn" style="display: flex; flex-direction: row; justify-content: space-between; padding: 2%; margin-top: -1%; margin-bottom: -1%;">
                <div class="ditems left"> Date </div>
                <div class="ditems right"> {{ $transaction->transaction_date }} </div>
            </div>
            <div class="dcolumn" style="display: flex; flex-direction: row; justify-content: space-between; padding: 2%; margin-top: -1%; margin-bottom: -1%;">
                <div class="ditems left"> Transaction ID </div>
                <div class="ditems right"> {{ $transaction->id }} </div>
            </div>
            <div class="dcolumn" style="display: flex; flex-direction: row; justify-content: space-between; padding: 2%; margin-top: -1%; margin-bottom: -1%;">
                <div class="ditems left"> Cashier </div>
                <div class="ditems right"> {{ $transaction->user->name }} </div>
            </div>
            <div class="dcolumn" style="display: flex; flex-direction: row; justify-content: space-between; padding: 2%; margin-top: -1%; margin-bottom: -1%;">
                <div class="ditems left"> Payment Method </div>
                <div class="ditems right"> {{ $transaction->paymentMethod->name }} </div>
            </div>
        </div>
        <div class="capper" style="margin-top: -3%;">
            <hr style="border: 1px; border-bottom: 1px solid grey;">
        </div>
        <div class="items">
            @foreach($transaction->transactionDetails as $detail)
                <div class="itemcolumn" style="display: flex; flex-direction: row; justify-content: space-between; padding: 2%; margin-top: -1%; margin-bottom: -1%;">
                    <div class="iname"> {{ $detail->product->name }} </div>
                    <div class="iqty"> x{{ $detail->quantity }} </div>
                    <div class="iprice"> Rp {{ number_format($detail->price * $detail->quantity, 2) }} </div>
                </div>
            @endforeach
        </div>
        <div class="capper" style="margin-top: -3%;">
            <hr style="border: 1px; border-bottom: 1px solid grey;">
        </div>
        <div class="details">
            <div class="dcolumn" style="display: flex; flex-direction: row; justify-content: space-between; padding: 2%; margin-top: -1%; margin-bottom: -1%;">
                <div class="ditems"> <b> Total </b> </div>
                <div class="ditems"> Rp {{ number_format($transaction->calculateTotalPrice(), 2) }} </div>
            </div>
            <div style="text-align: center;">
                <a href="{{route('dashboard')}}" class="btn btn-danger" style="margin-bottom: 20px; margin-top: 20px; display: inline-block;">Return to transaction page</a>
            </div>
        </div>
    </div>
@endsection
