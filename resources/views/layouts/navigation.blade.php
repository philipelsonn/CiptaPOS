<!-- Navbar -->
<nav class="bg-white border-b border-gray-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex justify-between items-center h-16">
        <!-- Logo -->
        <div class="flex items-center">
            <a href="{{ route('dashboard') }}">
                <img src="{{ asset('storage/image/ciptaposlogo.png') }}" class="ml-5" alt="Profile Picture" style="width: 60px; height: 50px;"/>
            </a>
        </div>

        <!-- Navigation Links -->
        <div class="hidden sm:flex sm:items-center sm:ml-6">
            <a href="#" class="text-gray-500 hover:text-gray-900 cursor-pointer">Home</a>
            <a href="#" class="text-gray-500 hover:text-gray-900 cursor-pointer ml-4">Products and Transactions</a>
            <a href="#" class="text-gray-500 hover:text-gray-900 cursor-pointer ml-4">Suppliers</a>
            <a href="#" class="text-gray-500 hover:text-gray-900 cursor-pointer ml-4">Employee</a>
            <a href="#" class="text-gray-500 hover:text-gray-900 cursor-pointer ml-4">Admin</a>
        </div>

        <!-- Profile Menu -->
        <div class="flex items-center">
            <x-dropdown align="right" width="48">
                <x-slot name="trigger">
                    <button class="flex items-center text-sm font-medium text-gray-700 hover:text-gray-900 focus:outline-none focus:text-gray-900">
                        <div>{{ Auth::user()->name }}</div>

                        <div class="ml-1">
                            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </div>
                    </button>
                </x-slot>

                <x-slot name="content">
                    <x-dropdown-link :href="route('profile.edit')">
                        {{ __('Profile') }}
                    </x-dropdown-link>

                    <!-- Authentication -->
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf

                        <x-dropdown-link :href="route('logout')"
                                onclick="event.preventDefault();
                                            this.closest('form').submit();">
                            {{ __('Log Out') }}
                        </x-dropdown-link>
                    </form>
                </x-slot>
            </x-dropdown>
        </div>
    </div>

    <!-- Mobile Menu (hidden by default) -->
    <div id="mobile-menu" class="hidden sm:hidden">
        <div class="px-2 pt-2 pb-3 space-y-1">
            <a href="#" class="text-gray-500 hover:text-gray-900 cursor-pointer">Home</a>
            <a href="#" class="text-gray-500 hover:text-gray-900 cursor-pointer">Products and Transactions</a>
            <a href="#" class="text-gray-500 hover:text-gray-900 cursor-pointer">Suppliers</a>
            <a href="#" class="text-gray-500 hover:text-gray-900 cursor-pointer">Employee</a>
            <a href="#" class="text-gray-500 hover:text-gray-900 cursor-pointer">Admin</a>
        </div>
    </div>
</nav>

<script>
    document.getElementById('mobile-menu-toggle').addEventListener('click', function () {
        document.getElementById('mobile-menu').classList.toggle('hidden');
    });
</script>
