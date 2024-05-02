<section class="ml-20" style="min-height: calc(100vh - 20px)">
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            Profile Information
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
                            <input type="file" id="avatar" name="avatar" class="hidden" accept="image/*" onchange="previewImage(event)">
                        </label>
                        @error('avatar')
                            <span class="text-red-600">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="w-1/2">
                <div>
                    <label for="name" class="block font-medium text-gray-700">Name</label>
                    <input id="name" name="name" type="text" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50" value="{{ old('name', $user->name) }}" required autofocus autocomplete="name" />
                    @error('name')
                        <span class="text-red-600">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label for="email" class="block font-medium text-gray-700">Email</label>
                    <input id="email" name="email" type="email" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50" value="{{ old('email', $user->email) }}" required autocomplete="username" />
                    @error('email')
                        <span class="text-red-600">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label for="phone_number" class="block font-medium text-gray-700">Phone Number</label>
                    <input id="phone_number" name="phone_number" type="text" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50" value="{{ old('phone_number', $user->phone_number) }}" required autocomplete="tel" />
                    @error('phone_number')
                        <span class="text-red-600">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label for="current_password" class="block font-medium text-gray-700">Current Password</label>
                    <input id="current_password" name="current_password" type="password" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50" autocomplete="current-password" />
                    @error('current_password')
                        <span class="text-red-600">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label for="password" class="block font-medium text-gray-700">New Password</label>
                    <input id="password" name="password" type="password" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50" autocomplete="new-password" />
                    @error('password')
                        <span class="text-red-600">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label for="password_confirmation" class="block font-medium text-gray-700">Confirm Password</label>
                    <input id="password_confirmation" name="password_confirmation" type="password" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50" autocomplete="new-password" />
                    @error('password_confirmation')
                        <span class="text-red-600">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>
        <div class="flex justify-center mt-10">
            <button type="submit" form="profile-password-form" class="bg-dark text-white hover:bg-blue-700 font-bold py-2 px-4 rounded md:w-auto" style="width: 100%">
                Save changes
            </button>
        </div>
    </form>
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
