<x-app-layout>
    <div class="d-flex">
        <!-- Grid Product -->
        <div style="flex: 1; padding-right: 10px;">
            <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 1rem;">
                @foreach($products as $product)
                    <div class="product" data-product-id="{{ $product->id }}" style="cursor: pointer; background-color: #fff; padding: 1rem; border-radius: 0.5rem; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" style="width: 100%; height: 100px; object-fit: contain; border-radius: 0.25rem;">
                        <h3 style="margin-top: 0.5rem; margin-bottom: 0.25rem; font-size: 1.25rem;">{{ $product->name }}</h3>
                        <p style="margin-bottom: 0.5rem; font-size: 1rem;">{{ $product->description }}</p>
                        <p id="product-price" style="margin-bottom: 0; font-size: 1rem; font-weight: bold;">Price: Rp {{ $product->price }}</p>
                        <p id="product-price-discounted" style="margin-bottom: 0; font-size: 1rem; font-weight: bold;">Price: Rp {{ $product->price * (1 - ($product->discount / 100)) }}</p>
                        <p class="stock" style="margin-bottom: 0; font-size: 1rem; font-weight: bold;">Stock: {{ $product->stock }}</p>
                        <button class="add-to-cart" style="background-color: #3490dc; color: white; border: none; padding: 0.5rem 1rem; border-radius: 0.25rem; cursor: pointer; margin-top: 0.5rem;">Add</button>
                    </div>
                @endforeach
            </div>
            <div class="mt-4">
                {{ $products->links() }}
            </div>
        </div>
        <!-- List Product -->
        <div style="flex: 1;background-color: wheat">
            <table class="table">
                <thead>
                    <tr>
                        <th>Nama Barang</th>
                        <th>Quantity</th>
                        <th>Total Harga</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody id="selected-products"></tbody>
            </table>
        <div class="ml-5">
            <label for="payment-method">Pilih Metode Pembayaran:</label>
            <select name="payment-method" id="payment-method">
                @foreach($paymentMethods as $paymentMethod)
                    <option value="{{ $paymentMethod->id }}">{{ $paymentMethod->name }}</option>
                @endforeach
            </select>
            <button id="checkout-button" style="background-color: #28a745; color: white; border: none; padding: 0.5rem 1rem; border-radius: 0.25rem; cursor: pointer; margin-top: 1rem;">Checkout</button>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
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
                    alert('Cannot add more. Stock limit reached.');
                }
            } else {
                // Product not in cart, add to cart with quantity default to 1
                const productName = product.querySelector('h3').textContent;
                const productPrice = parseFloat(product.querySelector('#product-price-discounted').innerText.replace('Price: Rp ', ''));
                cart.push({ id: productId, name: productName, price: productPrice, quantity: 1, stock: stock });
            }

            renderCart();
            localStorage.setItem('cart', JSON.stringify(cart));
        });
    });

    function renderCart() {
        selectedProducts.innerHTML = '';

        cart.forEach(item => {
            const tr = document.createElement('tr');
            const tdName = document.createElement('td');
            tdName.textContent = item.name;

            const tdQuantity = document.createElement('td');
            const inputQuantity = document.createElement('input');
            inputQuantity.type = 'number';
            inputQuantity.value = item.quantity;
            inputQuantity.min = '1';
            inputQuantity.max = item.stock; // Limit input to stock
            inputQuantity.style.width = '60px';
            inputQuantity.style.marginRight = '5px';
            inputQuantity.addEventListener('change', function() {
                const newValue = parseInt(inputQuantity.value);
                if (newValue > item.stock) {
                    // Jika nilai yang dimasukkan melebihi stok, atur nilai kembali ke stok
                    inputQuantity.value = item.stock;
                    item.quantity = item.stock;
                    alert('Cannot add more. Stock limit reached.');
                } else {
                    // Jika nilai yang dimasukkan valid, atur kuantitas item dan update keranjang
                    item.quantity = newValue;
                    renderCart();
                    localStorage.setItem('cart', JSON.stringify(cart));
                }
            });
            tdQuantity.appendChild(inputQuantity);

            const tdTotal = document.createElement('td');
            tdTotal.textContent = `Rp ${item.price * item.quantity}`;

            const tdAction = document.createElement('td');
            const cancelButton = document.createElement('button');
            cancelButton.textContent = 'Cancel';
            cancelButton.style.backgroundColor = '#dc3545'; // Merah
            cancelButton.style.color = 'white';
            cancelButton.style.border = 'none';
            cancelButton.style.padding = '0.5rem 1rem';
            cancelButton.style.borderRadius = '0.25rem';
            cancelButton.style.cursor = 'pointer';
            cancelButton.style.marginLeft = '1rem'; // Jarak dari teks
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

        // Kirim data keranjang belanja dan ID metode pembayaran ke route /transaction
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
});

    </script>
</x-app-layout>
