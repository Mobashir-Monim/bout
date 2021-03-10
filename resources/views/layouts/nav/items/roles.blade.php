<a class="nav-item container-fluid" href="{{ route('role') }}">
    <li class="nav-link text-white {{ request()->url() == route('role') ? 'active' : '' }} row">
        <span class="material-icons-outlined">badge</span>
        <span class="d-inline-block col-10 my-auto">Roles {!! request()->url() == route('role') ? '<span class="sr-only">(current)</span>' : '' !!}</span>
    </li>
</a>