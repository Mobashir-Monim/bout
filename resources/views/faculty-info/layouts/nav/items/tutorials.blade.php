<li class="nav-item">
    @if (request()->url() != route('faculty-info.tutorials'))
        <a class="nav-link" href="{{ route('faculty-info.tutorials') }}">Tutorials</a>
    @else
        <a class="nav-link active-2" href="{{ route('faculty-info.tutorials') }}">Tutorials <span class="sr-only">(current)</span></a>
    @endif
</li>