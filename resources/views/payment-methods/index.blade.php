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
                            <th class="col-md-10 align-middle">Name</th>
                            <th class="col-md-1 align-middle">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php($i = 1)
                        @foreach ($paymentMethods as $paymentMethod)
                            <tr>
                                <td class="align-middle fw-bold">{{ $paymentMethod->id }}</td>
                                <td class="align-middle">{{ $paymentMethod->name }}</td>
                                <td class="align-middle">
                                    <div class="text-center">
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
    <div class="modal" id="addPaymentMethod" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Payment Method</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{route('payment-methods.store')}}" id = "add-payment-method" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="name" class="form-label">{{ __('Name') }}</label>
                            <input id="name" class="form-control" type="text" name="name" value="{{ old('name') }}" required>
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
        $(document).ready(function () {
            $('#add-payment-method').submit(function (event) {
                let isValid = true;

                $('.invalid-feedback').remove();
                $('.has-error').removeClass('has-error');

                const nameInput = $('#name');
                const existingNames = {!! json_encode($paymentMethods->pluck('name')->toArray()) !!};
                console.log(existingNames);
                if (existingNames.includes(nameInput.val())) {
                    showError(nameInput, 'Payment Method already exists');
                    isValid = false;
                }
                else {
                    nameInput.removeClass('is-invalid');
                }
                if (!isValid) {
                    event.preventDefault();
                }
            });

            function showError(input, message) {
                const formControl = input.parent();
                const errorDiv = $('<div class="invalid-feedback"></div>').text(message);
                formControl.append(errorDiv);
                input.addClass('is-invalid');
            }
        });
    </script>
@endsection
