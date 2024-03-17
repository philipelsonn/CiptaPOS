@extends('layouts.admin')

@section('title', 'CiptaPOS | Manage Employees')

@section('content')

@include('layouts.navbar')
    <div class="container my-auto">
        <div class="card p-4 bg-light mt-3 mb-3">
            <div class="d-flex justify-content-between mt-2 mb-4">
                <h2 class="fw-bold">Employees</h2>
                <a class="btn btn-lg btn-success text-white fw-bold" data-bs-toggle="modal" data-bs-target="#addEmployee">Add Employee</a>
            </div>
            <div class="table-responsive">
                <table id="myTable" class="table table-striped bg-light">
                    <thead>
                        <tr class="">
                            <th class="col-md-1 align-middle">ID</th>
                            <th class="col-md-9 align-middle">Name</th>
                            <th class="col-md-9 align-middle">Email</th>
                            <th class="col-md-9 align-middle">Phone</th>
                            <th class="col-md-9 align-middle">Type</th>
                            <th class="col-md-9 align-middle">Salary</th>
                            <th class="col-md-2 align-middle">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php($i = 1)
                        @foreach ($employees as $employee)
                            <tr>
                                <td class="align-middle fw-bold">{{ $employee->id }}</td>
                                <td class="align-middle">{{ $employee->name }}</td>
                                <td class="align-middle">{{ $employee->email }}</td>
                                <td class="align-middle">{{ $employee->phone_number }}</td>
                                <td class="align-middle">{{ $employee->type }}</td>
                                <td class="align-middle">{{ $employee->salary }}</td>
                                <td class="align-middle">
                                    <div class="d-flex">
                                        {{-- <a class="btn btn-sm btn-warning me-2" data-bs-toggle="modal" data-bs-target="#update{{$employee->id}}">
                                            <i class='far fa-edit'></i></a> --}}
                                        <form action="{{ route('employees.destroy', $employee->id) }}" method="POST">
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

    <div class="modal" id="addEmployee" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Payment Method</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('register') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="name" class="form-label">{{ __('Name') }}</label>
                            <input id="name" class="form-control" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name" />
                        </div>     
                        <div class="mb-3">
                            <label for="email" class="form-label">{{ __('Email') }}</label>
                            <input id="email" class="form-control" type="email" name="email" value="{{ old('email') }}" required autocomplete="username" />
                        </div>
                        <div class="mb-3">
                            <label for="phone_number" class="form-label">{{ __('Phone Number') }}</label>
                            <input id="phone_number" class="form-control" type="text" name="phone_number" value="{{ old('phone_number') }}" required autocomplete="tel" />
                        </div>
                        <div class="mb-3">
                            <label for="type" class="form-label">{{ __('Type') }}</label>
                            <select id="type" name="type" class="form-select" aria-label="Select type">
                                <option value="employee" {{ old('type', 'employee') === 'employee' ? 'selected' : '' }}>Employee</option>
                                <option value="admin" {{ old('type') === 'admin' ? 'selected' : '' }}>Admin</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="salary" class="form-label">{{ __('Salary') }}</label>
                            <input id="salary" class="form-control" type="number" name="salary" value="{{ old('salary') }}" required autocomplete="salary" />
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">{{ __('Submit') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
