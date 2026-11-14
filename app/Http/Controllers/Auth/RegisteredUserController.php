<?php

namespace App\Http\Controllers\Auth;

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
    public function index(){

    }
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
            'name' => ['required', 'string', 'min:3', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'min:3', 'confirmed', Rules\Password::defaults()],
            'role' => ['required'],
            'profile_picture' => ['nullable', 'image', 'extensions:png,jpg,jpeg'],
            'phone' => ['nullable', 'string', 'max:20']
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' =>$request->role,
            'phone' =>$request->phone
        ];

        if($request->hasFile('profile_picture')){
            $path = $request->file('profile_picture')->store('profiles','public');
            $data['profile_picture'] = 'storage/' . $path;
        }

        $user = User::create($data);

        event(new Registered($user));

        // Auth::login($user);

        return redirect(route('users.create'))->with('status','User Created Successfully.');
    }

    public function edit($id){

    }

    public function update(Request $request){

    }

    public function destroy(Request $request){

    }
}
