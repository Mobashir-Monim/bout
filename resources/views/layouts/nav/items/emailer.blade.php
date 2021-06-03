<a class="nav-item container-fluid" href="{{ route('emailer') }}">
    <li class="nav-link text-white {{ request()->url() == route('emailer') ? 'active' : '' }}">
        <div class="row">
            <span class="material-icons-outlined pr-1 col-2 my-auto">send</span>
            <span class="d-inline-block col-10 my-auto">Emailer {!! request()->url() == route('emailer') ? '<span class="sr-only">(current)</span>' : '' !!}</span>
        </div>
    </li>
</a>

@if (auth()->user()->hasRole('super-admin'))
    <a class="nav-item container-fluid" href="{{ route('emailer.eval') }}">
        <li class="nav-link text-white {{ startsWith(request()->url(), route('emailer.eval')) ? 'active' : '' }}">
            <div class="row">
                <span class="pr-1 col-2 my-auto"></span>
                <span class="d-inline-block col-10 my-auto">Eval Mailer {!! request()->url() == route('emailer.eval') ? '<span class="sr-only">(current)</span>' : '' !!}</span>
            </div>
        </li>
    </a>
@endif