@extends('layouts.admin')

@section('title', 'CiptaPOS | Manage Payment Methods')

@section('content')

@include('layouts.navbar')

<div style="padding-top: 24px; padding-bottom: 24px;">
    <div style="max-width: 1000px; margin: 0 auto;">
        <div style="background-color: #fff; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
            <div style="display: flex;">
                <div style="flex: 45;">
                    <h2 style="padding-left: 30px; margin-bottom:24px; margin-top:24px;font-size: 1.5rem; font-weight: 600; color: #333;">{{ __('Profile') }}</h2>
                    <div style="display: flex; flex-direction: column; justify-content: center; align-items: center;">
                        <div style="margin-bottom: 12px;">
                            <img src="{{ asset('storage/' . $user->avatar) }}" id="profilePicture" alt="Profile Picture" style="width: 250px; height: 250px; border-radius: 50%; object-fit: cover;">
                        </div>
                        <label for="avatar" style="display: block; margin-top: 30px; background-color: #333; color: #fff; font-weight: 600; padding: 8px 16px; border-radius: 4px; cursor: pointer; text-align: center; margin-bottom: 16px; width: 200px; position: relative; overflow: hidden;">
                            Change Image
                            <input type="file" id="avatar" name="avatar" class="hidden" accept="image/*" onchange="previewImage(event)" style="position: absolute; left: -9999px;">
                        </label>
                        @error('avatar')
                            <span style="color: red;">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div style="flex: 55;">
                    <div style="padding: 12px; margin-top: 40px;">
                        <form id="profile-password-form" method="post" action="{{ route('profile.update') }}" enctype="multipart/form-data" style="margin-top: 24px; margin-bottom: 24px;">
                            @csrf
                            @method('patch')

                            <div style="margin-bottom: 24px;">
                                <label for="name" style="display: block; font-weight: 600; color: #333;">Name</label>
                                <input id="name" name="name" type="text" value="{{ old('name', $user->name) }}" required autofocus autocomplete="name" style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;">
                                @error('name')
                                    <span style="color: red;">{{ $message }}</span>
                                @enderror
                            </div>

                            <div style="margin-bottom: 24px;">
                                <label for="email" style="display: block; font-weight: 600; color: #333;">Email</label>
                                <input id="email" name="email" type="email" value="{{ old('email', $user->email) }}" required autocomplete="username" style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;">
                                @error('email')
                                    <span style="color: red;">{{ $message }}</span>
                                @enderror
                            </div>

                            <div style="margin-bottom: 24px;">
                                <label for="phone_number" style="display: block; font-weight: 600; color: #333;">Phone Number</label>
                                <input id="phone_number" name="phone_number" type="text" value="{{ old('phone_number', $user->phone_number) }}" required autocomplete="tel" style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;">
                                @error('phone_number')
                                    <span style="color: red;">{{ $message }}</span>
                                @enderror
                            </div>

                            <div style="margin-bottom: 24px;">
                                <label for="current_password" style="display: block; font-weight: 600; color: #333;">Current Password</label>
                                <input id="current_password" name="current_password" type="password" autocomplete="current-password" style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;">
                                @error('current_password')
                                    <span style="color: red;">{{ $message }}</span>
                                @enderror
                            </div>

                            <div style="margin-bottom: 24px;">
                                <label for="password" style="display: block; font-weight: 600; color: #333;">New Password</label>
                                <input id="password" name="password" type="password" autocomplete="new-password" style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;">
                                @error('password')
                                    <span style="color: red;">{{ $message }}</span>
                                @enderror
                            </div>

                            <div style="margin-bottom: 24px;">
                                <label for="password_confirmation" style="display: block; font-weight: 600; color: #333;">Confirm Password</label>
                                <input id="password_confirmation" name="password_confirmation" type="password" autocomplete="new-password" style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;">
                                @error('password_confirmation')
                                    <span style="color: red;">{{ $message }}</span>
                                @enderror
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div style="display: flex; justify-content: center; padding-bottom: 24px; align-items: center;">
                <button type="submit" form="profile-password-form" style="background-color: #333; color: #fff; font-weight: 600; padding: 8px 16px; border: none; border-radius: 4px; cursor: pointer; width: 650px;">
                    Save changes
                </button>
            </div>
        </div>
    </div>
</div>
<script>
document.addEventListener('DOMContentLoaded', function() {
    var form = document.getElementById('profile-password-form');
    var button = document.querySelector('[type="submit"]');

    button.addEventListener('click', function(event) {
        event.preventDefault(); // Mencegah pengiriman formulir langsung
        form.submit(); // Mengirim formulir
    });
});
document.addEventListener('DOMContentLoaded', function() {
    const urlParams = new URLSearchParams(window.location.search);
    const status = urlParams.get('status');
    console.log(status);

    if (status === 'Profile updated successfully.') {
        Toastify({
            text: 'Profile updated successfully.',
            duration: 3000,
            gravity: 'bottom',
            position: 'right',
            backgroundColor: 'linear-gradient(to right, #00b09b, #96c93d)',
            style: {
                'max-width': '200px'
            }
        }).showToast();
        history.replaceState({}, document.title, window.location.pathname);
    }
});
</script>
<script>
function previewImage(event) {
    var input = event.target;

    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function(e) {
            var preview = document.getElementById('profilePicture');
            preview.src = e.target.result;
        };

        reader.readAsDataURL(input.files[0]);
    }
}
</script>

@endsection
