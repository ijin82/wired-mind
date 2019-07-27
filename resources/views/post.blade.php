@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-11">

            @include('tags')

            @if (session('saved'))
                <div class="alert alert-success" role="alert">
                    {{ __('Your comment was added.') }}
                </div>
            @endif

            @if (session('deleted'))
                <div class="alert alert-danger" role="alert">
                    {{ __('Your comment was deleted.') }}
                </div>
            @endif

            <div class="card">
                <div class="card-header">
                    <strong>{{ $post->header }}</strong>
                    <span class="float-right">
                        {{ date_format($post->created_at, "F d, Y") }}
                    </span>
                </div>

                <div class="card-body">{!! $post->text !!}</div>
            </div>

            <span class="float-right">
                @foreach($post->tags as $tag)
                    <span class="badge badge-secondary">
                        <a class="tag" href="{{ route('byTag', ['tagId' => $tag->id]) }}">{{ $tag->name }}</a>
                    </span>
                @endforeach
            </span>

            <div class="m-5"></div>

            <h2>{{ __('Comments') }}</h2>

            @if (!$post->comments->count())
                <div class="card">
                    <div class="card-body">{{ __('No comments here yet.') }}</div>
                </div>
            @else
                @foreach ($post->comments as $comment)
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
                            <span class="float-right">
                                <img src="https://www.gravatar.com/avatar/{{ md5($comment->user->email) }}" class="gravatar" />
                                @guest
                                @else
                                    <br>
                                    <a href="#add-comment" class="btn btn-sm btn-outline-secondary ml-4 mt-2 reply-comment"
                                       rel="{{ $comment->id }}">{{ __('Reply') }}</a>
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
                                        ]) }}" class="btn btn-sm btn-outline-danger ml-3 mt-2">{{ __('Delete') }}</a>
                                    @endif
                                @endguest
                            </span>
                            {!! nl2br(e($comment->comment_text)) !!}
                        </div>
                    </div>
                @endforeach
            @endif

            <div class="m-5"></div>

            @guest
                {{ __('You have to') }}
                <a href="{{ route('login') }}">{{ __('login') }}</a>
                {{ __('to post a new comment.') }}
            @else
                <h2>{{ __('Add comment') }}</h2>
                <a name="add-comment"></a>

                <form method="post" action="{{ route('comment', ['postId' => $post->id]) }}">
                    @csrf
                    <input type="hidden" name="post_id" value="{{ $post->id }}">
                    <input type="hidden" name="reply_comment_id" id="replyCommentId" value="0">
                    <div class="card mb-3 reply-card d-none">
                        <div class="card-body">
                            {{ __('Reply to comment ') }} <span class="badge badge-secondary reply-comment-id">0</span>
                            <span class="float-right">
                                <a href="#" class="btn btn-sm btn-outline-secondary" id="cancel-reply">{{ __('Cancel') }}</a>
                            </span>
                        </div>
                    </div>

                    <div class="form-group">
                        <textarea name="comment_text" rows="5"
                                  class="form-control @error('comment_text') is-invalid @enderror"
                                  placeholder="{{ __('Comment text') }}"></textarea>
                        @if ($errors->has('comment_text'))
                            <span class="invalid-feedback" role="alert"><strong>{{ $errors->first('comment_text') }}</strong></span>
                        @endif
                    </div>

                    <button type="submit" class="btn btn-outline-primary">{{ __('Post comment') }}</button>
                </form>
            @endguest

        </div>
    </div>
</div>

<script>
    $(function(){
        $('#cancel-reply').bind('click', function () {
            $('.reply-card').addClass('d-none');
            $('#replyCommentId').val(0);
            return false;
        });

        $('.reply-comment').click(function () {
            $('#replyCommentId').val($(this).attr('rel'));
            $('.reply-comment-id').text($(this).attr('rel'));
            $('.reply-card').removeClass('d-none');
        });
    });
</script>

@endsection
