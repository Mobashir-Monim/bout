@extends('layouts.dashboard')

@section('content')
    <div class="row curbed-font-size">
        <div class="col-md-12">
            <h3 class="border-bottom"><b>Factors Matrix of {{ $helper->eval->id }}</b></h3>

            @foreach ($helper->questionMatrix() as $question => $matrix)
                <div class="card my-3">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12 table-responsive">
                                <p class="mb-0 border-bottom"><b>{{ $question }}</b></p>
                                <div class="row mb-3">
                                    <div class="col-md-2"><b>Type:</b></div>
                                    <div class="col-md-2">{{ $matrix->type }}</div>
                                    <div class="col-md-2"><b>Calc Type:</b></div>
                                    <div class="col-md-4">{{ $matrix->calc }}</div>
                                </div>
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th scope="col" class="py-1">Options</th>
                                            @foreach ($helper->getUniqueFactors($matrix) as $factor)
                                                <th scope="col" class="py-1">{{ $factor }}</th>
                                            @endforeach
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($matrix->options as $option => $analytics)
                                            <tr>
                                                <th class="py-1">{{ $option }}</th>
                                                @foreach ($helper->getUniqueFactors($matrix) as $factor)
                                                    <td class="py-1">{{ property_exists($analytics, $factor) ? $analytics->$factor : '0' }}</td>
                                                @endforeach
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach

            <div class="card my-3">
                <div class="card-header bg-dark text-white">Evaluation Matrix Bulk Upload</div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 my-2">
                            <a href="/sample-files/Eval Uploadables - matrix.xlsx">Sample File</a>
                            <input type="file" name="bulk_upload" id="bulk_upload" class="form-control" required>
                        </div>
                        <div class="col-md-4 mb-2 mt-auto">
                            @if (sizeof((array) $helper->questionMatrix()) > 0)
                                <a href="{{ route('evaluate', ['year' => $helper->year, 'semester' => $helper->semester]) }}" class="btn btn-dark w-100">Evaluate</a>
                            @endif
                        </div>
                        <div class="col-md-2 mt-auto text-right" id="spinner"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.16.0/jszip.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.16.0/xlsx.js"></script>
    @include('course-eval.matrix.scripts.index')
@endsection