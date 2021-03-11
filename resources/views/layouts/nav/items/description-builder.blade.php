<a class="nav-item container-fluid" href="{{ route('description-builder') }}">
    <li class="nav-link text-white {{ request()->url() == route('description-builder') ? 'active' : '' }}">
        <div class="row">
            <span class="material-icons-outlined pr-1 col-2 my-auto">design_services</span>
            <span class="d-inline-block col-10 my-auto">buX Description Builder {!! request()->url() == route('description-builder') ? '<span class="sr-only">(current)</span>' : '' !!}</span>
        </div>
    </li>
</a>