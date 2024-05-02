<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'phone_number' => ['required', 'string', 'max:20'],
            'salary' => ['required', 'numeric'],
            'type' => ['required']
        ]);
        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make('Testing12345'),
            'avatar' => 'image/Gender-neutral-profile.png',
            'phone_number' => Crypt::encryptString($request->phone_number),
            'salary' => Crypt::encryptString($request->salary),
            'type'=> $request->type,
            'email_verified_at'=> now()
        ];

        $user = User::create($data);

        event(new Registered($user));

        return redirect()->route("employees.index");
    }
}
