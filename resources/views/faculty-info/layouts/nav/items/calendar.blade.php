<li class="nav-item">
    @if (request()->url() != route('faculty-info.calendar'))
        <a class="nav-link" href="{{ route('faculty-info.calendar') }}">Calendar</a>
    @else
        <a class="nav-link active-2" href="{{ route('faculty-info.calendar') }}">Calendar <span class="sr-only">(current)</span></a>
    @endif
</li>