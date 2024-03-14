@extends('layouts.admin')

@section('title', 'CiptaPOS | Manage Stockouts Entry')

@section('content')

@include('layouts.navbar')

    <div class="container my-auto">
        <div class="card p-4 bg-light mt-3 mb-3">
            <div class="d-flex justify-content-between mt-2 mb-4">
                <h2 class="fw-bold">Stockout Data</h2>
                <a class="btn btn-lg btn-success text-white fw-bold" data-bs-toggle="modal" data-bs-target="#addStockout">Add Stockout Entry</a>
            </div>
            <div class="table-responsive">
                <table id="myTable" class="table table-striped bg-light">
                    <thead>
                        <tr>
                            <th class="text-center">ID</th>
                            <th class="text-center">Description</th>
                            <th class="text-center">Quantity</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php($i = 1)
                        @foreach ($stockouts as $stockout)
                            <tr>
                                <td class="align-middle text-center fw-bold">{{ $stockout->id }}</td>
                                <td class="align-middle text-center">{{ $stockout->description }}</td>
                                <td class="align-middle text-center">{{ $stockout->quantity }}</td>
                                <td class="align-middle text-center">
                                    <div class="d-flex justify-content-center align-middle"> <!-- Tambah align-middle di sini -->
                                        <form action="{{ route('stockout.destroy', $stockout->id) }}" method="POST">
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
    <div class="modal" id="addStockout" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" style="max-width: 50%;">
            <div class="modal-content mx-auto">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add stockout entry</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('stockout.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body mx-3">
                        <div class="search">
                            <label for="product_name" class="form-label">Product Name</label>
                            <input id="product_name" class="form-control form-control-sm" type="text" placeholder="Search Product" required>
                        </div>
                        <div class="position-relative">
                            <div id="autocomplete-results" class="position-absolute bg-white border shadow-sm rounded-3 mt-1" style="display: none; top: 100%; width: 100%;"></div>
                        </div>
                        <input type="hidden" name="product_id" id="product_id">
                        <div class="mt-3">
                            <label for="quantity" class="form-label">Quantity</label>
                            <input id="quantity"name= "quantity" class="form-control form-control-sm" type="number" placeholder="Quantity" required>
                        </div>
                        <div class="mt-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea id="description" name= "description" class="form-control form-control-sm" placeholder="Description" required></textarea>
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
    var availableProducts = @json($products);
    var searchInput = document.getElementById('product_name');
    var autocompleteResults = document.getElementById('autocomplete-results');
    var productIdInput = document.getElementById('product_id'); // tambahkan ini

    searchInput.addEventListener('input', function() {
        var value = this.value.toLowerCase();
        var suggestions = availableProducts.filter(function(product) {
            return product.name.toLowerCase().includes(value);
        });

        autocompleteResults.innerHTML = '';
        suggestions.forEach(function(product) {
            var div = document.createElement('div');
            div.textContent = product.name;
            div.classList.add('p-2', 'cursor-pointer');
            div.addEventListener('click', function() {
                searchInput.value = product.name;
                productIdInput.value = product.id; // simpan ID produk ke input tersembunyi
                autocompleteResults.style.display = 'none';
            });
            autocompleteResults.appendChild(div);
        });

        if (suggestions.length > 0) {
            autocompleteResults.style.display = 'block';
        } else {
            autocompleteResults.style.display = 'none';
        }
    });

    document.addEventListener('click', function(event) {
        if (!autocompleteResults.contains(event.target) && event.target !== searchInput) {
            autocompleteResults.style.display = 'none';
        }
    });
});
</script>
@endsection
