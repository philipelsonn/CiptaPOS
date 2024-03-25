@extends('layouts.admin')

@section('title', 'CiptaPOS | Manage Supplier Transactions')

@section('content')

@include('layouts.navbar')

<div class="container my-auto">
    <div class="card p-4 bg-light mt-3 mb-3">
        <div class="d-flex justify-content-between mt-2 mb-4">
            <h2 class="fw-bold">Transaction History</h2>
        </div>
        <div class="table-responsive">
            <table id="myTable" class="table table-striped bg-light">
                <thead>
                    <tr>
                        <th style="text-align: center;">ID</th>
                        <th style="text-align: center;">Payment Method</th>
                        <th style="text-align: center;">Cashier ID</th>
                        <th style="text-align: center;">Transaction Date</th>
                        <th style="text-align: center;">Product</th>
                        <th style="text-align: center;">Price</th>
                        <th style="text-align: center;">Quantity</th>
                        <th style="text-align: center;">Total Price</th>

                    </tr>
                </thead>
                <tbody>
                    @foreach ($transactionDetails as $transactionDetail)
                    <tr>
                        <td style="text-align: center;">{{ $transactionDetail->transactionHeader->id }}</td>
                        <td style="text-align: center;">{{ $transactionDetail->transactionHeader->paymentMethod->name }}</td>
                        <td style="text-align: center;">{{ $transactionDetail->transactionHeader->user->name }}</td>
                        <td style="text-align: center;">{{ $transactionDetail->transactionHeader->transaction_date }}</td>
                        <td style="text-align: center;">{{ $transactionDetail->product->name }}</td>
                        <td style="text-align: center;">Rp {{ number_format($transactionDetail->price, 0, ',', '.') }}</td>
                        <td style="text-align: center;">{{ $transactionDetail->quantity }}</td>
                        <td style="text-align: center;">Rp {{ number_format($transactionDetail->price * $transactionDetail->quantity, 0, ',', '.') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="mt-3">
            <p class="fw-bold">Total revenue from all transactions: Rp {{ number_format($totalRevenue, 0, ',', '.') }}</p>
        </div>
        <h5>Most Sold Products This Month</h5>
        <ul>
            @foreach ($mostSoldProducts as $soldProduct)
                <li>{{ $soldProduct->product->name }} - {{ $soldProduct->total_quantity }} units</li>
            @endforeach
        </ul>
    </div>
</div>
@endsection
