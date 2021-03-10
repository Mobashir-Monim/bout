@extends('layouts.dashboard')

@section('content')
    <nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom" style="z-index: 0">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
        </button>
    
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                
                
                @include('faculty-info.layouts.nav.items.index')
                @include('faculty-info.layouts.nav.items.forms')
                @include('faculty-info.layouts.nav.items.announcements')
                @include('faculty-info.layouts.nav.items.tutorials')
                @include('faculty-info.layouts.nav.items.calendar')
                @include('faculty-info.layouts.nav.items.services')
                @include('faculty-info.layouts.nav.items.documents')
                @include('faculty-info.layouts.nav.items.contacts')
            </ul>
        </div>
    </nav>

    <main role="main" class="col-md-12 col-lg-12 ml-sm-autopx-md-4 pt-4" id="main">
        <div class="container">
            @yield('faculty-info.content')
        </div>
    </main>
@endsection