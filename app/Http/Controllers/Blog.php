<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;

use App\Models\Post;
use App\Models\Tag;
use App\Models\Comment;
use App\Models\User;
use App\Notifications\NewCommentNotification;
use App\Notifications\CommentReplyNotification;
use Illuminate\Support\Facades\Cache;

class Blog extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    public function index(Request $request)
    {
        $postsPageKey = 'posts-page-' . $request->input('page', 1);
        $posts = Cache::get($postsPageKey);

        if (!$posts) {
            $posts = Post::whereDoesntHave('tags', function (Builder $query) {
                    $query->where('exclude', '=', 1);
                })
                ->with('tags')
                ->where('visible', true)
                ->OrderBy('id', 'desc')
                ->paginate(5);

            Cache::put($postsPageKey, $posts, 600);
        }

        if ($posts->count() == 0 && $request->input('page', 0) > 1) {
            abort(404);
        }

        return view('home')->with([
            'posts' => $posts,
            'tags' => $this->getTags(),
        ])->render();
    }

    public function indexByTag($tagId, Request $request)
    {
        $activeTag = Tag::findOrFail($tagId);

        $postsPageByTagKey = 'posts-page-' . $request->input('page', 1) . '-tag-' . $tagId;
        $posts = Cache::get($postsPageByTagKey);

        if (!$posts) {
            $posts = Post::whereHas('tags', function (Builder $query) use ($tagId) {
                    $query->where('id', '=', $tagId);
                })
                ->with('tags')
                ->where('visible', true)
                ->OrderBy('id', 'desc')
                ->paginate(5);

            Cache::put($postsPageByTagKey, $posts, 600);
        }

        if ($posts->count() == 0 && $request->input('page', 0) > 1) {
            abort(404);
        }

        $page = view('home')->with([
            'posts' => $posts,
            'tags' => $this->getTags(),
            'activeTag' => $activeTag,
        ])->render();

        return $page;
    }

    public function post($id)
    {
        $post = Post::findOrFail($id);

        $tags = Tag::OrderBy('name')->get();

        // for correct redirect after registration
        session(['url.intended' => url()->current()]);

        return view('post')->with([
            'post' => $post,
            'pageTitle' => $post->header,
            'tags' => $tags,
        ]);
    }

    public function rss()
    {
        $posts = $posts = Post::whereDoesntHave('tags', function (Builder $query) {
                $query->where('exclude', '=', 1);
            })
            ->with('tags')
            ->where('visible', true)
            ->OrderBy('id', 'desc')
            ->paginate(40);

        if (!$posts->count()) {
            abort(404);
        }

        $site = [
            'name' => config('app.name'), // Simplest Web
            'url' => route('rss'), // Link to your rss.xml. eg. https://simplestweb.in/rss.xml
            'description' => 'wired mind blog',
            'language' => 'ru', // eg. en, en-IN, jp
            // This generates the latest posts date in RSS compatible format
            'lastBuildDate' => $posts[0]->created_at->format(\DateTime::RSS),
        ];

        return response(view('rss', compact('posts', 'site')), 200)
            ->header('Content-Type', 'application/rss+xml; charset=utf-8');
    }

    public function search(Request $request)
    {
        $posts = Post::with('tags')
            ->where('visible', true)
            ->where(function($query) use ($request) {
                return $query->where('header', 'LIKE', '%' . $request->input('search', '') . '%')
                             ->orWhere('text', 'LIKE', '%' . $request->input('search', '') . '%');
            })
            ->OrderBy('id', 'desc')
            ->paginate(20);

        $tags = Tag::OrderBy('name')->get();

        if ($posts->count() == 0 && $request->input('page', 0) > 1) {
            abort(404);
        }

        return view('search')->with([
            'posts' => $posts,
            'tags' => $tags,
            'search' => $request->input('search', '')
        ]);
    }

    public function comment(Request $request)
    {
        $request->validate([
            'post_id' => 'required|integer|exists:posts,id',
            'comment_text' => 'required|string|min:3',
            'reply_comment_id' => 'required|integer|nullable',
        ]);

        $replyCommentId = $request->input('reply_comment_id', 0);
        if (!empty($replyCommentId)) {
            $checkComment = Comment::where('post_id', $request->post_id)
                ->where('id', $replyCommentId)
                ->first();
            if ($checkComment) {
                $replyCommentId = $checkComment->id;
            } else {
                $replyCommentId = 0;
            }
        }

        $comment = Comment::create([
            'user_id' => auth()->user()->id,
            'post_id' => $request->post_id,
            'comment_text' => $request->comment_text,
            'reply_comment_id' => $replyCommentId,
        ]);

        /**
         * Notification for app owner
         */
        $blogOwner = User::findOrFail(config('app.owner_id'));
        if ($blogOwner->hasVerifiedEmail()) {
            $blogOwner->notify(new NewCommentNotification($comment));
        }

        /**
         * "Reply" Notification
         */
        if ($replyCommentId && !empty($checkComment)) {
            if ($checkComment->user->hasVerifiedEmail() && $checkComment->user->wantsReplyNotifications()) {
                $checkComment->user->notify(new CommentReplyNotification($comment));
            }
        }

        return redirect()->route('post', ['id' => $request->post_id])->withSaved(1);
    }

    public function deleteComment($commentId = 0)
    {
        $comment = Comment::findOrFail($commentId);

        $commentTime = \Carbon\Carbon::parse($comment->created_at)->timestamp;
        $canDelete = (time() - $commentTime <= 300) ? 1 : 0;

        if ($canDelete && $comment->user_id == auth()->user()->id) {
            $comment->delete();
            return redirect()->back()->withDeleted(1);
        }

        if (auth()->user()->role_id == 1) {
            $comment->delete();
            return redirect()->back()->withDeleted(1);
        }

        return redirect()->back();
    }

    private function getTags()
    {
        $cacheKeyTags = 'tags';
        $tags = Cache::get($cacheKeyTags);

        if (!$tags) {
            $tags = Tag::OrderBy('name')->get();
        }

        return $tags;
    }
}
