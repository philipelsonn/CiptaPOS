<main class="flex-1">
    <!-- Header -->
    <header class="bg-white border-b border-gray-200">
        <nav class="navbar navbar-expand-lg bg-body-tertiary px-5">
            <div class="container-fluid">
                <!-- Logo di pojok kiri -->
                <a class="navbar-brand" href="{{route('dashboard')}}">
                    <img src="{{ asset('storage/image/ciptaposlogoonly.png') }}" class="img-fluid" alt="CiptaPOSLogo" style="max-height: 40px;">
                </a>

                <!-- Menu Navbar di tengah -->
                @auth
                @if (Auth::user()->type == 'admin')
                    <div class="navbar-collapse justify-content-center" id="navbarSupportedContent">
                        <ul class="navbar-nav">
                            <li class="nav-item">
                                <a class="nav-link" aria-current="page" href="{{ route('dashboard') }}">Home</a>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    Products & Transactions
                                </a>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="{{ route('products.index') }}">Products</a></li>
                                    <li><a class="dropdown-item" href="{{ route('product-categories.index') }}">Product Categories</a></li>
                                    <li><a class="dropdown-item" href="{{ route('stockout.index') }}">Stockouts</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li><a class="dropdown-item" href="{{ route('payment-methods.index') }}">Payment Methods</a></li>
                                </ul>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    Suppliers
                                </a>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="{{ route('suppliers.index') }}">Suppliers</a></li>
                                    <li><a class="dropdown-item" href="{{ route('supplier-transactions.index') }}">Supplier Transactions</a></li>
                                    <li><a class="dropdown-item" href="{{ route('supplier-pricings.index') }}">Supplier Pricings</a></li>
                                </ul>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" aria-current="page" href="{{ route('employees.index') }}">Employees</a>
                            </li>
                        </ul>
                    </div>
                @endif
                @endauth

                <!-- Profil di pojok kanan -->
                <div class="text-right">
                    <ul class="navbar-nav">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                {{ Auth::user()->name }}</a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="{{route('profile.edit')}}">Profile</a></li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                        onclick="event.preventDefault(); localStorage.removeItem('cart'); document.getElementById('logout-form').submit();">
                                        Logout
                                    </a>
                                </li>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>
</main>
