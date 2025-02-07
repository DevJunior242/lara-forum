<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

class UserController extends Controller
{
    public function register()
    {
        return view('user.register');
    }

    public function registerPost(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users,email',
                'password' => 'required|min:8|confirmed',
                'country' => 'required|string|max:255',
                'city' => 'required|string|max:255',
                'image' => 'nullable|mimes:jpeg,png,jpg,gif,svg|max:1024'
            ]
        );
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)
                ->withInput();
        }
        $image_path = null;
        if ($request->hasFile('image')) {
            $image_path = $request->image->store('images', 'public');
        }
        $user = \App\Models\User::create([
            'name' => $request->name,
            'email' => $request->email,
            'image' => $image_path,
            'country' => $request->country,
            'city' => $request->city,
            'password' => Hash::make($request->password)
        ]);

        event(new Registered($user));
        return redirect()->back()->with('success', 'you are  registered');
    }

    public function login()
    {
        return view('user.login');
    }

    public function loginUpdate(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:8'
        ]);
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->route('home')
                ->with('success', 'you are logged in');
        }
        return redirect()->back()->withErrors('invalid login',);
    }

    public function logout()
    {
        Auth::logout();
        return  redirect()->route('login');
    }

    public function emailVerify()
    {
        return view('auth.verify-email');
    }

    public function emailVerifyUpdate(EmailVerificationRequest $request)
    {
        $request->fulfill();
        return redirect()->route('home');
    }

    public function emailResend(Request $request)
    {
        $request->user()->sendEmailVerificationNotification();

        return redirect()->back()->with('success', 'verification link sent');
    }

    public function forgotPassword()
    {

        return view('auth.forgot-password');
    }
    public function passwordEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $status = Password::sendResetLink(
            $request->only('email')
        );
        return $status === Password::ResetLinkSent
            ? back()->with(['success' => __($status)])
            : back()->withErrors(['email' => (__($status))]);
    }

    public function resetPassword(string $token)
    {
        return view('auth.reset-password', ['token' => $token]);
    }


    public function resetPasswordUpdate(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',

            'password' => 'required|min:8|confirmed'
        ]);
        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (User $user, string $password) {
                $user->ForceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));
                $user->save();
                event(new PasswordReset($user));
            }
        );
        return $status === Password::PasswordReset
            ? redirect()->route('login')->with('status', __($status))
            : back()->withErrors(['email', [__($status)]]);
    }


    public function online()
    {

        $user = User::all();
        return view('user.online', compact('user'));
    }
}
