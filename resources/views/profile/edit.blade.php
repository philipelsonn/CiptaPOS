<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="justify-center">
        <div class="p-4 sm:p-8 bg-gray shadow sm:rounded-lg w-full sm:w-auto">
             @include('profile.partials.update-profile-information-form')
        </div>

        {{-- <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg w-full sm:w-auto mx-2">
            <div class="max-w-xl">
                @include('profile.partials.update-password-form')
            </div>
        </div> --}}
    </div>
</x-app-layout>
