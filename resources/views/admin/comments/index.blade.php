@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <h2>Comments</h2>

                {{ $comments->links() }}

                @foreach ($comments as $comment)
                    <div class="card mb-3">
                        <div class="card-header">
                            <a name="comment-{{ $comment->id }}"></a>
                            <span class="badge badge-secondary">{{ $comment->id }}</span>
                            <strong>{{ $comment->user->name }}</strong>
                            @if($comment->reply_comment_id)
                                | {{ __('Reply to comment ->') }}
                                <a href="#comment-{{ $comment->reply_comment_id }}">{{ $comment->reply_comment_id }}</a>
                            @endif
                            <span class="float-right">
                                {{ date_format($comment->created_at, "H:i F d, Y") }}
                            </span>
                        </div>

                        <div class="card-body">
                            <span class="float-right ml-1">
                                <img src="https://www.gravatar.com/avatar/{{ md5($comment->user->email) }}"
                                     class="gravatar" />
                                <br>
                                <a href="{{ route('post', [
                                    'id' => $comment->post->id
                                ]) }}#comment-{{ $comment->id }}" class="btn btn-sm btn-outline-secondary mt-2 reply-comment"
                                   rel="{{ $comment->id }}">{{ __('Reply in post') }}</a>
                                <?php
                                $commentTime = \Carbon\Carbon::parse($comment->created_at)->timestamp;
                                $showDelete = (time() - $commentTime <= 300) ? 1 : 0;

                                if ($comment->user->id != auth()->user()->id) {
                                    $showDelete = 0;
                                }

                                if (auth()->user() && auth()->user()->role_id == 1) {
                                    $showDelete = 1;
                                }
                                ?>
                                @if($showDelete)
                                    <br>
                                    <a href="{{ route('delete-comment', [
                                        'commentId' => $comment->id
                                    ]) }}" class="btn btn-sm btn-outline-danger mt-2">{{ __('Delete') }}</a>
                                @endif
                            </span>
                            {!! nl2br(e($comment->comment_text)) !!}
                        </div>
                    </div>
                @endforeach

                {{ $comments->links() }}
            </div>
        </div>
    </div>
@endsection
