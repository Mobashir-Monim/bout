<a class="nav-item container-fluid" href="{{ route('faculty-info') }}">
    <li class="nav-link text-white {{ startsWith(request()->url(), route('faculty-info')) ? 'active' : '' }} row">
        <span class="material-icons-outlined">info</span>
        <span class="d-inline-block col-10 my-auto">Faculty Info {!! request()->url() == route('faculty-info') ? '<span class="sr-only">(current)</span>' : '' !!}</span>
    </li>
</a>