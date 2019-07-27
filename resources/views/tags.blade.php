@foreach($tags as $tag)
    @if (!empty($activeTag) && $activeTag->id == $tag->id)
    <span class="badge badge-primary">
        <a class="tag" href="{{ route('byTag', ['tagId' => $tag->id]) }}">{{ $tag->name }}</a>
    </span>
    @else
    <span class="badge badge-secondary">
        <a class="tag" href="{{ route('byTag', ['tagId' => $tag->id]) }}">{{ $tag->name }}</a>
    </span>
    @endif
@endforeach

<br><br>