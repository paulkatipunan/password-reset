<?php

namespace PaulKatipunan\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\User;
use PaulKatipunan\Models\PasswordReset;
use Illuminate\Support\Facades\Mail;

class PasswordResetController extends Controller
{
    public function create(Request $request)
    {

        $request->validate([
            'email' => 'required|string|email',
        ]);

        $user = User::where('email', $request->email)->first();
        
        if (!$user) {

            return response()->json([
                'message' => 'We cant find a user with that e-mail address.'
            ], 404);
            
        } else {
            $passwordReset = PasswordReset::updateOrCreate(
                ['email' => $user->email],
                [
                    'email' => $user->email,
                    'token' => str_random(60)
                 ]
            );
        }  

        if ($user && $passwordReset) {
            $this->sendCredentials($user, $passwordReset);
            // $user->notify(
            //     new PasswordResetRequest($passwordReset->token)
            // );

            return response()->json([
                'message' => 'We have e-mailed your password reset link!'
            ]);

        }
            
    }

    public function sendCredentials($user, $passwordReset)
    {
        $emails = $user->email;
        $url = url(route('find.token', $passwordReset->token));
        Mail::send(('emails.password-reset'), ['project_title' => 'MPBL', 'first_name' => $user->first_name, 'last_name' => $user->last_name, 'email' => $user->email, 'newPassword' => $passwordReset->token, 'url' => $url], function ($message) use ($emails) {
           $message->to($emails);
           $message->subject("MPBL Reset Password");
       });
    }

     public function toMail($notifiable)
     {
        $url = route('find.token', $this->token);
        return (new MailMessage)
            ->line('You are receiving this email because we        received a password reset request for your account.')
            ->action('Reset Password', url($url))
            ->line('If you did not request a password reset, no further action is required.');
    }

//--------------------------------------------------------------------------------------   

    public function find($token)
    {

        $passwordReset = PasswordReset::where('token', $token)
            ->first();

        if (!$passwordReset)
            die('This password reset link is invalid.');
            // return response()->json([
            //     'message' => 'This password reset token is invalid.'
            // ], 404);

        if (Carbon::parse($passwordReset->updated_at)->addMinutes(720)->isPast()) {
            
            $passwordReset->delete();

            die('This password reset link is invalid.');
            // return response()->json([
            //     'message' => 'This password reset token is invalid.'
            // ], 404);

        }

        // return response()->json($passwordReset);
        $data['passwordReset'] = $passwordReset;

        return view('manager.reset-password', $data);

    }

//--------------------------------------------------------------------------------------   
    
    public function reset(Request $request)
    {

        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string|confirmed',
            'token' => 'required|string'
        ]);

        $passwordReset = PasswordReset::where([
            ['token', $request->token],
            ['email', $request->email]
        ])->first();

        if (!$passwordReset)

            return response()->json([
                'message' => 'This password reset token is invalid.'
            ], 404);

        $user = User::where('email', $passwordReset->email)->first();

        if (!$user)

            return response()->json([
                'message' => 'We cant find a user with that e-mail address.'
            ], 404);

        $user->password = bcrypt($request->password);

        $user->save();

        $passwordReset->delete();

        $message = "Password Successfully Changed.";
        $emails = $user->email;
        Mail::raw('Hello!

            Your password has been changed successfully! Thank you.

            Regards,
            MPBL', function ($message) use ($emails) {
           $message->to($emails);
           $message->subject("Password Reset Success");
       });
        // $user->notify(new PasswordResetSuccess($passwordReset));
        if (auth()->check()) {
            $userName = '';
        } else {
            $userName = ucfirst($user->first_name). ' ' . ucfirst($user->last_name). ' ';
        }
        storeActivity("admin", "Change Password", $userName."Changed Password ". ' (' .$user->email . ')');
        return response()->json($message);

    }
}
