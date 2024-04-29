@extends('layouts.admin')

@section('title', 'CiptaPOS | Manage Suppliers')

@section('content')

@include('layouts.navbar')
    <div class="container my-auto">
        <div class="card p-4 bg-light mt-3 mb-3">
            <div class="d-flex justify-content-between mt-2 mb-4">
                <h2 class="fw-bold">Suppliers</h2>
                <a class="btn btn-lg btn-success text-white fw-bold" data-bs-toggle="modal" data-bs-target="#addSupplier">Add Supplier</a>
            </div>
            <div class="table-responsive">
                <table id="myTable" class="table table-striped bg-light">
                    <thead>
                        <tr class="">
                            <th class="col-md-1 align-middle">ID</th>
                            <th class="col-md-9 align-middle">Company</th>
                            <th class="col-md-9 align-middle">Address</th>
                            <th class="col-md-9 align-middle">PIC</th>
                            <th class="col-md-9 align-middle">Phone</th>
                            <th class="col-md-9 align-middle">Email</th>
                            <th class="col-md-9 align-middle">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php($i = 1)
                        @foreach ($suppliers as $supplier)
                            <tr>
                                <td class="align-middle fw-bold">{{ $supplier->id }}</td>
                                <td class="align-middle">{{ $supplier->company_name }}</td>
                                <td class="align-middle">{{ $supplier->company_address }}</td>
                                <td class="align-middle">{{ $supplier->pic_name }}</td>
                                <td class="align-middle">{{ $supplier->pic_phone }}</td>
                                <td class="align-middle">{{ $supplier->pic_email }}</td>
                                <td class="align-middle">
                                    <div class="d-flex">
                                        <a class="btn btn-sm btn-warning me-2" data-bs-toggle="modal" data-bs-target="#update{{$supplier->id}}">
                                            <i class='far fa-edit'></i></a>
                                        <form action="{{ route('suppliers.destroy', $supplier->id) }}" method="POST">
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

    @foreach ($suppliers as $supplier)
        <div class="modal" id="update{{$supplier->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Update Suppliers</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('suppliers.update', $supplier->id)}}" id ="updateFormSupplier{{$supplier->id}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('UPDATE')
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="company_name" class="form-label">{{ __('Company') }}</label>
                                <input id="company_name{{$supplier->id}}" class="form-control" type="text" name="company_name" value="{{ $supplier->company_name }}">
                            </div>
                            <div class="mb-3">
                                <label for="company_address" class="form-label">{{ __('Address') }}</label>
                                <input id="company_address{{$supplier->id}}" class="form-control" type="text" name="company_address" value="{{ $supplier->company_address }}">
                            </div>
                            <div class="mb-3">
                                <label for="pic_name" class="form-label">{{ __('PIC') }}</label>
                                <input id="pic_name{{$supplier->id}}" class="form-control" type="text" name="pic_name" value="{{ $supplier->pic_name }}">
                            </div>
                            <div class="mb-3">
                                <label for="pic_phone" class="form-label">{{ __('Phone') }}</label>
                                <input id="pic_phone{{$supplier->id}}" class="form-control" type="text" name="pic_phone" value="{{ $supplier->pic_phone }}">
                            </div>
                            <div class="mb-3">
                                <label for="pic_email" class="form-label">{{ __('Email') }}</label>
                                <input id="pic_email{{$supplier->id}}" class="form-control" type="text" name="pic_email" value="{{ $supplier->pic_email }}">
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

    <div class="modal" id="addSupplier" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Supplier</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{route('suppliers.store')}}" id = "addSupplierForm" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="company_name" class="form-label">{{ __('Company') }}</label>
                            <input id="company_name" class="form-control" type="text" name="company_name" value="{{ old('company_name') }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="company_address" class="form-label">{{ __('Address') }}</label>
                            <input id="company_address" class="form-control" type="text" name="company_address" value="{{ old('company_address') }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="pic_name" class="form-label">{{ __('PIC') }}</label>
                            <input id="pic_name" class="form-control" type="text" name="pic_name" value="{{ old('pic_name') }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="pic_phone" class="form-label">{{ __('Phone') }}</label>
                            <input id="pic_phone" class="form-control" type="text" name="pic_phone" value="{{ old('pic_phone') }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="pic_email" class="form-label">{{ __('Email') }}</label>
                            <input id="pic_email" class="form-control" type="text" name="pic_email" value="{{ old('pic_email') }}" required>
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
    function showError(input, message) {
        const formControl = input.parent();
        const errorDiv = $('<div class="invalid-feedback"></div>').text(message);
        formControl.append(errorDiv);
        input.addClass('is-invalid');
    }
    $(document).ready(function() {
        $('#addSupplierForm').submit(function(event) {
            let isValid = true;

            $('.invalid-feedback').remove();
            $('.has-error').removeClass('has-error');

            const company_name = $('#company_name');
            const company_address = $('#company_address');
            const pic_name = $('#pic_name');
            const pic_phone = $('#pic_phone');
            const pic_email = $('#pic_email');
            const existingCompanyNames = {!! json_encode($suppliers->pluck('company_name')->toArray()) !!};

            if (existingCompanyNames.includes(company_name.val().trim())) {
                showError(company_name, 'Company Name must be unique.');
                isValid = false;
            } else if (company_name.val().trim().length < 8) {
                showError(company_name, 'Company Name must be at least 8 characters.');
                isValid = false;
            }
            else{
                company_name.removeClass('is-invalid');
            }

            if (company_address.val().trim().length < 8) {
                showError(company_address, 'Address must be at least 8 characters.');
                isValid = false;
            }
            else{
                company_address.removeClass('is-invalid');
            }

            if (pic_name.val().trim().length < 8) {
                showError(pic_name, 'PIC Name must be at least 8 characters.');
                isValid = false;
            }
            else{
                pic_name.removeClass('is-invalid');
            }

            if (!/^\d+$/.test(pic_phone.val().trim())) {
                showError(pic_phone, 'Phone number must only include numbers.');
                isValid = false;
            }
            else if(pic_phone.val().length < 8 ){
                showError(pic_phone, 'Phone number length must be 8 characters or above.');
                isValid = false;
            }
            else{
                pic_phone.removeClass('is-invalid');
            }
            if (!/^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$/.test(pic_email.val().trim())) {
                showError(pic_email, 'Invalid email format.');
                isValid = false;
            }
            else {
                pic_email.removeClass('is-invalid');
            }
            if (!isValid) {
                event.preventDefault();
            }
        });
    });


    $(document).ready(function() {
        $('[id^="updateFormSupplier"]').submit(function(event) {
            let isValid = true;

            $('.invalid-feedback').remove();
            $('.is-invalid').removeClass('is-invalid');

            const updateForm = $(this);
            const id = updateForm.attr('id').replace('updateFormSupplier', '');
            const company_name = updateForm.find('#company_name'+id);
            const company_address = updateForm.find('#company_address'+id);
            const pic_name = updateForm.find('#pic_name'+id);
            const pic_phone = updateForm.find('#pic_phone'+id);
            const pic_email = updateForm.find('#pic_email'+id);
            if (company_name.val().trim().length < 8) {
                showError(company_name, 'Company Name must be at least 8 characters.');
                isValid = false;
            } else {
                company_name.removeClass('is-invalid');
            }

            if (company_address.val().trim().length < 8) {
                showError(company_address, 'Address must be at least 8 characters.');
                isValid = false;
            } else {
                company_address.removeClass('is-invalid');
            }

            if (pic_name.val().trim().length < 8) {
                showError(pic_name, 'PIC Name must be at least 8 characters.');
                isValid = false;
            } else {
                pic_name.removeClass('is-invalid');
            }

            if (!/^\d+$/.test(pic_phone.val().trim())) {
                showError(pic_phone, 'Phone number must only include numbers.');
                isValid = false;
            } else if (pic_phone.val().trim().length < 8) {
                showError(pic_phone, 'Phone number length must be 8 characters or above.');
                isValid = false;
            } else {
                pic_phone.removeClass('is-invalid');
            }

            if (!/^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$/.test(pic_email.val().trim())) {
                showError(pic_email, 'Invalid email format.');
                isValid = false;
            } else {
                pic_email.removeClass('is-invalid');
            }

            if (!isValid) {
                event.preventDefault();
            }
        });
    });
    </script>
@endsection
