<li class="nav-item">
    @if (request()->url() != route('faculty-info.services'))
        <a class="nav-link" href="{{ route('faculty-info.services') }}">Services</a>
    @else
        <a class="nav-link active-2" href="{{ route('faculty-info.services') }}">Services <span class="sr-only">(current)</span></a>
    @endif
</li>