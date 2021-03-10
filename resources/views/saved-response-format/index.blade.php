@extends('layouts.dashboard')

@section('content')
    <div class="row min-h">
        <div class="col-md-12 my-auto">
            <div class="card">
                <div class="card-body p-3">
                    <div class="row">
                        <div class="col-md-12">
                            <select name="map_type" onchange="changeFormatType()" id="format_type" class="form-control border-top-0 border-right-0 border-left-0 px-0 custom-select-lg mb-3">
                                <option value="format_saved_responses">Format Saved Responses</option>
                                <option value="format_activetable">Format Activetable</option>
                            </select>
                        </div>
                    </div>
                    <div class="row" id="format_body">
                        <div class="col-md-6 text-center my-2">
                            <textarea name="saved_response" id="saved_response" class="form-control" style="height: 30vh; resize: none;" placeholder="Please paste the saved response here"></textarea>
                            <button class="btn btn-dark w-100 mt-2" onclick="formatJSONToText()">Format saved response</button>
                        </div>
                        <div class="col-md-6 my-2">
                            <textarea name="saved_response_output" id="saved_response_output" class="form-control" style="height: 30vh; resize: none;" placeholder="The formated response will be shown here"></textarea>
                            <button class="btn btn-dark w-100 mt-2" onclick="copyCode()">Copy formated output</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    @include('saved-response-format.scripts')
@endsection