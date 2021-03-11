<a class="nav-item container-fluid" href="{{ route('eval') }}">
    <li class="nav-link text-white {{ request()->url() == route('eval') ? 'active' : '' }}">
        <div class="row">
            <span class="material-icons-outlined pr-1 col-2 my-auto">analytics</span>
            <span class="d-inline-block col-10 my-auto">Evaluations {!! request()->url() == route('eval') ? '<span class="sr-only">(current)</span>' : '' !!}</span>
        </div>
    </li>
</a>