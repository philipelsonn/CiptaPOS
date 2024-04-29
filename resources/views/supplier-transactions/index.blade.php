@extends('layouts.admin')

@section('title', 'CiptaPOS | Manage Supplier Transactions')

@section('content')

@include('layouts.navbar')
    <div class="container my-auto">
        <div class="card p-4 bg-light mt-3 mb-3">
            <div class="d-flex justify-content-between mt-2 mb-4">
                <h2 class="fw-bold">Supplier Transactions</h2>
                <a class="btn btn-lg btn-success text-white fw-bold" data-bs-toggle="modal" data-bs-target="#addSupplierTransaction">Add Supplier Transaction</a>
            </div>
            <div class="table-responsive">
                <table id="myTable" class="table table-striped bg-light">
                    <thead>
                        <tr class="">
                            <th class="col-md-1 align-middle">ID</th>
                            <th class="col-md-9 align-middle">Product</th>
                            <th class="col-md-9 align-middle">Supplier</th>
                            <th class="col-md-9 align-middle">Quantity</th>
                            <th class="col-md-9 align-middle">Price</th>
                            <th class="col-md-9 align-middle">Total Price</th>
                            <th class="col-md-9 align-middle">Transaction Date</th>
                            <th class="col-md-2 align-middle">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php($i = 1)
                        @foreach ($supplierTransactions as $supplierTransaction)
                            <tr>
                                <td class="align-middle fw-bold">{{ $supplierTransaction->id }}</td>
                                <td class="align-middle">{{ $supplierTransaction->supplierPricing->product->name }}</td>
                                <td class="align-middle">{{ $supplierTransaction->supplierPricing->supplier->company_name }}</td>
                                <td class="align-middle">{{ $supplierTransaction->quantity }}</td>
                                <td class="align-middle">{{ $supplierTransaction->price }}</td>
                                <td class="align-middle">{{ $supplierTransaction->price * $supplierTransaction->quantity }}</td>
                                <td class="align-middle">{{ $supplierTransaction->transaction_date }}</td>
                                <td class="align-middle">
                                    <div class="d-flex">
                                        <form action="{{ route('supplier-transactions.destroy', $supplierTransaction->id) }}" method="POST">
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

    <div class="modal" id="addSupplierTransaction" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Supplier Transaction</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{route('supplier-transactions.store')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="product_id" class="form-label">{{ __('Product') }}</label>
                            <select id="product_id" name="product_id" class="form-select">
                                <option value="Select" selected disabled>Select Product</option>
                                @foreach ($products as $product)
                                    <option value={{$product->id}}
                                        @if (old('product_id') == $product->id) selected @endif>
                                        {{ $product->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="supplier_id" class="form-label">{{ __('Supplier') }}</label>
                            <select id="supplier_id" name="supplier_id" class="form-select">
                                <option value="Select" selected disabled>Select Supplier</option>
                                @foreach ($suppliers as $supplier)
                                    <option value={{$supplier->id}}
                                        @if (old('supplier_id') == $supplier->id) selected @endif>
                                        {{ $supplier->company_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="quantity" class="form-label">{{ __('Quantity') }}</label>
                            <input id="quantity" class="form-control" type="number" name="quantity" value="{{ old('quantity') }}" required min="1">
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
