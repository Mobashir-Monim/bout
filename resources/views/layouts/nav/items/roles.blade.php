<a class="nav-item container-fluid" href="{{ route('role') }}">
    <li class="nav-link text-white {{ request()->url() == route('role') ? 'active' : '' }}">
        <div class="row">
            <span class="material-icons-outlined pr-1 col-2 my-auto">badge</span>
            <span class="d-inline-block col-10 my-auto">Roles {!! request()->url() == route('role') ? '<span class="sr-only">(current)</span>' : '' !!}</span>
        </div>
    </li>
</a>