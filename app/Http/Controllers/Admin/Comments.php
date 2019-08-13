<?php

namespace App\Http\Controllers\Admin;

use App\Models\Comment;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class Comments extends Controller
{
    public function index(Request $request)
    {
        $comments = Comment::OrderBy('id', 'desc')->paginate(20);

        if ($comments->count() == 0 && $request->input('page', 0) > 1) {
            abort(404);
        }

        return view('admin/comments/index')->with([
            'comments' => $comments,
            'admActive' => 'comments',
        ]);
    }
}
