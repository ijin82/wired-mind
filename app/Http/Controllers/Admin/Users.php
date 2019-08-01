<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;

class Users extends Controller
{
    public function index(Request $request)
    {
        $users = User::orderBy('id', 'asc')->paginate(10);

        if ($users->count() == 0 && $request->input('page', 0) > 1) {
            abort(404);
        }

        return view('admin/users/index')
            ->with([
                'users' => $users,
            ]);
    }
}
