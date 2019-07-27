<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User as UserModel;

class User extends Controller
{
    public function showProfile(Request $request)
    {
        $user = auth()->user();

        return view('user/profile')->with([
            'user' => $user,
        ]);
    }

    public function saveProfile(Request $request)
    {
        $request->validate([
            'name' => 'required|min:3',
            'email' => 'required|email|unique:users,email,' . auth()->user()->id,
            'password' => 'nullable|min:5|confirmed',
        ]);

        $user = auth()->user();

        $user->name = $request->name;
        $user->email = $request->email;
        if (!empty($request->password)) {
            $user->password = \Hash::make($request->password);
        }

        /**
         * E-mail replies flag
         */
        $allowReplies = $request->input('allow_replies', 0);
        if ($allowReplies) {
            $user->allow_replies = true;
            $user->unsubscribe_replies_token = md5(date('d.m.Y H:i:s') . rand(100000, 999999));
        } else {
            $user->allow_replies = false;
            $user->unsubscribe_replies_token = '';
        }

        $user->save();

        return redirect('profile')->withSaved(1);
    }

    public function unsubscribe($hash = '')
    {
        $user = UserModel::where('unsubscribe_replies_token', $hash)->first();

        if ($user) {
            $user->unsubscribe_replies_token = '';
            $user->allow_replies = false;
            $user->save();
        }

        return view('unsubscribe', [
            'user' => $user
        ]);
    }
}
