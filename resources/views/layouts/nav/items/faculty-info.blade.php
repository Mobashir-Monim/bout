<a class="nav-item container-fluid" href="{{ route('faculty-info') }}">
    <li class="nav-link text-white {{ startsWith(request()->url(), route('faculty-info')) ? 'active' : '' }}">
        <div class="row">
            <span class="material-icons-outlined pr-1 col-2 my-auto">info</span>
            <span class="d-inline-block col-10 my-auto">Faculty Info {!! request()->url() == route('faculty-info') ? '<span class="sr-only">(current)</span>' : '' !!}</span>
        </div>
    </li>
</a>