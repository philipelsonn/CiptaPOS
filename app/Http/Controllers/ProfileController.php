<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('employees.index',[
            'employees' => User::all()
        ]);
    }

    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();

        // Validasi input
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,'.$user->id,
            'phone_number' => 'required|string|max:15|regex:/^[0-9]*$/',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'current_password' => 'nullable|string|min:8',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        // Periksa apakah perlu memperbarui password
        if ($request->filled('current_password')) {
            if (!Hash::check($request->input('current_password'), $user->password)) {
                return back()->withErrors(['current_password' => 'The provided password does not match your current password.']);
            }

            if ($request->filled('password')) {
                $user->password = Hash::make($request->input('password'));
            } else {
                return back()->withErrors(['password' => 'New password field must be filled to update password.']);
            }
        }

        // Periksa apakah ada file avatar yang diunggah
        if ($request->hasFile('avatar')) {
            // Hapus avatar lama jika ada
            if ($user->avatar) {
                Storage::delete($user->avatar);
            }

            // Upload avatar baru
            $avatarPath = $request->file('avatar')->store('image', 'public');
            $user->avatar = $avatarPath;
        }

        // Perbarui informasi profil
        $user->name = $validatedData['name'];
        $user->email = $validatedData['email'];
        $user->phone_number = $validatedData['phone_number'];

        // Simpan perubahan
        $user->save();

        // Redirect kembali ke halaman profil dengan pesan sukses
        return redirect()->route('profile.edit', ['status' => 'Profile updated successfully.']);
    }

    /**
     * Delete the user's account.
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
    
        return redirect()->route("employees.index");
    }
}
