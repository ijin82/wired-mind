@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <h2>Posts</h2>

                {{ $posts->links() }}

                <table class="table">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Title</th>
                    </tr>
                    </thead>
                @foreach($posts as $post)
                    <tr>
                        <td>
                            {{ $post->id }}
                        </td>
                        <td>
                            <a href="{{ route('a.posts.show', [
                                'id' => $post->id
                                ]) }}">{{ $post->header }}</a>
                            <span class="float-right">
                                @foreach($post->tags as $tag)
                                    <span class="badge badge-secondary">
                                        <a class="tag" href="{{ route('a.posts', ['tag_id' => $tag->id]) }}">{{ $tag->name }}</a>
                                    </span>
                                @endforeach
                            </span>
                            <br>
                            <span class="float-right">
                                {{ date_format($post->created_at, "F d, Y") }}
                                <?php
                                $commentsCount = $post->comments->count();
                                ?>
                                @if($commentsCount)
                                    <span class="badge badge-success">{{ $commentsCount }}</span>
                                @endif
                            </span>
                        </td>
                    </tr>
                @endforeach
                </table>

                {{ $posts->links() }}
            </div>
        </div>
    </div>
@endsection
