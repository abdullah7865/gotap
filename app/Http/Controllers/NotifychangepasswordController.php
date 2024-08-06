<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Mail\ChangePasswordMail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class NotifychangepasswordController extends Controller
{
    public function resetAllPasswords()
    {
        $users = User::all();
        foreach ($users as $user) {
            $newPassword = Str::random(8);
            $hashedPassword = Hash::make($newPassword);
            $user->password = $hashedPassword;
            $user->save();

            Mail::to($user->email)->send(new ChangePasswordMail($user, $newPassword));
        }
    }
}
