<?php

namespace App\Http\Controllers\Admin;

use App\Models\Post;
use App\Models\Tag;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class Posts extends Controller
{
    public function index(Request $request)
    {
        $posts = Post::whereDoesntHave('tags', function (Builder $query) {
            $query->where('exclude', '=', 1);
        })
            ->with('tags')
            ->where('visible', true)
            ->OrderBy('id', 'desc')
            ->paginate(20);

        $tags = Tag::OrderBy('name')->get();

        if ($posts->count() == 0 && $request->input('page', 0) > 1) {
            abort(404);
        }

        return view('admin/posts/index')->with([
            'posts' => $posts,
            'tags' => $tags,
            'admActive' => 'posts',
        ]);
    }

    public function show($id)
    {
        $post = Post::findOrFail($id);

        dd($post);
    }

    public function save(Request $request)
    {
        $post = Post::findOrFail($request->input('id', 0));

        dd($post);
    }
}
