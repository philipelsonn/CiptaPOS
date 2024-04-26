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
                                <div id="company_name_error{{$supplier->id}}" class="text-danger"></div>
                            </div>
                            <div class="mb-3">
                                <label for="company_address" class="form-label">{{ __('Address') }}</label>
                                <input id="company_address{{$supplier->id}}" class="form-control" type="text" name="company_address" value="{{ $supplier->company_address }}">
                                <div id="company_address_error{{$supplier->id}}" class="text-danger"></div>
                            </div>
                            <div class="mb-3">
                                <label for="pic_name" class="form-label">{{ __('PIC') }}</label>
                                <input id="pic_name{{$supplier->id}}" class="form-control" type="text" name="pic_name" value="{{ $supplier->pic_name }}">
                                <div id="pic_name_error{{$supplier->id}}" class="text-danger"></div>
                            </div>
                            <div class="mb-3">
                                <label for="pic_phone" class="form-label">{{ __('Phone') }}</label>
                                <input id="pic_phone{{$supplier->id}}" class="form-control" type="text" name="pic_phone" value="{{ $supplier->pic_phone }}">
                                <div id="pic_phone_error{{$supplier->id}}" class="text-danger"></div>
                            </div>
                            <div class="mb-3">
                                <label for="pic_email" class="form-label">{{ __('Email') }}</label>
                                <input id="pic_email{{$supplier->id}}" class="form-control" type="text" name="pic_email" value="{{ $supplier->pic_email }}">
                                <div id="pic_email_error{{$supplier->id}}" class="text-danger"></div>
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
                            <div id="company_name_error" class="text-danger"></div>
                        </div>
                        <div class="mb-3">
                            <label for="company_address" class="form-label">{{ __('Address') }}</label>
                            <input id="company_address" class="form-control" type="text" name="company_address" value="{{ old('company_address') }}" required>
                            <div id="company_address_error" class="text-danger"></div>
                        </div>
                        <div class="mb-3">
                            <label for="pic_name" class="form-label">{{ __('PIC') }}</label>
                            <input id="pic_name" class="form-control" type="text" name="pic_name" value="{{ old('pic_name') }}" required>
                            <div id="pic_name_error" class="text-danger"></div>
                        </div>
                        <div class="mb-3">
                            <label for="pic_phone" class="form-label">{{ __('Phone') }}</label>
                            <input id="pic_phone" class="form-control" type="text" name="pic_phone" value="{{ old('pic_phone') }}" required>
                            <div id="pic_phone_error" class="text-danger"></div>
                        </div>
                        <div class="mb-3">
                            <label for="pic_email" class="form-label">{{ __('Email') }}</label>
                            <input id="pic_email" class="form-control" type="text" name="pic_email" value="{{ old('pic_email') }}" required>
                            <div id="pic_email_error" class="text-danger"></div>
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
            var addForm = document.getElementById('addSupplierForm');
            addForm.addEventListener('submit', function(event) {
                var company_name = addForm.querySelector('#company_name').value;
                var company_address = addForm.querySelector('#company_address').value;
                var pic_name = addForm.querySelector('#pic_name').value;
                var pic_phone = addForm.querySelector('#pic_phone').value;
                var pic_email = addForm.querySelector('#pic_email').value;
                var existingCompanyNames = {!! json_encode($suppliers->pluck('company_name')->toArray()) !!};
                if (existingCompanyNames.includes(company_name)) {
                    event.preventDefault();
                    company_name_error.innerText = 'Company Name must be unique.';
                    company_name_error.style.display = 'block';
                } else if(company_name.trim().length < 8){
                    company_name_error.innerText = 'Company Name must be at least 8 characters.';
                    company_name_error.style.display = 'block';
                }
                else {
                    company_name_error.innerText = '';
                    company_name_error.style.display = 'none';
                }
                if (company_address.trim().length < 8) {
                    event.preventDefault();
                    company_address_error.innerText = 'Address must be at least 8 characters.';
                    company_address_error.style.display = 'block';
                } else {
                    company_address_error.innerText = '';
                    company_address_error.style.display = 'none';
                }

                if (pic_name.trim().length < 8) {
                    event.preventDefault();
                    pic_name_error.innerText = 'PIC Name must be at least 8 characters.';
                    pic_name_error.style.display = 'block';
                } else {
                    pic_name_error.innerText = '';
                    ic_name_error.style.display = 'none';
                }


                if (!/^\d+$/.test(pic_phone.trim())) {
                    event.preventDefault();
                    pic_phone_error.innerText = 'Phone number must only include numbers.';
                    pic_phone_error.style.display = 'block';
                } else {
                    pic_phone_error.innerText = '';
                    pic_phone_error.style.display = 'none';
                }

                if (!/^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$/.test(pic_email.trim())) {
                    event.preventDefault();
                    pic_email_error.innerText = 'Invalid email format.';
                    pic_email_error.style.display = 'block';
                } else {
                    pic_email_error.innerText = '';
                    pic_email_error.style.display = 'none';
                }
            });
        });

        document.addEventListener("DOMContentLoaded", function() {
        var updateForms = document.querySelectorAll('[id^="updateFormSupplier"]');
        updateForms.forEach(function(updateForm) {
            updateForm.addEventListener('submit', function(event) {
                var id = updateForm.id.split('updateFormSupplier')[1];
                var company_name = updateForm.querySelector('#company_name'+id).value;
                var company_address = updateForm.querySelector('#company_address'+id).value;
                var pic_name = updateForm.querySelector('#pic_name'+id).value;
                var pic_phone = updateForm.querySelector('#pic_phone'+id).value;
                var pic_email = updateForm.querySelector('#pic_email'+id).value;

                var company_name_error = updateForm.querySelector('#company_name_error'+id);
                var company_address_error = updateForm.querySelector('#company_address_error'+id);
                var pic_name_error = updateForm.querySelector('#pic_name_error'+id);
                var pic_phone_error = updateForm.querySelector('#pic_phone_error'+id);
                var pic_email_error = updateForm.querySelector('#pic_email_error'+id);

                // Validasi company_name
                if (company_name.trim().length < 8) {
                    event.preventDefault();
                    company_name_error.innerText = 'Company Name must be at least 8 characters.';
                    company_name_error.style.display = 'block';
                } else {
                    company_name_error.innerText = '';
                    company_name_error.style.display = 'none';
                }

                // Validasi company_address
                if (company_address.trim().length < 8) {
                    event.preventDefault();
                    company_address_error.innerText = 'Address must be at least 8 characters.';
                    company_address_error.style.display = 'block';
                } else {
                    company_address_error.innerText = '';
                    company_address_error.style.display = 'none';
                }

                // Validasi pic_name
                if (pic_name.trim().length < 8) {
                    event.preventDefault();
                    pic_name_error.innerText = 'PIC Name must be at least 8 characters.';
                    pic_name_error.style.display = 'block';
                } else {
                    pic_name_error.innerText = '';
                    pic_name_error.style.display = 'none';
                }

                if (!/^\d+$/.test(pic_phone.trim())) {
                    event.preventDefault();
                    pic_phone_error.innerText = 'Phone number must only include numbers.';
                    pic_phone_error.style.display = 'block';
                } else {
                    pic_phone_error.innerText = '';
                    pic_phone_error.style.display = 'none';
                }

                // Validasi pic_email
                if (!/^[\w-]+(\.[\w-]+)*@([\w-]+\.)+[a-zA-Z]{2,7}$/.test(pic_email.trim())) {
                    event.preventDefault();
                    pic_email_error.innerText = 'Invalid email format.';
                    pic_email_error.style.display = 'block';
                } else {
                    pic_email_error.innerText = '';
                    pic_email_error.style.display = 'none';
                }
            });
        });
    });
    </script>
@endsection
