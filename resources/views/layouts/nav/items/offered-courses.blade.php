<a class="nav-item container-fluid" href="{{ route('offered-courses') }}">
    <li class="nav-link text-white {{ request()->url() == route('offered-courses') ? 'active' : '' }}">
        <div class="row">
            <span class="material-icons-outlined pr-1 col-2 my-auto">format_list_numbered</span>
            <span class="d-inline-block col-10 my-auto">Offered Courses {!! request()->url() == route('offered-courses') ? '<span class="sr-only">(current)</span>' : '' !!}</span>
        </div>
    </li>
</a>

@if (auth()->user()->hasRole('super-admin'))
    <a class="nav-item container-fluid" href="{{ route('courses') }}">
        <li class="nav-link text-white {{ startsWith(request()->url(), route('courses')) ? 'active' : '' }}">
            <div class="row">
                <span class="pr-1 col-2 my-auto"></span>
                <span class="d-inline-block col-10 my-auto">Courses {!! request()->url() == route('courses') ? '<span class="sr-only">(current)</span>' : '' !!}</span>
            </div>
        </li>
    </a>
@endif