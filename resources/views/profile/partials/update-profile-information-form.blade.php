<section class="ml-20" style="min-height: calc(100vh - 20px)">
        <header>
            <h2 class="text-lg font-medium text-gray-900">
                 {{ __('Profile Information') }}
             </h2>
        </header>

            <form id="profile-password-form" method="post" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="mt-6 space-y-6 flex flex-col">
                @csrf
                @method('patch')
                <div class="flex">
                    <div class="w-1/2">
                        <div class="d-block mt-10">
                            <div>
                                <img src="{{ asset('storage/' . $user->avatar) }}" id="profilePicture" class="ml-5" alt="Profile Picture" style="width: 330px; height: 330px;" />
                            </div>
                            <div class="mt-10">
                                <label for="avatar" class="bg-dark text-white hover:bg-blue-700 font-bold py-2 px-4 rounded mt-4" style="width: 400px; display: block; text-align: center; cursor: pointer;">
                                    Change Image
                                    <input type="file" id="avatar" name= "avatar"class="hidden" accept="image/*" onchange="previewImage(event)">
                                </label>
                                <x-input-error class="mt-2" :messages="$errors->get('avatar')" />
                            </div>
                        </div>
                    </div>
                    <div class="w-1/2">
                        <div>
                            <x-input-label for="name" :value="__('Name')" />
                            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)" required autofocus autocomplete="name" />
                            <x-input-error class="mt-2" :messages="$errors->get('name')" />
                        </div>

                        <div>
                            <x-input-label for="email" :value="__('Email')" />
                            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required autocomplete="username" />
                            <x-input-error class="mt-2" :messages="$errors->get('email')" />
                        </div>

                        <div>
                            <x-input-label for="phone_number" :value="__('Phone Number')" />
                            <x-text-input id="phone_number" name="phone_number" type="text" class="mt-1 block w-full" :value="old('phone_number', $user->phone_number)" required autocomplete="tel" />
                            <x-input-error class="mt-2" :messages="$errors->get('phone_number')" />
                        </div>

                        <div>
                            <x-input-label for="current_password" :value="__('Current Password')" />
                            <x-text-input id="current_password" name="current_password" type="password" class="mt-1 block w-full" autocomplete="current-password" />
                            <x-input-error :messages="$errors->get('current_password')" class="mt-2" />
                            </div>
                        <div>
                            <x-input-label for="password" :value="__('New Password')" />
                            <x-text-input id="password" name="password" type="password" class="mt-1 block w-full" autocomplete="new-password" />
                            <x-input-error :messages="$errors->get('password')" class="mt-2"/>
                            </div>

                        <div>
                            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
                            <x-text-input id="password_confirmation" name="password_confirmation" type="password" class="mt-1 block w-full" autocomplete="new-password" />
                            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2"/>
                        </div>
                    </div>
                </div>
            </form>
        <div class="flex justify-center mt-10">
            <button type="submit" form="profile-password-form" class="bg-dark text-white hover:bg-blue-700 font-bold py-2 px-4 rounded md:w-auto" style="width: 100%">
                {{ __('Save changes') }}
            </button>
        </div>
</section>


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


