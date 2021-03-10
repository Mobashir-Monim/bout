<a class="nav-item container-fluid" href="{{ route('saved-response-format') }}">
    <li class="nav-link text-white {{ request()->url() == route('saved-response-format') ? 'active' : '' }} row">
        <span class="material-icons-outlined">change_circle</span>
        <span class="d-inline-block col-10 my-auto">buX Data Formatter {!! request()->url() == route('saved-response-format') ? '<span class="sr-only">(current)</span>' : '' !!}</span>
    </li>
</a>