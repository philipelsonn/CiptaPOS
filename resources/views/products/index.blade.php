@extends('layouts.admin')

@section('title', 'CiptaPOS | Manage Products')

@section('content')

@include('layouts.navbar')
    <div class="container my-auto">
        <div class="card p-4 bg-light mt-3 mb-3">
            <div class="d-flex justify-content-between mt-2 mb-4">
                <h2 class="fw-bold">Products</h2>
                <a class="btn btn-lg btn-success text-white fw-bold" data-bs-toggle="modal" data-bs-target="#addProduct">Add Product</a>
            </div>
            <div class="table-responsive">
                <table id="myTable" class="table table-striped bg-light">
                    <thead>
                        <tr class="">
                            <th class="col-md-1 align-middle">ID</th>
                            <th class="col-md-9 align-middle">Name</th>
                            <th class="col-md-9 align-middle">Description</th>
                            <th class="col-md-9 align-middle">Image</th>
                            <th class="col-md-9 align-middle">Price</th>
                            <th class="col-md-9 align-middle">Category</th>
                            <th class="col-md-9 align-middle">Stock</th>
                            <th class="col-md-9 align-middle">Discount</th>
                            <th class="col-md-2 align-middle">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php($i = 1)
                        @foreach ($products as $product)
                            <tr>
                                <td class="align-middle fw-bold">{{ $product->id }}</td>
                                <td class="align-middle">{{ $product->name }}</td>
                                <td class="align-middle">{{ $product->description }}</td>
                                <td class="align-middle">
                                    <img src="/storage/images/product/{{ $product->image }}" alt="{{ $product->name}} image" style="max-height: 40px;">
                                </td>
                                <td class="align-middle">{{ $product->price }}</td>
                                <td class="align-middle">{{ $product->productCategory->name }}</td>
                                <td class="align-middle">{{ $product->stock }}</td>
                                <td class="align-middle">{{ $product->discount }}</td>
                                <td class="align-middle">
                                    <div class="d-flex">
                                        <a class="btn btn-sm btn-warning me-2" data-bs-toggle="modal" data-bs-target="#update{{$product->id}}">
                                            <i class='far fa-edit'></i></a>
                                        <form action="{{ route('products.destroy', $product->id) }}" method="POST">
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

    @foreach ($products as $product)
        <div class="modal" id="update{{$product->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Update Product</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('products.update', $product->id)}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('UPDATE')
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="name" class="form-label">{{ __('Name') }}</label>
                                <input id="name" class="form-control" type="text" name="name" value="{{ $product->name }}">
                            </div>
                            <div class="mb-3">
                                <label for="description" class="form-label">{{ __('Description') }}</label>
                                <input id="description" class="form-control" type="text" name="description" value="{{ $product->description }}">
                            </div>
                            <div class="mb-3">
                                <label for="image" class="col-md-3 col-form-label text-sm-left fw-bold">{{_('Image')}}</label>
                                <input type="file" id="image_new" name="image_new" class="form-control">
                                <input class="form-control rounded-pill" type="text" id="image_old"
                                    name="image_old" value="{{ $product->image }}" hidden>
                            </div>
                            <div class="mb-3">
                                <label for="price" class="form-label">{{ __('Price') }}</label>
                                <input id="price" class="form-control" type="number" name="price" value="{{ $product->price }}">
                            </div>
                            <div class="mb-3">
                                <label for="category_id" class="form-label">{{ __('Category') }}</label>
                                <select id="category_id" name="category_id" class="form-select">
                                    <option value="Select" selected disabled>Select Product Category</option>
                                    @foreach ($productCategories as $productCategory)
                                        <option value={{$productCategory->id}}
                                            @if ($product->category_id == $productCategory->id) selected @endif>
                                            {{ $productCategory->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="discount" class="form-label">{{ __('Discount') }}</label>
                                <input id="discount" class="form-control" type="number" name="discount" value="{{ $product->discount }}">
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

    <div class="modal" id="addProduct" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Product</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="d-flex justify-content-between">
                        <div style="width: 48%;">
                            <div class="modal-body">
                                <!-- Basic Info Fields -->
                                <div class="mb-3">
                                    <label for="name" class="form-label">{{ __('Name') }}</label>
                                    <input id="name" class="form-control" type="text" name="name" value="{{ old('name') }}" required>
                                </div>
                                <div class="mb-3">
                                    <label for="description" class="form-label">{{ __('Description') }}</label>
                                    <input id="description" class="form-control" type="text" name="description" value="{{ old('description') }} " required>
                                </div>
                                <div class="mb-3">
                                    <label for="image" class="form-label">{{ __('Image') }}</label>
                                    <input type="file" id="image" name="image" class="form-control" required>
                                </div>
                                <div class="mb-3">
                                    <label for="category_id" class="form-label">{{ __('Category') }}</label>
                                    <select id="category_id" name="category_id" class="form-select" required>
                                        <option value="Select" selected disabled>Select Product Category</option>
                                        @foreach ($productCategories as $productCategory)
                                            <option value={{$productCategory->id}}
                                                @if (old('category_id') == $productCategory->id) selected @endif>
                                                {{ $productCategory->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="discount" class="form-label">{{ __('Discount') }}</label>
                                    <input id="discount" class="form-control" type="number" name="discount" value="{{ old('discount') ? trim(old('discount')) : '' }}" required>
                                </div>
                            </div>
                        </div>
                        <div style="width: 48%;">
                            <div class="modal-body">
                                <!-- Pricing Fields -->
                                <div class="mb-3">
                                    <label for="price" class="form-label">{{ __('Price') }}</label>
                                    <input id="price" class="form-control" type="number" name="price" value="{{ old('price') ? trim(old('price')) : '' }}" required>
                                </div>
                                <div class="mb-3">
                                    <label for="initial_stock" class="form-label">{{ __('Initial Stock') }}</label>
                                    <input id="initial_stock" class="form-control" type="number" name="initial_stock" value="{{ old('initial_stock') ? trim(old('initial_stock')) : '' }}" required>
                                </div>
                                <div class="mb-3">
                                    <label for="supplier_id" class="form-label">{{ __('Supplier') }}</label>
                                    <select id="supplier_id" name="supplier_id" class="form-select" required>
                                        <option value="" selected disabled>Select Supplier</option>
                                        @foreach ($suppliers as $supplier)
                                            <option value="{{ $supplier->id }}" {{ old('supplier_id') == $supplier->id ? 'selected' : '' }}>
                                                {{ $supplier->company_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="price_per_piece" class="form-label">{{ __('Price per Piece') }}</label>
                                    <input id="price_per_piece" class="form-control" type="number" name="price_per_piece" value="{{ old('price_per_piece') ? trim(old('price_per_piece')) : '' }}" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer d-flex justify-content-center">
                        <button type="submit" class="btn btn-primary w-50">Submit</button>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('input[type="number"]').forEach(function(input) {
                input.addEventListener('change', function() {
                    // Menghapus spasi dari nilai input
                    this.value = this.value.trim();
                });
            });
        });
        document.addEventListener('DOMContentLoaded', function () {
            @if(session('success'))
                Toastify({
                    text: "{{ session('success') }}",
                    duration: 3000,  // set duration to 0 to make the toast sticky
                    close: true,
                    gravity: "bottom",
                    position: "right",
                    backgroundColor: "#3da25c",
                }).showToast();
            @endif
        });
    </script>
@endsection
