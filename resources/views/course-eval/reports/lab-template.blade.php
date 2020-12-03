<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://fonts.googleapis.com/css2?family=Nunito:ital,wght@0,400;0,700;1,400&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
        <link rel="stylesheet" href="/css/report.css">
        <title>Evaluation Report for {{ $helper->results['name'] . " lab - " .  $helper->year . " " . $helper->semester }}</title>
    </head>
    <body>
        <div class="container" id="out-div">
            <div class="row my-4 align-items-center">
                <div class="col-4 col-sm-2">
                    <img src="/img/buX-color.png" alt="buX-logo" class="img-fluid">
                </div>
                <div class="col-8 col-sm">
                    <h2 class="border-bottom d-none d-sm-block">Course Evaluation Report</h2>
                    <h5 class="border-bottom d-block d-sm-none">Course Evaluation Report</h5>
                </div>
            </div>
            <div class="row mt-4 mb-2 border-bottom">
                <div class="col-md-12" id="co-out">
                    <h5 class="mb-0">{{ $helper->results['name'] }} Lab Section Report</h5>
                </div>
            </div>
            <div class="row mb-4">
                <div class="col-md">
                </div>
                <div class="col-md-2"></div>
                <div class="col-md">
                    <div class="row border-bottom mb-2">
                        <div class="col-md-12">
                            <h6 class="mb-0 text-right"><b>Student Statistics</b></h6>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-2"></div>
                        <div class="col-md">
                            {{-- <div class="row border-bottom">
                                <div class="col-md-8"><p>Course-Student Registrations</p></div>
                                <div class="col-md text-right"><p>{{ $helper->results['students'] }}</p></div>
                            </div> --}}
                            <div class="row border-bottom">
                                <div class="col-md-8"><p>Course-Student Repondents</p></div>
                                <div class="col-md text-right"><p>{{ $helper->results['respondents'] }}</p></div>
                            </div>
                            {{-- <div class="row border-bottom">
                                <div class="col-md-8"><p>Respondent-Registration ratio</p></div>
                                <div class="col-md text-right"><p>{{ round($helper->results['respondents'] / $helper->results['students'], 2) }}</p></div>
                            </div> --}}
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mb-4">
                <div class="col-md-12">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col"><p>Assessment Item</p></th>
                                <th scope="col"><p class="text-center">Score</p></th>
                                <th scope="col"><p class="text-center">Percentile<br>(course)</p></th>
                                <th scope="col"><p class="text-center">Section Highest<br>(course)</p></th>
                                <th scope="col"><p class="text-center">Percentile<br>(department)</p></th>
                                <th scope="col"><p class="text-center">Department Highest</p></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><p><b>Lab Domain Knowledge (ldk)</b></p></td>
                                <td><p class="text-center">{{ $helper->results['cats']['ldk'] }}</p></td>
                                <td><p class="text-center">{{ $helper->results['overall']['percentiles']['ldk'] }}</p></td>
                                <td><p class="text-center">{{ $helper->results['overall']['courseSectionHighests']['ldk'] }}</p></td>
                                <td><p class="text-center">{{ $helper->results['overall']['deptPercentiles']['ldk'] }}</p></td>
                                <td><p class="text-center">{{ $helper->results['overall']['deptHighest']['ldk'] }}</p></td>
                            </tr>
                            <tr>                                
                                <td><p><b>Lab Facutly Effort (lfe)</b></p></td>
                                <td><p class="text-center">{{ $helper->results['cats']['lfe'] }}</p></td>
                                <td><p class="text-center">{{ $helper->results['overall']['percentiles']['lfe'] }}</p></td>
                                <td><p class="text-center">{{ $helper->results['overall']['courseSectionHighests']['lfe'] }}</p></td>
                                <td><p class="text-center">{{ $helper->results['overall']['deptPercentiles']['lfe'] }}</p></td>
                                <td><p class="text-center">{{ $helper->results['overall']['deptHighest']['lfe'] }}</p></td>
                            </tr>
                            <tr>                                
                                <td><p><b>Lab Learning Experience (llx)</b></p></td>
                                <td><p class="text-center">{{ $helper->results['cats']['llx'] }}</p></td>
                                <td><p class="text-center">{{ $helper->results['overall']['percentiles']['llx'] }}</p></td>
                                <td><p class="text-center">{{ $helper->results['overall']['courseSectionHighests']['llx'] }}</p></td>
                                <td><p class="text-center">{{ $helper->results['overall']['deptPercentiles']['llx'] }}</p></td>
                                <td><p class="text-center">{{ $helper->results['overall']['deptHighest']['llx'] }}</p></td>
                            </tr>
                            <tr>                                
                                <td><p><b>Excellence Indicator</b></p></td>
                                <td><p class="text-center">{{ $helper->results['cats']['ei'] }}</p></td>
                                <td><p class="text-center">{{ $helper->results['overall']['percentiles']['ei'] }}</p></td>
                                <td><p class="text-center">{{ $helper->results['overall']['courseSectionHighests']['ei'] }}</p></td>
                                <td><p class="text-center">{{ $helper->results['overall']['deptPercentiles']['ei'] }}</p></td>
                                <td><p class="text-center">{{ $helper->results['overall']['deptHighest']['ei'] }}</p></td>
                            </tr>
                            <tr>                                
                                <td><p><b>Irresponsibility Indicator</b></p></td>
                                <td><p class="text-center">{{ $helper->results['cats']['ii'] }}</p></td>
                                <td><p class="text-center">{{ $helper->results['overall']['percentiles']['ii'] }}</p></td>
                                <td><p class="text-center">{{ $helper->results['overall']['courseSectionHighests']['ii'] }}</p></td>
                                <td><p class="text-center">{{ $helper->results['overall']['deptPercentiles']['ii'] }}</p></td>
                                <td><p class="text-center">{{ $helper->results['overall']['deptHighest']['ii'] }}</p></td>
                            </tr>
                            <tr>                                
                                <td><p><b>Lab Rating</b></p></td>
                                <td><p class="text-center">{{ $helper->results['cats']['lr'] }}</p></td>
                                <td><p class="text-center">{{ $helper->results['overall']['percentiles']['lr'] }}</p></td>
                                <td><p class="text-center">{{ $helper->results['overall']['courseSectionHighests']['lr'] }}</p></td>
                                <td><p class="text-center">{{ $helper->results['overall']['deptPercentiles']['lr'] }}</p></td>
                                <td><p class="text-center">{{ $helper->results['overall']['deptHighest']['lr'] }}</p></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="row mb-3 border-bottom border-dark mt-3">
                <div class="col-md-12">
                    <h6 class="mb-0"><b>Faculty Evaluations</b></h6>
                </div>
            </div>

            <div class="row mb-3">
                @foreach ($helper->results['lfs'] as $lf)
                    <div class="col-md-6 mb-4">
                        <p class="mb-2 border-bottom border-dark"><b>{{ $lf['ini'] }}</b></p>
                        <div class="row">
                            @foreach ($lf['cats'] as $cat => $value)
                                <div class="col-md-4 mb-2">
                                    <p class="border-bottom border-secondary border-right"><b>{{ $cat }}</b>:{{ $value }}</p>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="row mb-3 border-bottom border-dark mt-3">
                <div class="col-md-12">
                    <h6 class="mb-0"><b>Comments</b></h6>
                </div>
            </div>

            <div class="row mb-3">
                @foreach ($helper->results['comments'] as $question => $comments)
                    <div class="col-md-12 mb-4">
                        <p class="mb-2 border-bottom border-dark"><b>{{ $question }}</b></p>
                        <div class="row">
                            @foreach ($comments as $comment)
                                @if ($comment != "" && !is_null($comment))
                                    <div class="col-md-6 mb-2">
                                        <p class="border-bottom border-secondary border-right">{{ $comment }}</p>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="row mb-3 border-bottom border-dark mt-3">
                <div class="col-md-12">
                    <h6 class="mb-0"><b>Stats</b></h6>
                </div>
            </div>
            
            <div class="row mb-3">
                @foreach ($helper->results['qStat'] as $question => $options)
                    <div class="col-md-12 mb-4">
                        <p class="mb-2 border-bottom border-dark"><b>{{ $question }}</b></p>
                        <div class="row">
                            @foreach ($options as $option => $count)
                                <div class="col-md-6 mb-2">
                                    <p class="border-bottom border-secondary border-right"><b>{{ round(100 * $count / $helper->results['respondents'], 2) }}%</b> respondents said '<i>{{ $option }}</i>'</p>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        <button class="btn btn-danger d-print-none" id="print-btn" onclick="window.print()">Print Report</button>
    </body>
</html>