<a class="nav-item container-fluid" href="{{ route('enterprise-parts') }}">
    <li class="nav-link text-white {{ request()->url() == route('enterprise-parts') ? 'active' : '' }} row">
        <span class="material-icons-outlined">api</span>
        <span class="d-inline-block col-10 my-auto">Enterprise Parts {!! request()->url() == route('enterprise-parts') ? '<span class="sr-only">(current)</span>' : '' !!}</span>
    </li>
</a>