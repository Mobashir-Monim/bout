@extends('faculty-info.layouts.app')

@section('faculty-info.content')
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        @include('faculty-info.announcements.parts.inputs.title')
                        <div class="col-md-6 my-2">
                            @include('faculty-info.announcements.parts.inputs.semester')
                            @include('faculty-info.announcements.parts.inputs.year')
                        </div>
                        <div class="col-md-6 my-2">
                            @include('faculty-info.announcements.parts.inputs.valid_till')
                
                            <div class="btn-group w-100">
                                @include('faculty-info.announcements.parts.inputs.announcement_target')
                            </div>
                        </div>
                        <div class="col-md-12 my-2">
                            <textarea name="c_description" id="summernote" cols="30" rows="10" placeholder="This is the course description placeholder"></textarea>
                        </div>
                        <div class="col-md-12 my-2">
                            <p class="mb-0">Keywords</p>
                            @include('faculty-info.announcements.parts.inputs.keywords')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    @include('faculty-info.announcements.scripts.action')
@endsection