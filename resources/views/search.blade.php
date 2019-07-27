@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-11">
                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif

                @include('tags')

                {{ $posts->appends([
                    'search' => $search
                ])->links() }}


                @foreach($posts as $post)
                    <div class="card">
                        <div class="card-header">
                            <strong><a href="{{ route('post', ['id' => $post->id]) }}">{{ $post->header }}</a></strong>
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
                    <br><br>
                @endforeach

                @if (!$posts->count())
                    <div class="alert alert-danger" role="alert">Nothing found :(</div>
                @endif

                {{ $posts->appends([
                    'search' => $search
                ])->links() }}

            </div>
        </div>
    </div>
@endsection
