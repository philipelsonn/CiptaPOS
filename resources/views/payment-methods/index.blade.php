@extends('layouts.admin')

@section('title', 'CiptaPOS | Manage Payment Methods')

@section('content')

@include('layouts.navbar')
    <div class="container my-auto">
        <div class="card p-4 bg-light mt-3 mb-3">
            <div class="d-flex justify-content-between mt-2 mb-4">
                <h2 class="fw-bold">Payment Methods</h2>
                <a class="btn btn-lg btn-success text-white fw-bold" data-bs-toggle="modal" data-bs-target="#addPaymentMethod">Add Payment Method</a>
            </div>
            <div class="table-responsive">
                <table id="myTable" class="table table-striped bg-light">
                    <thead>
                        <tr class="">
                            <th class="col-md-1 align-middle">ID</th>
                            <th class="col-md-9 align-middle">Name</th>
                            <th class="col-md-2 align-middle">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php($i = 1)
                        @foreach ($paymentMethods as $paymentMethod)
                            <tr>
                                <td class="align-middle fw-bold">{{ $paymentMethod->id }}</td>
                                <td class="align-middle">{{ $paymentMethod->name }}</td>
                                <td class="align-middle">
                                    <div class="d-flex">
                                        <a class="btn btn-sm btn-warning me-2" data-bs-toggle="modal" data-bs-target="#update{{$paymentMethod->id}}">
                                            <i class='far fa-edit'></i></a>
                                        <form action="{{ route('payment-methods.destroy', $paymentMethod->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger"
                                                onclick="return confirm('Are you sure you want to permanently delete the data?')">
                                                <i class='far fa-trash-alt'></i></button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @php($i = $i + 1)
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @foreach ($paymentMethods as $paymentMethod)
        <div class="modal" id="update{{$paymentMethod->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Update Payment Method</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('payment-methods.update', $paymentMethod->id)}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('UPDATE')
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="name" class="form-label">{{ __('Name') }}</label>
                                <input id="name" class="form-control" type="text" name="name" value="{{ $paymentMethod->name }}">
                            </div>
                        </div>
                        <div class="modal-footer">
                            @method('PUT')
                            <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach

    <div class="modal" id="addPaymentMethod" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Payment Method</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{route('payment-methods.store')}}" id = "add-method" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="name" class="form-label">{{ __('Name') }}</label>
                            <input id="name" class="form-control" type="text" name="name" value="{{ old('name') }}" required>
                            <div id="name_error" class="text-danger"></div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">{{ __('Submit') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var addForm = document.getElementById('add-method');
            addForm.addEventListener('submit', function(event) {
                var payment_name = addForm.querySelector('#name').value;
                var existingPaymentMethods = {!! json_encode($paymentMethods->pluck('name')->toArray()) !!};
                if (existingPaymentMethods.includes(payment_name)) {
                    event.preventDefault();
                    name_error.innerText = 'Payment Method name must be unique.';
                    name_error.style.display = 'block';
                }
                else {
                    name_error.innerText = '';
                    name_error.style.display = 'none';
                }
            });
        });
    </script>
@endsection
