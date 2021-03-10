<li class="nav-item">
    @if (request()->url() != route('faculty-info.announcements'))
        <a class="nav-link" href="{{ route('faculty-info.announcements') }}">Announcements</a>
    @else
        <a class="nav-link active-2" href="{{ route('faculty-info.announcements') }}">Announcements <span class="sr-only">(current)</span></a>
    @endif
</li>