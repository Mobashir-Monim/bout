<li class="nav-item">
    @if (request()->url() != route('faculty-info.contacts'))
        <a class="nav-link" href="{{ route('faculty-info.contacts') }}">Contacts</a>
    @else
        <a class="nav-link active-2" href="{{ route('faculty-info.contacts') }}">Contacts <span class="sr-only">(current)</span></a>
    @endif
</li>