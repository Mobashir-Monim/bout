<li class="nav-item">
    @if (request()->url() != route('faculty-info.forms'))
        <a class="nav-link" href="{{ route('faculty-info.forms') }}">Forms</a>
    @else
        <a class="nav-link active-2" href="{{ route('faculty-info.forms') }}">Forms <span class="sr-only">(current)</span></a>
    @endif
</li>