<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Auth\Events\PasswordReset;
use App\Notifications\ResetPasswordNotification;

class ForgotPasswordController extends Controller
{
    /**
     * Show the form where the user can request a password reset link.
     */
    public function showLinkRequestForm()
    {
      return view('auth.forgot_password');
    }

    /**
     * Handle the form submission and send the reset link email.
     */
    public function sendResetLinkEmail(Request $request)
    {
      $request->validate([
        'email' => [
          'required', 
          'email', 
          'exists:users,email'
        ],
      ]);

      // Generate a signed URL (Laravel's password broker creates a token)
      $status = Password::sendResetLink(
        $request->only('email')
      );

      return $status === Password::RESET_LINK_SENT
        ? back()->with('toast_success', __($status))
        : back()->withInput()->with('toast_error', __($status));
    }

    /**
     * Show the password reset form after user clicks the email link.
     *
     * @param string $token  The reset token
     * @param string $email  The email address (already URL‑encoded)
     */
    public function showResetForm(string $token)
    {
      // Check Email from query "?email=…"
      $email = request()->query('email');
      // If no email is provided (e.g., the link has been changed), fallback to null
      if (! $email) {
        abort(403, 'Invalid password reset link.');
      }
      return view('auth.reset_password', [
        'token' => $token,
        'email' => $email,
      ]);
    }

    /**
     * Process the new password and actually reset it.
     */
    public function reset(Request $request)
    {
      $request->validate([
        'token'    => 'required',
        'email'    => ['required', 'email', 'exists:users', 'email'],
        'password' => ['required', 'string', 'min:5', 'confirmed'],
      ]);

      $status = Password::reset(
        $request->only('email', 'password', 'password_confirmation', 'token'),
        function ($user, $password) {
          $user->forceFill([
            'password' => Hash::make($password),
            'remember_token' => Str::random(60),
          ])->save();

          event(new PasswordReset($user));
        }
      );

      return $status === Password::PASSWORD_RESET
        ? redirect()
            ->route('login')
            ->with('toast_success', __($status))
        : back()
            ->withInput()
            ->with('toast_error', __($status));
    }
}
