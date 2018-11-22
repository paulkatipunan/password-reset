<?php

namespace PaulKatipunan\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\User;
use PaulKatipunan\Models\PasswordReset;
use Illuminate\Support\Facades\Mail;
use Validator;
use DB;

class PasswordResetController extends Controller
{
    public function create(Request $request, $email)
    {
        $request = ['email' => $email];

        $validator = Validator::make($request, [
                'email' => 'required|string|email',
            ]);

        if ($validator->fails()) {

            return response(['message' => 'Email Not Valid']);
            
        }

        $user = User::where('email', $email)->first();
        
        if (!$user) {

            return response()->json([
                'message' => 'We cant find a user with that e-mail address.'
            ], 404);
            
        } else {
            
            $passwordReset = PasswordReset::where('email', $user->email)->delete();

            $passwordReset = new PasswordReset;
            $passwordReset->email = $user->email;
            $passwordReset->token = str_random(60);
            $passwordReset->created_at = Carbon::now()->toDateTimeString();
            $passwordReset->save();
           
        }  

        if ($user && $passwordReset) {

            $this->sendCredentials($user, $passwordReset);

            return response()->json([
                'message' => 'We have e-mailed your password reset link!'
            ]);

        }
            
    }

    public function sendCredentials($user, $passwordReset)
    {

        $email = $user->email;

        $url = url(route('find.token', $passwordReset->token));

        Mail::send(('email.reset-password'), ['user' => $user, 'url' => $url], function ($message) use ($email) {
           $message->to($email);
           $message->subject(env('MAIL_SUBJECT'), "Reset Password");
           $message->from(env('MAIL_FROM_EMAIL'));
        });

    }

//--------------------------------------------------------------------------------------   

    public function find($token)
    {

        $passwordReset = PasswordReset::where('token', $token)
            ->first();

        if (!$passwordReset) {
            
            return response()->json([
                'message' => 'This password reset Link is invalid.'
            ], 404);

        }

        if (Carbon::parse($passwordReset->created_at)->addMinutes(720)->isPast()) {
            
            $passwordReset->delete();

            return response()->json([
                'message' => 'This password reset Link is expired.'
            ], 404);

        }

        $data['passwordReset'] = $passwordReset;

        if(view()->exists('email.change-password')) {

            return view('email.change-password', $data);

        } else {

            return response()->json($passwordReset);

        }
        

    }

//--------------------------------------------------------------------------------------   
    
    public function reset(Request $request)
    {

        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string|confirmed',
            'token' => 'required|string'
        ]);

        $passwordReset = PasswordReset::where(
            'email', $request->email
        )->first();

        if (!$passwordReset) {

            return response()->json([
                'message' => 'This password reset Link is invalid.'
            ], 404);
        }

        $user = User::where('email', $passwordReset->email)->first();

        if (!$user) {

            return response()->json([
                'message' => 'We cant find a user with that e-mail address.'
            ], 404);
        }

        $user->password = bcrypt($request->password);

        $user->save();
        
        DB::table('password_resets')->where('email', $request->email)->delete();

        $message = "Password Successfully Changed.";

        $email = $user->email;

        Mail::raw('Hello! Your password has been changed successfully! Thank you. ', 
        function ($message) use ($email) {
           $message->to($email);
           $message->subject(env('MAIL_SUBJECT'), "Reset Password");
           $message->from(env('MAIL_FROM_EMAIL'));
        });

        
        return response()->json($message);

    }
}
