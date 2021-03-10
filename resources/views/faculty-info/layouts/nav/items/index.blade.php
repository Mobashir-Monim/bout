<li class="nav-item">
    @if (request()->url() != route('faculty-info'))
        <a class="nav-link" href="{{ route('faculty-info') }}">Home</a>
    @else
        <a class="nav-link active-2" href="{{ route('faculty-info') }}">Home <span class="sr-only">(current)</span></a>
    @endif
</li>