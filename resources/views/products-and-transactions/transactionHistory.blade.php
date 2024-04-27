@extends('layouts.admin')

@section('title', 'CiptaPOS | Admin Dashboard')

@section('content')

@include('layouts.navbar')

<div class="container my-auto">
    <div class="card p-4 bg-light mt-3 mb-3">
        <div class="d-flex justify-content-between mt-2 mb-4">
            <h2 class="fw-bold">Transaction History</h2>
        </div>
        <div class="table-responsive">
            <table id="transactionTable" class="table table-striped bg-light">
                <thead>
                    <tr>
                        <th style="text-align: center;">ID</th>
                        <th style="text-align: center;">Payment Method</th>
                        <th style="text-align: center;">Cashier</th>
                        <th style="text-align: center;">Transaction Date</th>
                        <th style="text-align: center;">Total Price</th>
                        <th style="text-align: center;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($transactionHeaders as $transaction)
                    <tr>
                        <td style="text-align: center;">{{ $transaction->id }}</td>
                        <td style="text-align: center;">{{ $transaction->paymentMethod->name }}</td>
                        <td style="text-align: center;">{{ $transaction->user->name }}</td>
                        <td style="text-align: center;">{{ $transaction->transaction_date }}</td>
                        <td style="text-align: center;">Rp {{ number_format($transaction->calculateTotalPrice(), 2) }}</td>
                        <td style="text-align: center;">
                        <a class="btn btn-sm btn-success me-2" href="{{ route('product.transactions.receipt', ['id' => $transaction->id]) }}">
                            <i class='far fa-eye'></i></a>
                        @if ($transaction->paymentMethod->name == 'Card')
                            <a class="btn btn-sm btn-info me-2" data-bs-toggle="modal" data-bs-target="#showCardNumber{{$transaction->id}}">
                                <i class='far fa-credit-card'></i></a>
                        @endif
                        </td>
                    </tr>
                    <div class="modal fade" id="showCardNumber{{$transaction->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h5 class="modal-title" id="showCardNumber">Card Number</h5>
                              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                {{$transaction->card_number}}
                            </div>
                          </div>
                        </div>
                      </div>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div style="display: flex; justify-content: space-between; margin-top: 20px;">
            <div style="text-align: center; flex: 1; padding: 10px; border: 1px solid #ccc; border-radius: 5px; background-color: #f9f9f9;">
                <p style="font-weight: bold; margin-bottom: 5px;">Total Revenue</p>
                <p style="font-size: 1.2em;">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</p>
            </div>
            <div style="text-align: center; flex: 1; padding: 10px; border: 1px solid #ccc; border-radius: 5px; background-color: #f9f9f9;">
                <p style="font-weight: bold; margin-bottom: 5px;">Total Outcome</p>
                <p style="font-size: 1.2em;">Rp {{ number_format($totalOutcome, 0, ',', '.') }}</p>
            </div>
            <div style="text-align: center; flex: 1; padding: 10px; border: 1px solid #ccc; border-radius: 5px; background-color: #f9f9f9;">
                <p style="font-weight: bold; margin-bottom: 5px;">Total Profits</p>
                <p style="font-size: 1.2em;">Rp {{ number_format($totalRevenue - $totalOutcome, 0, ',', '.') }}</p>
            </div>
        </div>
    </div>
    <div class="analytics" style="display: flex">
        <div class="card p-5 mt-3 mb-5 bg-light" style="flex: 4;">
            <div class="mt-2 mb-4">
                <h3 class="fw-bold"style="text-align: center">Five Most Sold Product in a month</h3>
            </div>
            <canvas id="mostSoldProductsChart" width="400" height="300"></canvas>
        </div>
        <div class="card bg-light mt-3 mb-5 ms-3" style="flex: 5;">
            <div class="mt-4 mb-4">
                <h3 class="fw-bold" style="text-align: center">5 Most Profitable Transactions</h3>
            </div>
            <table class="table" style="margin: 0 auto; border-collapse: collapse; width: 90%; border: 1px solid #dee2e6;">
                <thead>
                    <tr>
                        <th style="width: 30%; border: 1px solid #dee2e6; padding: 8px;">Product</th>
                        <th style="width: 20%; border: 1px solid #dee2e6; padding: 8px;">Price</th>
                        <th style="width: 20%; border: 1px solid #dee2e6; padding: 8px;">Quantity</th>
                        <th style="width: 20%; border: 1px solid #dee2e6; padding: 8px;">Total Price</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($transactionDetailsTop5 as $transaction)
                    <tr>
                        <td style="border: 1px solid #dee2e6; padding: 8px;">{{ $transaction->product->name }}</td>
                        <td style="border: 1px solid #dee2e6; padding: 8px;">Rp {{ number_format($transaction->price, 0, ',', '.') }}</td>
                        <td style="border: 1px solid #dee2e6; padding: 8px;">{{ $transaction->quantity }}</td>
                        <td style="border: 1px solid #dee2e6; padding: 8px;">Rp {{ number_format($transaction->price * $transaction->quantity, 0, ',', '.') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="card p-5 mt-3 mb-5 bg-light">
        <div class="mt-2 mb-4">
            <h3 class="fw-bold" style="text-align: center">Categories sold in a month</h3>
        </div>
        <div style="display: flex; justify-content: center; align-items: center; width: 100%; height: 600px;">
            <canvas id="mostSoldCategoryChart"></canvas>
        </div>
    </div>
</div>
<script>
   var ctx = document.getElementById('mostSoldCategoryChart').getContext('2d');
var myChart = new Chart(ctx, {
    type: 'pie',
    data: {
        labels: {!! $mostSoldCategories->map(function ($item) { return $item->category; }) !!},
        datasets: [{
            label: 'Total Quantity',
            data: {!! $mostSoldCategories->pluck('total_quantity') !!},
            backgroundColor: [
                'rgba(255, 99, 132, 0.5)',
                'rgba(54, 162, 235, 0.5)',
                'rgba(255, 206, 86, 0.5)',
                'rgba(75, 192, 192, 0.5)',
                'rgba(153, 102, 255, 0.5)'
                // Tambahkan warna tambahan jika diperlukan
            ],
            borderColor: [
                'rgba(255, 99, 132, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)'
                // Tambahkan warna tambahan jika diperlukan
            ],
            borderWidth: 1
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: true,
        plugins: {
            legend: {
                position: 'bottom', // Mengatur posisi legend
                labels: {
                    padding: 30,
                    font: {
                        size: 20 // Mengatur ukuran font label
                    }
                }
            },
            tooltip: {
                callbacks: {
                    label: function(context) {
                        var label = context.label || '';
                        var value = context.raw || '';
                        var percent = context.raw / context.dataset.data.reduce((a, b) => a + b) * 100;
                        return label + ': ' + value + ' (' + percent.toFixed(2) + '%)';
                    }
                }
            }
        }
    }
});

        var colorsByProductName = {
        'Product A': 'rgba(255, 99, 132, 0.2)',
        'Product B': 'rgba(54, 162, 235, 0.2)',
        'Product C': 'rgba(255, 206, 86, 0.2)',
        'Product D': 'rgba(75, 192, 192, 0.2)',
        'Product E': 'rgba(153, 102, 255, 0.2)'
    };
        var ctx = document.getElementById('mostSoldProductsChart').getContext('2d');
        var chart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: {!! json_encode($mostSoldProducts->pluck('product.name')->take(5)) !!},
                datasets: [{
                    label: 'Quantity Sold',
                    data: {!! json_encode($mostSoldProducts->pluck('total_quantity')->take(5)) !!},
                    backgroundColor: Object.values(colorsByProductName),
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    x: {
                        display: false
                    },
                    y: {
                        beginAtZero: true
                    }
                },
                plugins: {
                    legend: {
                        display: true,
                        position: 'bottom',
                        labels: {
                            generateLabels: function(chart) {
                                var labels = chart.data.labels;
                                var datasets = chart.data.datasets;
                                var legendLabels = [];
                                for (var i = 0; i < labels.length; i++) {
                                    legendLabels.push({
                                        text: labels[i],
                                        fillStyle: datasets[0].backgroundColor[i],
                                        hidden: datasets[0].hidden,
                                        lineCap: datasets[0].borderCapStyle,
                                        lineDash: datasets[0].borderDash,
                                        lineDashOffset: datasets[0].borderDashOffset,
                                        lineJoin: datasets[0].borderJoinStyle,
                                        lineWidth: datasets[0].borderWidth,
                                        strokeStyle: datasets[0].borderColor,
                                        pointStyle: 'circle',
                                        rotation: datasets[0].rotation
                                    });
                                }
                                return legendLabels;
                            }
                        }
                    }
                }
            }
        });
    </script>

@endsection
