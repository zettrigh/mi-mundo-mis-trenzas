<?php

namespace App\Http\Controllers\Auth;

use App\Enums\UserRole;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
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
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                'regex:/^[\pL\s\-\'\.]+$/u',
            ],
            'cedula' => [
                'required',
                'string',
                'min:6',
                'max:12',
                'regex:/^[0-9]+$/',
                'unique:'.User::class,
            ],
            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                'regex:/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/',
                'unique:'.User::class,
            ],
            'phone' => [
                'nullable',
                'string',
                'max:30',
                'regex:/^\+?[0-9\s\-()]+$/',
            ],
            'address' => [
                'nullable',
                'string',
                'max:500',
                'regex:/^[\pL\pN\s\.,#\-\/º°]+$/u',
            ],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ], [
            'name.regex' => 'El nombre completo solo debe contener letras, espacios y guiones.',
            'cedula.regex' => 'La cédula de identidad solo debe contener números.',
            'cedula.min' => 'La cédula de identidad debe tener al menos 6 dígitos.',
            'cedula.max' => 'La cédula de identidad no debe exceder los 12 dígitos.',
            'email.regex' => 'El correo electrónico debe tener un formato válido.',
            'phone.regex' => 'El teléfono solo debe contener números y signos válidos (+, -, espacios o paréntesis).',
            'address.regex' => 'La dirección solo debe contener letras, números y caracteres habituales de dirección (., #, -, /, º, °).',
        ]);

        $user = User::create([
            'name' => $request->name,
            'cedula' => $request->cedula,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'role' => UserRole::Client,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }
}
