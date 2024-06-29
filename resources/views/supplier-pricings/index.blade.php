@extends('layouts.admin')

@section('title', 'CiptaPOS | Manage Supplier Pricings')

@section('content')

@include('layouts.navbar')
    <div class="container my-auto">
        <div class="card p-4 bg-light mt-3 mb-3">
            <div class="d-flex justify-content-between mt-2 mb-4">
                <h2 class="fw-bold">Supplier Pricings</h2>
                <a class="btn btn-lg btn-success text-white fw-bold" data-bs-toggle="modal" data-bs-target="#addSupplierPricing">Add Supplier Pricing</a>
            </div>
            <div class="table-responsive">
                <table id="myTable" class="table table-striped bg-light">
                    <thead>
                        <tr class="">
                            <th class="col-md-1 align-middle">ID</th>
                            <th class="col-md-4 align-middle">Product</th>
                            <th class="col-md-4 align-middle">Supplier</th>
                            <th class="col-md-2 align-middle">Price</th>
                            <th class="col-md-1 align-middle">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php($i = 1)
                        @foreach ($supplierPricings as $supplierPricing)
                            <tr>
                                <td class="align-middle fw-bold">{{ $supplierPricing->id }}</td>
                                <td class="align-middle">{{ $supplierPricing->product->name }}</td>
                                <td class="align-middle">{{ $supplierPricing->supplier->company_name }}</td>
                                <td class="align-middle">Rp {{ number_format($supplierPricing->price, 0, ',', '.') }}</td>
                                <td class="align-middle">
                                    <div class="d-flex">
                                        <a class="btn btn-sm btn-warning me-2" data-bs-toggle="modal" data-bs-target="#update{{$supplierPricing->id}}">
                                            <i class='far fa-edit'></i></a>
                                        <form action="{{ route('supplier-pricings.destroy', $supplierPricing->id) }}" method="POST">
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

    @foreach ($supplierPricings as $supplierPricing)
        <div class="modal" id="update{{$supplierPricing->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Update Supplier Pricing</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('supplier-pricings.update', $supplierPricing->id)}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('UPDATE')
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="product_id" class="form-label">{{ __('Product') }}</label>
                                <select id="product_id" name="product_id" class="form-select">
                                    <option value="Select" selected disabled>Select Product</option>
                                    @foreach ($products as $product)
                                        <option value={{$product->id}}
                                            @if ($supplierPricing->product_id == $product->id) selected @endif>
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
                                            @if ($supplierPricing->supplier_id == $supplier->id) selected @endif>
                                            {{ $supplier->company_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="price" class="form-label">{{ __('Price') }}</label>
                                <input id="price" class="form-control" type="number" name="price" value="{{ $supplierPricing->price }}" required min="1">
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

    <div class="modal" id="addSupplierPricing" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Supplier Pricing</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{route('supplier-pricings.store')}}" id = "addSupplierForm"method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="product_id" class="form-label">{{ __('Product') }}</label>
                            <select id="add_product_id" name="product_id" class="form-select">
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
                            <select id="add_supplier_id" name="supplier_id" class="form-select">
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
                            <label for="price" class="form-label">{{ __('Price') }}</label>
                            <input id="price" class="form-control" type="number" name="price" value="{{ old('price') }}" required min="1">
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
            $('#addSupplierForm').submit(function (event) {
                let isValid = true;

                $('.invalid-feedback').remove();
                var supplierPricings = {!! json_encode($supplierPricings) !!};
                const supplierInput = $('#add_supplier_id');
                const productInput = $('#add_product_id');
                const priceInput = $('#price');
                const isDuplicate = supplierPricings.some(pricing => pricing.product_id == productInput.val() && pricing.supplier_id == supplierInput.val());
                if (isDuplicate) {
                    Toastify({
                    text: 'Supplier pricing with this product and supplier already exists.',
                    backgroundColor: 'linear-gradient(to right, #ff416c, #ff4b2b)',
                    className: 'info',
                    duration: 2000, // Durasi dalam milidetik
                    position: 'left', // Posisi bottom left
                    gravity: 'bottom',
                }).showToast();
                isValid = false;
                }
                if (!isValid) {
                    event.preventDefault();
                }
            });
        });
    </script>
@endsection
