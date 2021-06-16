@extends('faculty-info.layouts.app')

@section('faculty-info.content')
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12 my-2">
                            <h3 class="border-bottom">New Announcement</h3>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                  <span class="input-group-text">Title</span>
                                </div>
                                <input type="text" name="title" id="title" class="form-control" placeholder="Announcement Title">
                            </div>
                        </div>
                        <div class="col-md-6 my-2">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <label class="input-group-text" for="semester">Semester</label>
                                </div>
                                <select class="custom-select" id="semester">
                                    <option value="">Please select a semester</option>
                                    @foreach (['Spring', 'Summer', 'Fall'] as $sem)
                                        <option value="{{ $sem }}">{{ $sem }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <label class="input-group-text" for="year">Year</label>
                                </div>
                                <select class="custom-select" id="year">
                                    <option value="">Please select a year</option>
                                    @for ($i = Carbon\Carbon::now()->diffInYears(Carbon\Carbon::parse('1st Jan 2020')) + 1; $i >= 0; $i--)
                                        <option value="{{ 2020 + $i }}">{{ 2020 + $i }}</option>
                                    @endfor
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6 my-2">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                  <span class="input-group-text">Valid Till</span>
                                </div>
                                <input type="date" name="valid_till" id="valid_till" class="form-control" placeholder="Valid Till">
                            </div>
                
                            <div class="btn-group w-100">
                                <button type="button" class="btn btn-dark dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Announcement For
                                </button>
                                <div class="dropdown-menu" style="min-width: 30vw; max-width: 80vw; max-height: 30vh; overflow: scroll">
                                    @if (auth()->user()->hasRole('super-admin'))
                                        <div class="input-group px-1">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">
                                                    <input type="checkbox" id="all" name="all" onclick="setAnnouncementTarget(null)">
                                                </div>
                                            </div>
                                            <input type="text" class="form-control disabled" disabled value="Everyone" style="font-size: 0.8em">
                                        </div>
                                        <div class="dropdown-divider"></div>
                                        @foreach (App\Models\EnterprisePart::all() as $ep)
                                            <div class="input-group mb-1 px-1">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text">
                                                        <input type="checkbox" id="{{ $ep->acronym }}" onclick="setAnnouncementTarget({{ $ep->id }})">
                                                    </div>
                                                </div>
                                                <input type="text" class="form-control disabled" disabled value="({{ $ep->acronym }}) {{ $ep->name }}" style="font-size: 0.8em">
                                            </div>
                                        @endforeach
                                    @else
                                        @foreach (App\Models\EnterprisePart::whereIn('id', auth()->user()->hasRole('announcement-author%'))->get() as $ep)
                                            <div class="input-group mb-1 px-1">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text">
                                                        <input type="checkbox" id="{{ $ep->acronym }}" onclick="setAnnouncementTarget({{ $ep->id }})">
                                                    </div>
                                                </div>
                                                <input type="text" class="form-control disabled" disabled value="({{ $ep->acronym }}) {{ $ep->name }}" style="font-size: 0.8em">
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 my-2">
                            <textarea name="c_description" id="summernote" cols="30" rows="10" placeholder="This is the course description placeholder"></textarea>
                        </div>
                        <div class="col-md-12 my-2">
                            <p class="mb-0">Keywords</p>
                            <div class="my-2 py-2 border-top border-bottom" id="keywords-cont"></div>
                            <div class="row">
                                <div class="col-md-6 my-2">
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                          <span class="input-group-text">Keyword</span>
                                        </div>
                                        <input type="text" name="keyword" id="keyword" class="form-control" placeholder="Keyword">
                                        <div class="input-group-append">
                                            <button class="btn btn-dark" type="button" onclick="addKeyword()"><i class="fas fa-plus"></i></button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 my-2">
                                    <button class="btn btn-dark w-100" type="button" onclick="postAnnouncement()">Post Announcement</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    @include('faculty-info.announcements.scripts.create')
@endsection