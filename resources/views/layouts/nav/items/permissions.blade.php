<a class="nav-item container-fluid" href="{{ route('permissions') }}">
    <li class="nav-link text-white {{ request()->url() == route('permissions') ? 'active' : '' }} row">
        <span class="material-icons-outlined">https</span>
        <span class="d-inline-block col-10 my-auto">Permissions {!! request()->url() == route('permissions') ? '<span class="sr-only">(current)</span>' : '' !!}</span>
    </li>
</a>