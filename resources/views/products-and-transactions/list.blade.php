@extends('layouts.admin')

@section('title', 'CiptaPOS | Manage Supplier Transactions')

@section('content')
    @include('layouts.navbar')
    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; padding: 20px;">
        <!-- Grid Product -->
        <div style="flex: 55; padding-right: 10px;">
            <div>
                <form id="search-form" action="{{ url('product/search') }}" method="GET" class="d-flex">
                    <div class="input-group flex-grow-1 mb-3" style="position: relative;">
                        <input type="text" id="search-bar" name="q" autocomplete="off" class="form-control" placeholder="Search products">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-search"></i>
                        </button>
                        <div id="search-results" style="position: absolute; background-color: white; border: 1px solid #ccc; max-height: 200px; overflow-y: auto; display: none; width: 100%; top: 100%; left: 0;"></div>
                    </div>
                </form>
                <form id="category-form" action="{{ route('products.by_category') }}" method="GET">
                    <div class="mb-4">
                        <select id="category-dropdown" name="category_id" class="form-select">
                            @if ($selectedCategory === 'All Categories')
                                <option value="{{ $selectedCategory }}" selected>{{ $selectedCategory }}</option>
                            @else
                                <option value="{{ $selectedCategory }}" selected>{{ $selectedCategory }}</option>
                                <option value="">All Categories</option>
                            @endif
                            @foreach($productCategories as $category)
                                @if($selectedCategory != $category->name)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                </form>
            </div>
            <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 1rem;">
                @if($products->isEmpty())
                    <p style="grid-column: 1 / -1; text-align: center;">No product of category {{$selectedCategory}} is available</p>
                @else
                    @foreach($products as $product)
                        @if (request('q') === null || request('q') === '' || strpos(strtolower($product->name), strtolower(request('q'))) !== false)
                            <div class="product" data-product-id="{{ $product->id }}" style="cursor: pointer; background-color: #fff; padding: 1rem; border-radius: 0.5rem; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" style="width: 100%; height: 100px; object-fit: contain; border-radius: 0.25rem;">
                                <h3 style="margin-top: 0.5rem; margin-bottom: 0.25rem; font-size: 1.25rem;">{{ $product->name }}</h3>
                                <p id="product-price-discounted" style="margin-bottom: 0; font-size: 1rem;">
                                    @if ($product->discount > 0)
                                        <del style="color: #6c757d;">Rp {{ $product->price }}</del><br>
                                        <span style="font-weight: bold;">Rp {{ $product->price * (1 - ($product->discount / 100)) }}</span>
                                    @else
                                        <span style="font-weight: bold;">Rp {{ $product->price }} </span>
                                    @endif
                                </p>
                                <p class="stock" style="margin-bottom: 0; font-size: 1rem; font-weight: bold;">Stock: {{ $product->stock }}</p>
                                <button class="add-to-cart" style="background-color: #3490dc; color: white; border: none; padding: 0.5rem 1rem; border-radius: 0.25rem; cursor: pointer; margin-top: 0.5rem; width: 100%;">Add to cart</button>
                            </div>
                        @endif
                    @endforeach
                @endif
            </div>
            <div class="mt-5 d-flex justify-content-center">
                {{ $products->links() }}
            </div>
        </div>

        <!-- List Product -->
        <div style="background-color: white; display: flex; flex-direction: column; height: 850px; overflow-y: auto;">
            <div class="mt-4 mb-4 ml-3" >
                <h2 class="fw-bold">Transaction</h2>
            </div>
            <div style="display: flex; flex-direction: column; flex-grow: 1; overflow-y: auto;">
                <table class="table" style="border-collapse: collapse; width: 100%; border: 1px solid #ddd;">
                    <thead>
                        <tr>
                            <th style="border: 1px solid gray;">Nama Barang</th>
                            <th style="border: 1px solid gray;">Quantity</th>
                            <th style="border: 1px solid gray;">Total Harga</th>
                            <th style="border: 1px solid gray; padding-left: 35px;">Action</th>
                        </tr>
                    </thead>
                    <tbody id="selected-products">
                        <!-- Isi tabel -->
                    </tbody>
                </table>
            </div>
            <div style="margin-left: 20px; width: fit-content;">
                <label for="payment-method" style="margin-right: 10px;">Pilih Metode Pembayaran:</label>
                <select name="payment-method" id="payment-method">
                    @foreach($paymentMethods as $paymentMethod)
                        <option value="{{ $paymentMethod->id }}">{{ $paymentMethod->name }}</option>
                    @endforeach
                </select>
            </div>
            <div style="display: flex; justify-content: flex-end; margin-top: 1rem;">
                <button id="clear-all-button" style="background-color: #dc3545; color: white; border: none; padding: 0.5rem 1rem; border-radius: 0.25rem; cursor: pointer; margin-right: 10px;">Clear All</button>
                <button id="checkout-button" style="background-color: #28a745; color: white; border: none; padding: 0.5rem 1rem; border-radius: 0.25rem; cursor: pointer;">Checkout</button>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('category-dropdown').addEventListener('change', function() {
                document.getElementById('category-form').submit();
            });
        });
        document.addEventListener('DOMContentLoaded', function() {
        const products = document.querySelectorAll('.product');
        const selectedProducts = document.getElementById('selected-products');
        let cart = JSON.parse(localStorage.getItem('cart')) || [];

        products.forEach(product => {
            const addToCartButton = product.querySelector('.add-to-cart');
            const productId = product.getAttribute('data-product-id');
            const stock = parseInt(product.querySelector('.stock').textContent.replace('Stock: ', ''));

            addToCartButton.addEventListener('click', function() {
                const existingProductIndex = cart.findIndex(item => item.id === productId);

                if (existingProductIndex !== -1) {
                // Product already in cart, increment quantity if below stock
                    if (cart[existingProductIndex].quantity < cart[existingProductIndex].stock) {
                        cart[existingProductIndex].quantity++;
                    } else {
                    // Show alert if trying to add more than stock
                        Toastify({
                            text: 'Cannot add more. Stock limit reached.',
                            backgroundColor: 'red',
                            position: 'bottom',
                            gravity: 'bottom',
                            close: true
                        }).showToast();
                    }
                } else {
                // Product not in cart, add to cart with quantity default to 1
                    const productName = product.querySelector('h3').textContent;
                    const productPriceElement = product.querySelector('#product-price-discounted');
                    const priceText = productPriceElement.innerText.trim();

                    let productPrice;
                    if (/^Rp \d+\nRp \d+$/.test(priceText)) {
                         // Format: Rp 15000\nRp 14250
                        productPrice = parseFloat(priceText.split('\n')[1].replace('Rp ', ''));
                    } else if (/^Rp \d+$/.test(priceText)) {
                        // Format: Rp 10000
                        productPrice = parseFloat(priceText.replace('Rp ', ''));
                    }

                    cart.push({ id: productId, name: productName, price: productPrice, quantity: 1, stock: stock });
                }

                renderCart();
                localStorage.setItem('cart', JSON.stringify(cart));
            });
        });
        document.getElementById('clear-all-button').addEventListener('click', function() {
            cart = [];
            renderCart();
            localStorage.setItem('cart', JSON.stringify(cart));
        });

        function renderCart() {
            selectedProducts.innerHTML = '';
            if (cart.length === 0) {
            const tr = document.createElement('tr');
            const tdEmpty = document.createElement('td');
            tdEmpty.textContent = 'No product in cart';
            tdEmpty.colSpan = '4'; // Set the colspan to cover all columns
            tdEmpty.style.textAlign = 'center';
            tr.appendChild(tdEmpty);
            selectedProducts.appendChild(tr);
            document.getElementById('checkout-button').disabled = true; // Disable checkout button
            return; // Exit the function early if cart is empty
        }
        document.getElementById('checkout-button').disabled = false; // Enable checkout button
            cart.forEach(item => {
                const tr = document.createElement('tr');
                tr.style.borderBottom = '1px solid gray';
                const tdName = document.createElement('td');
                tdName.textContent = item.name;
                tdName.style.borderRight = '1px solid gray';

                const tdQuantity = document.createElement('td');
                const inputQuantity = document.createElement('input');
                tdQuantity.style.borderRight = '1px solid gray';
                inputQuantity.type = 'number';
                inputQuantity.value = item.quantity;
                inputQuantity.min = '1';
                inputQuantity.max = item.stock; // Limit input to stock
                inputQuantity.style.width = '60px';
                inputQuantity.addEventListener('change', function() {
                    const newValue = parseInt(inputQuantity.value);
                    if (newValue > item.stock) {
                        // If input value exceeds stock, set value back to stock
                        inputQuantity.value = item.stock;
                        item.quantity = item.stock;
                        Toastify({
                            text: 'Cannot add more. Stock limit reached.',
                            backgroundColor: 'red',
                            position: 'bottom',
                            gravity: 'bottom',
                            close: true
                        }).showToast();
                    } else {
                    // If input value is valid, set item quantity and update cart
                        item.quantity = newValue;
                        renderCart();
                        localStorage.setItem('cart', JSON.stringify(cart));
                    }
                });
                tdQuantity.appendChild(inputQuantity);

                const tdTotal = document.createElement('td');
                tdTotal.textContent = `Rp ${item.price * item.quantity}`;
                tdTotal.style.borderRight = '1px solid gray';


                const tdAction = document.createElement('td');
                const cancelButton = document.createElement('button');
                cancelButton.innerHTML = '<i class="fas fa-trash"></i>'; // Gunakan class ikon dari Font Awesome
                cancelButton.style.backgroundColor = 'transparent'; // Hapus warna background
                cancelButton.style.border = 'none';
                cancelButton.style.cursor = 'pointer';
                cancelButton.style.marginLeft = '1rem'; // Spasi dari teks
                cancelButton.querySelector('i').style.color = 'red'; // Mengatur warna ikon menjadi merah
                cancelButton.addEventListener('click', function() {
                cart = cart.filter(cartItem => cartItem.id !== item.id);
                renderCart();
                localStorage.setItem('cart', JSON.stringify(cart));
                });

                tdAction.appendChild(cancelButton);

                tr.appendChild(tdName);
                tr.appendChild(tdQuantity);
                tr.appendChild(tdTotal);
                tr.appendChild(tdAction);

                selectedProducts.appendChild(tr);
            });
        }

        // Render cart on page load
        renderCart();
        document.getElementById('checkout-button').addEventListener('click', function() {
            const paymentMethodId = document.getElementById('payment-method').value;

            // Send shopping cart data and payment method ID to route /transaction
            fetch('{{ route("transactions.store") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    cart: cart,
                    payment_method_id: paymentMethodId
                })
            })
            .then(response => {
                if (response.ok) {
                    return response.json();
                }
                throw new Error('Network response was not ok.');
            })
            .then(data => {
                console.log(data);
                localStorage.removeItem('cart');
                window.location.href = '/transactions';
            })
            .catch(error => {
                console.error('There has been a problem with your fetch operation:', error);
            });
        });

        const searchBar = document.getElementById('search-bar');
        const searchResults = document.getElementById('search-results');

        searchBar.addEventListener('input', function() {
        const query = searchBar.value.trim();

        if (query === '') {
            searchResults.style.display = 'none';
            return;
        }

        fetch(`/search?q=${query}`)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                // Render search results
                renderSearchResults(data);
            })
            .catch(error => {
                console.error('There has been a problem with your fetch operation:', error);
            });
        });

        function renderSearchResults(results) {
        searchResults.innerHTML = '';

        if (results.length === 0) {
            searchResults.style.display = 'none';
            return;
        }

        results.forEach(result => {
            const div = document.createElement('div');
            div.textContent = result.name;
            div.style.padding = '5px';
            div.style.cursor = 'pointer';
                div.addEventListener('click', function() {
                    // Set selected search result to search bar
                    searchBar.value = result.name;
                    searchResults.style.display = 'none';
                });
                searchResults.appendChild(div);
            });
            searchResults.style.display = 'block';
        }

            // Close search results when clicking outside
            document.addEventListener('click', function(event) {
                if (!searchResults.contains(event.target) && event.target !== searchBar) {
                    searchResults.style.display = 'none';
                }
            });
        });
    </script>
@endsection
