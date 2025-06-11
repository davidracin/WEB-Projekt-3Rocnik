<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Str;

class PasswordResetController extends Controller
{
    /**
     * Show the forgot password form
     */
    public function showForgotPasswordForm()
    {
        return view('auth.forgot-password');
    }

    /**
     * Handle forgot password request
     */
    public function sendResetLinkEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ], [
            'email.required' => 'Email je povinný.',
            'email.email' => 'Zadejte platný email.',
            'email.exists' => 'Uživatel s tímto emailem neexistuje.',
        ]);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        if ($status === Password::RESET_LINK_SENT) {
            return back()->with(['status' => 'Odkaz pro obnovení hesla byl odeslán na váš email.']);
        }

        return back()->withErrors(['email' => 'Nepodařilo se odeslat odkaz pro obnovení hesla.']);
    }

    /**
     * Show the reset password form
     */
    public function showResetForm(Request $request, $token = null)
    {
        return view('auth.reset-password', [
            'token' => $token,
            'email' => $request->email
        ]);
    }

    /**
     * Handle reset password request
     */
    public function reset(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ], [
            'email.required' => 'Email je povinný.',
            'email.email' => 'Zadejte platný email.',
            'password.required' => 'Heslo je povinné.',
            'password.min' => 'Heslo musí mít alespoň 8 znaků.',
            'password.confirmed' => 'Hesla se neshodují.',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));

                $user->save();

                event(new PasswordReset($user));
            }
        );

        if ($status === Password::PASSWORD_RESET) {
            return redirect()->route('login')->with('status', 'Vaše heslo bylo úspěšně obnoveno.');
        }

        return back()->withErrors(['email' => 'Nepodařilo se obnovit heslo. Zkuste to znovu.']);
    }
}
