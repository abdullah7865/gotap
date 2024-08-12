<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Models\Group;
use App\Mail\WelcomeMail;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Mail\ForgotPasswordMail;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Http\Resources\Api\UserResource;
use App\Http\Requests\Api\Auth\LoginRequest;
use App\Http\Requests\ChangePasswordRequest;
use App\Http\Requests\Api\Auth\RegisterRequest;
use App\Http\Requests\Api\Auth\ResetPasswordRequest;
use App\Http\Requests\Api\Auth\ForgotPasswordRequest;
use App\Http\Requests\Api\Auth\RecoverAccountRequest;

class AuthController extends Controller
{

    /**
     * Registration
     */
    public function register(RegisterRequest $request)
    {
        $user = User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => bcrypt($request->password),
            'private' => 0
        ]);

        Group::create([
            'user_id' => $user->id,
            'title' => 'favourites',
        ]);

        Group::create([
            'user_id' => $user->id,
            'title' => 'scanned card',
        ]);

        Mail::to($user->email)->send(new WelcomeMail($user));

        $token = $user->createToken(getDeviceId()  ?: $user->email)->plainTextToken;
        return response()->json(
            [

                'message' => trans('backend.account_registered_success'),
                'data' => new UserResource($user),
                'token' => $token
            ]
        );
    }


    /**
     * Login
     */
    public function login(LoginRequest $request)
    {
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json(
                [
                    'message' => trans('backend.email_not_registered'),
                ]
            );
        }

        if (!$user->status) {
            return response()->json(
                [
                    'message' => trans('backend.account_delete_or_deactivate'),
                ]
            );
        }

        if (!auth()->attempt($request->only('email', 'password'))) {
            return response()->json([
                'message' => trans('backend.password_incorrect')
            ]);
        }

        $token = $user->createToken(getDeviceId()  ?: $user->email)->plainTextToken;
        return response()->json(
            [

                'message' => trans('backend.logged_in_success'),
                'data' => new UserResource($user),
                'token' => $token
            ]
        );
    }

    /**
     * Forgot Password
     */
    public function forgotPassword(ForgotPasswordRequest $request)
    {
        if (Auth::guard('sanctum')->user()) {
            return response()->json(['message' => 'You are already logged In']);
        }
        $user = User::where('email', strtolower(trim($request->email)))->first();

        if (!$user) {
            return response()->json(['message' => trans('backend.email_not_registered')]);
        }

        $this->sendOtp($user->email);
        return response()->json(
            ['message' => trans('backend.otp_sent_mail')],
        );
    }

    /**
     * Send Otp
     */
    private function sendOtp($email)
    {
        $email = trim($email);
        $otp = rand(100000, 999999);

        DB::table('password_resets')->where('email', $email)->delete();

        DB::table('password_resets')->insert([
            'email' =>  $email,
            'token' => $otp,
            'created_at' => now(),
        ]);

        Mail::to($email)->send(new ForgotPasswordMail($otp));
    }

    /**
     * Reset Password
     */
    public function resetPassword(ResetPasswordRequest $request)
    {
        $email = strtolower(trim($request->email));
        $user = User::where('email', $email)->first();

        if (!$user) {
            return response()->json(['message' => trans('backend.email_not_registered')]);
        }

        $verifyOtp = DB::table('password_resets')
            ->where('email', $request->email)
            ->where('token', $request->otp)
            ->first();

        if (!$verifyOtp) {
            return response()->json(['message' => trans('backend.otp_invalid')]);
        }

        if (now()->diffInMinutes($verifyOtp->created_at) > 5) {
            $verifyOtp = DB::table('password_resets')
                ->where('email', $email)
                ->where('token', $request->otp)
                ->delete();
            return response()->json(['message' => trans('backend.otp_expired')]);
        }

        DB::table('password_resets')
            ->where('email', $request->email)
            ->where('token', $request->otp)
            ->delete();

        User::where('email', $request->email)->update([
            'password' => Hash::make($request->password)
        ]);

        $user = User::where('email', $request->email)->first();

        $token = $user->createToken(getDeviceId()  ?: $user->email)->plainTextToken;

        return response()->json(['message' => trans('backend.password_set'), 'token' => $token]);
    }

    /**
     * Recove Account
     */
    public function recoverAccount(RecoverAccountRequest $request)
    {
        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return response()->json(['message' => trans('backend.email_not_registered')]);
        }

        if ($user->status == 0) {
            $updated = User::where('email', $request->email)->update(
                [
                    'status' => 1,
                    'deactivated_at' => null,
                ]
            );
            if ($updated) {
                return response()->json([

                    'message' => trans('backend.account_recovered')
                ]);
            }
        } else {
            return response()->json([

                'message' => trans('backend.account_already_activated')
            ]);
        }
        return response()->json([
            'message' => trans('backend.something_wrong')
        ]);
    }

    /**
     * Logout
     */
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message' => trans('backend.logged_out')]);
    }

    public function otpVerify(Request $request)
    {
        $validatedData = $request->validate([
            'email' => 'required|email',
            'otp' => 'required|min:6',
        ]);

        $resetToken = DB::table('password_resets')->where('email', $validatedData['email'])->first();

        if (!$resetToken) {
            return response()->json(['error' => 'You are unauthorized to change the password'], 401);
        }

        if ($resetToken->token != $validatedData['otp']) {
            return response()->json(['error' => 'OTP is incorrect'], 400);
        }

        return response()->json(['message' => 'OTP is verified successfully!'], 200);
    }


    public function changePassword(ChangePasswordRequest $request)
    {
        $user = Auth::user();

        if (!$user) {
            return response()->json([
                'message' => 'User is not authenticated.']);
        }

        if (!Hash::check($request->old_password, $user->password)) {
            return response()->json([
                'message' => 'The old password is incorrect.']);
        }

        if ($request->new_password !== $request->new_password_confirmation) {
            return response()->json([
                'message' => 'The new password and confirmation password do not match.']);
        }

        $user->password = Hash::make($request->new_password);
        $user->save();

        return response()->json([

            'message' => 'Password changed successfully.']);
    }


}
