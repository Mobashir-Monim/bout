@extends('layouts.dashboard')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-dark text-white">All Enterprise Parts</div>
                <div class="card-body">
                    <div class="row">
                        @foreach ($parts as $part)
                            <div class="col-md-6 my-1 border-left border-bottom" onclick="window.open('{{ route('enterprise-parts.show', ['part' => $part->id]) }}', '_self')">
                                <a href="#/" class="btn btn-link">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <b>{{ $part->name }}</b>
                                @if ($part->acronym != "" && !is_null($part->acronym))
                                    ({{ $part->acronym }})
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    @if (auth()->user()->hasRole('super-admin'))
        <div class="row">
            <div class="col-md-12 my-2 text-right">
                @include('enterprise-part.add')
            </div>
        </div>
    @endif
@endsection

@section('scripts')
    
@endsection