<nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-dark sidebar collapse">
    <div class="sidebar-sticky pt-3">
        <ul class="nav flex-column">
            @include('layouts.nav.items.mapper')
            @include('layouts.nav.items.formatter')
            @include('layouts.nav.items.evaluations')
            @include('layouts.nav.items.description-builder')
            @include('layouts.nav.items.faculty-info')

            @if (auth()->user()->hasRole('dco') || auth()->user()->hasRole('super-admin'))
                @include('layouts.nav.items.enterprise-parts')
                @include('layouts.nav.items.offered-courses')
            @endif

            @if (auth()->user()->hasRole('it-team') || auth()->user()->hasRole('super-admin'))
                @include('layouts.nav.items.student-gsuite-tracker')
            @endif
            
            @if(auth()->user()->hasRole('super-admin'))
                @include('layouts.nav.items.permissions')
                @include('layouts.nav.items.roles')
                @include('layouts.nav.items.emailer')
                @include('layouts.nav.items.data-backup')
            @endif
            
            {{-- @if (!is_null(auth()->user()->student))
                @include('layouts.nav.items.forms')
            @endif

            @include('layouts.nav.items.external-courses')
            @include('layouts.nav.items.admin') --}}

            {{-- @include('layouts.nav.items.logout') --}}
        </ul>
    </div>
</nav>