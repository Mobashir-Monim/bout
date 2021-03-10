<a class="nav-item container-fluid" href="{{ route('description-builder') }}">
    <li class="nav-link text-white {{ request()->url() == route('description-builder') ? 'active' : '' }} row">
        <span class="material-icons-outlined">design_services</span>
        <span class="d-inline-block col-10 my-auto">buX Description Builder {!! request()->url() == route('description-builder') ? '<span class="sr-only">(current)</span>' : '' !!}</span>
    </li>
</a>