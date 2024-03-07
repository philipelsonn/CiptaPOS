<x-app-layout>
    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="d-flex justify-content-between align-items-center" style="background-color: #0c0c0c; padding: 10px;">
                        <div class="title" style="margin-left: 20px">
                            <h2 class="card-title" style="margin-bottom: 0; color: white">{{ __('Add New Employee') }}</h2>
                        </div>
                        <div style="margin-right: 20px">
                            <a href="{{ route('employee') }}" class="btn" style="background-color: rgb(243, 35, 35); color:white">{{ __('Return') }}</a>
                        </div>
                    </div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('register') }}">
                            @csrf

                            <!-- Name -->
                            <div class="mb-3">
                                <x-input-label for="name" :value="__('Name')" />
                                <x-text-input id="name" class="form-control" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                                <x-input-error :messages="$errors->get('name')" class="mt-2" />
                            </div>

                            <!-- Email Address -->
                            <div class="mb-3">
                                <x-input-label for="email" :value="__('Email')" />
                                <x-text-input id="email" class="form-control" type="email" name="email" :value="old('email')" required autocomplete="username" />
                                <x-input-error :messages="$errors->get('email')" class="mt-2" />
                            </div>

                            <!-- Phone Number -->
                            <div class="mb-3">
                                <x-input-label for="phone_number" :value="__('Phone Number')" />
                                <x-text-input id="phone_number" class="form-control" type="text" name="phone_number" :value="old('phone_number')" required autocomplete="tel" />
                                <x-input-error :messages="$errors->get('phone_number')" class="mt-2" />
                            </div>

                            <!-- Type -->
                            <div class="mb-3">
                                <x-input-label for="type" :value="__('Type')" />
                                <select id="type" name="type" class="form-select" aria-label="Select type">
                                    <option value="employee" {{ old('type', 'employee') === 'employee' ? 'selected' : '' }}>employee</option>
                                    <option value="admin" {{ old('type') === 'admin' ? 'selected' : '' }}>Admin</option>
                                </select>
                                <x-input-error :messages="$errors->get('type')" class="mt-2" />
                            </div>

                            <!-- Salary -->
                            <div class="mb-3">
                                <x-input-label for="salary" :value="__('Salary')" />
                                <x-text-input id="salary" class="form-control" type="number" name="salary" :value="old('salary')" required autocomplete="salary" />
                                <x-input-error :messages="$errors->get('salary')" class="mt-2" />
                            </div>

                            <div class="flex justify-center">
                                <x-primary-button>
                                    {{ __('Register') }}
                                </x-primary-button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
