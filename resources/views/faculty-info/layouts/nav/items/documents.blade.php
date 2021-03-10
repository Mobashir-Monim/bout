<li class="nav-item">
    @if (request()->url() != route('faculty-info.documents'))
        <a class="nav-link" href="{{ route('faculty-info.documents') }}">Documents</a>
    @else
        <a class="nav-link active-2" href="{{ route('faculty-info.documents') }}">Documents <span class="sr-only">(current)</span></a>
    @endif
</li>