<a class="nav-item container-fluid" href="{{ route('eval-tracker.index') }}">
    <li class="nav-link text-white {{ request()->url() == route('eval-tracker.index') ? 'active' : '' }}">
        <div class="row">
            <span class="material-icons-outlined pr-1 col-2 my-auto">gps_fixed</span>
            <span class="d-inline-block col-10 my-auto">Eval Tracker {!! request()->url() == route('eval-tracker.index') ? '<span class="sr-only">(current)</span>' : '' !!}</span>
        </div>
    </li>
</a>