@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <h3 class="border-bottom"><b>Factors Matrix of {{ $helper->eval->id }}</b></h3>

            <form action="{{ route('course-eval.factors-config', ['year' => $helper->year, 'semester' => $helper->semester]) }}" method="POST">
                @csrf
                <div id="factors-cont">
                    @if (!is_null($helper->eval->factors))
                        @foreach ($helper->factorsArray() as $key => $factor)
                            <div class="card my-3" id="{{ $key }}">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-1 offset-md-11 text-right">
                                            <a href="#/" onclick="removeFactor('{{ $key }}')" class="btn btn-light"><span aria-hidden="true">&times;</span></a>
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-md-8 my-auto">Name:<input type="text" name="name[]" class="form-control" value="{{ $factor->name }}" placeholder="Name of factor"></div>
                                        <div class="col-md-4 my-auto">Short Hand:<input type="text" name="short_hand[]" class="form-control" value="{{ $key }}" placeholder="Short Hand of factor"></div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            Description:
                                            <textarea name="description[]" class="form-control" placeholder="Description of factor">{{ $factor->description }}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
                
                <div class="card my-3">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 my-2">
                                <button class="btn btn-dark w-100" type="submit">Save</button>
                            </div>
                            @if (!is_null($helper->eval->factors))
                                <div class="col-md-6 my-2">
                                    <a href="{{ route('course-eval.matrix-config', ['year' => $helper->year, 'semester' => $helper->semester]) }}" class="btn btn-dark w-100" onclick="addFactor()">Configure Matrix</a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </form>

            <div class="card">
                <div class="card-header bg-dark text-white">Creation alternatives</div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 my-2">
                            <div class="row">
                                <div class="col-md-8"><h5 class="border-bottom">Copy from Previous</h5></div>
                            </div>
                            <form action="{{ route('course-eval.factors-config.copy', ['year' => $helper->year, 'semester' => $helper->semester]) }}" method="POST">
                                @csrf
                                <div class="row">
                                    <div class="col-md my-1">
                                        <select name="prev_factor" id="prev_factor" class="form-control">
                                            <option value="">Please select a semester to copy from</option>
                                            @foreach ($helper->getPrevSems() as $sem)
                                                <option value="{{ $sem->id }}">{{ $sem->id }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-3 my-1">
                                        <button type="submit" class="btn btn-dark w-100">Copy</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="col-md-6 my-2">
                            <div class="row">
                                <div class="col-md-8"><h5 class="border-bottom">Bulk upload</h5></div>
                                <div class="col-md-4 text-right"><a href="/sample-files/Eval Uploadables - factors.xlsx" target="_blank">Sample Format</a></div>
                            </div>
                            <form action="{{ route('course-eval.factors-config.upload', ['year' => $helper->year, 'semester' => $helper->semester]) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-md my-1">
                                        <input type="file" name="factors_file" accept="xlsx, xls, csv" class="form-control">
                                    </div>
                                    <div class="col-md-3 my-1">
                                        <button type="submit" class="btn btn-dark w-100" id="bUploadBtn">Upload</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    @include('course-eval.factors.scripts.index')
@endsection