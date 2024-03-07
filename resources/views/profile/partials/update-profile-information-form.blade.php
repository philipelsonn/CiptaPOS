<section class="ml-20" style="min-height: calc(100vh - 20px)"">
    <div class="flex">
        <div class="w-1/2">
            <header>
                <h2 class="text-lg font-medium text-gray-900">
                    {{ __('Profile Information') }}
                </h2>
            </header>

            <div class="d-block mt-10">
                <div>
                    <img src="{{ asset('storage/' . $user->avatar) }}" class="ml-5" alt="Profile Picture" style="width: 330px; height: 330px;"/>
                </div>
                <div>
                    <label for="imageInput" class="bg-dark text-white hover:bg-blue-700 font-bold py-2 px-4 rounded mt-4" style="width: 400px; display: block; text-align: center; cursor: pointer;">
                        Change Image
                        <input type="file" id="imageInput" class="hidden" accept="image/*" onchange="previewImage(event)">
                    </label>
                </div>
                <div class="md:col-span-2">
                    <button type="button" class="bg-dark text-white hover:bg-blue-700 font-bold py-2 px-4 rounded mt-4" style="width: 400px">
                        Preview
                    </button>
                </div>
            </div>

        </div>

        <div class="w-1/2 ml-30">
            <!-- Form profile dan password -->
            <form id="profile-form" class="mt-6 space-y-6">
                @csrf
                @method('patch')

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
            </form>

            <form id="password-form" method="post" action="{{ route('password.update') }}" class="mt-6 space-y-6">
                @csrf
                @method('put')

                <div>
                    <x-input-label for="current_password" :value="__('Current Password')" />
                    <x-text-input id="current_password" name="current_password" type="password" class="mt-1 block w-full" autocomplete="current-password" />
                    <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="password" :value="__('New Password')" />
                    <x-text-input id="password" name="password" type="password" class="mt-1 block w-full" autocomplete="new-password" />
                    <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
                    <x-text-input id="password_confirmation" name="password_confirmation" type="password" class="mt-1 block w-full" autocomplete="new-password" />
                    <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
                </div>
            </form>
        </div>
    </div>
    <div class="flex mt-10">
        <button type="button" onclick="submitForms()" class="bg-dark text-white hover:bg-blue-700 font-bold py-2 px-4 rounded md:w-auto" style="width: 100%">
            {{ __('Save changes') }}
        </button>
    </div>
</section>

<script>
function submitForms() {
    var profileData = new FormData(document.getElementById('profile-form'));
    var passwordData = new FormData(document.getElementById('password-form'));
    var imageData = new FormData();
    var input = document.getElementById('imageInput');

    if (input.files && input.files[0]) {
        imageData.append('avatar', input.files[0]);
    }
    for (var pair of imageData.entries()) {
        profileData.append(pair[0], pair[1]);
    }

    Promise.all([
        fetch("{{ route('profile.update') }}", {
            method: 'POST',
            body: profileData
        }),
        fetch("{{ route('password.update') }}", {
            method: 'POST',
            body: passwordData
        })
    ]).then(responses => {
        if (responses.every(response => response.ok)) {
            console.log('Profile, password, and avatar updated successfully');
            sessionStorage.setItem('status', 'profile-updated');
            showStatusMessage();
        } else {
            console.error('Failed to update profile, password, and/or avatar');
        }
    }).catch(error => {
        console.error('Error updating profile, password, and/or avatar:', error);
    });
}


function showStatusMessage() {
    var status = sessionStorage.getItem('status');
    if (status === 'profile-updated') {

        Toastify({
            text: 'Profile changes saved.',
            duration: 3000,  // Durasi toast message
            gravity: 'bottom',  // Posisi toast message
            position: 'right',  // Posisi toast message
            backgroundColor: 'linear-gradient(to right, #00b09b, #96c93d)',  // Warna latar belakang toast message
            style: {
                'max-width': '200px'  // Lebar maksimum toast message
            }
        }).showToast();

        // Hilangkan status dari sessionStorage
        sessionStorage.removeItem('status');

        setTimeout(() => {
            location.reload();
        }, 3000);
    }
}
</script>

<script>
    function previewImage(event) {
        var input = event.target;
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                var preview = document.getElementById('imagePreview');
                preview.src = e.target.result;
            };
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>


