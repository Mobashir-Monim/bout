<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://fonts.googleapis.com/css2?family=Nunito:ital,wght@0,400;0,700;1,400&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
        <link rel="stylesheet" href="/css/report.css">
        <title>Evaluation Report for {{  "$helper->course Section $helper->section lab - " .  $helper->year . " " . $helper->semester }}</title>
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
                    <h5 class="mb-0">{{ $helper->course . " Section " . $helper->section }} Lab Report</h5>
                </div>
            </div>
            <div class="row mb-4">
                <div class="col-md">
                    <div class="row mb-2 border-bottom">
                        <div class="col-md-12">
                            <h6 class="mb-0"><b>Course Statistics</b></h6>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md">
                            <div class="row border-bottom">
                                <div class="col-md-8">
                                    <p>Overall Score <br> (out of 100)</p>
                                </div>
                                <div class="col-md text-right">
                                    <p id="overall-score">
                                        <span style="font-size: 0.5em" class="spinner-border spinner-border-sm" role="status"><span class="sr-only">Loading...</span></span>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2"></div>
                    </div>
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
                                <div class="col-md text-right"><p>{{ $helper->report['students'] }}</p></div>
                            </div> --}}
                            <div class="row border-bottom">
                                <div class="col-md-8"><p>Course-Student Repondents</p></div>
                                <div class="col-md text-right"><p>{{ $helper->report['respondents'] }}</p></div>
                            </div>
                            {{-- <div class="row border-bottom">
                                <div class="col-md-8"><p>Respondent-Registration ratio</p></div>
                                <div class="col-md text-right"><p>{{ round($helper->report['respondents'] / $helper->report['students'], 2) }}</p></div>
                            </div> --}}
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mb-4">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body bg-light">
                            <h5 class="mb-0"><b>Legend</b></h5>
                            <table class="table border-bottom mb-0">
                                <tbody>
                                    <tr>
                                        <td colspan="2" class="py-1">Score</td>
                                        <td colspan="10" class="py-1">The arbitrary score received by the course for given assessment item</td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" class="py-1">Percentile</td>
                                        <td colspan="10" class="py-1">The percentile rank of the lab section in comparision to all the lab sections of the course for given assessment item</td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" class="py-1">Section Highest (course)</td>
                                        <td colspan="10" class="py-1">The highest arbitrary score amongst all the lab sections of the course for given assessment item</td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" class="py-1">Percentile (department)</td>
                                        <td colspan="10" class="py-1">The percentile rank of the lab section in comparision to all the lab sections department wide for given assessment item</td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" class="py-1">Department Highest</td>
                                        <td colspan="10" class="py-1">The highest arbitrary score amongst all the lab sections department wide for given assessment item</td>
                                    </tr>
                                </tbody>
                            </table>
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
                                <th scope="col">
                                    <p class="text-center">
                                        Score <br> (out of 100)
                                    </p>
                                </th>
                                <th scope="col"><p class="text-center">Percentile<br>(course)</p></th>
                                <th scope="col"><p class="text-center">Section Highest<br>(course)</p></th>
                                <th scope="col"><p class="text-center">Percentile<br>(department)</p></th>
                                <th scope="col"><p class="text-center">Department Highest</p></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($helper->factors as $key => $factor)
                                <tr>
                                    <td><p><b>[ <i class="text-primary">{{ $key }}</i> ] {{ $factor['name'] }}</b></p></td>
                                    <td><p class="text-center">{{ !array_key_exists($key, $helper->report['cats']) ? '---' : $helper->report['cats'][$key] }}</p></td>
                                    <td><p class="text-center">{{ !array_key_exists($key, $helper->report['overall']['percentiles']) ? '---' : $helper->report['overall']['percentiles'][$key] }}</p></td>
                                    <td><p class="text-center">{{ !array_key_exists($key, $helper->report['overall']['courseSectionHighests']) ? '---' : $helper->report['overall']['courseSectionHighests'][$key] }}</p></td>
                                    <td><p class="text-center">{{ !array_key_exists($key, $helper->report['overall']['deptPercentiles']) ? '---' : $helper->report['overall']['deptPercentiles'][$key] }}</p></td>
                                    <td><p class="text-center">{{ !array_key_exists($key, $helper->report['overall']['deptHighest']) ? '---' : $helper->report['overall']['deptHighest'][$key] }}</p></td>
                                </tr>
                            @endforeach
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
                @foreach ($helper->report['lfs'] as $lf)
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
                @foreach ($helper->report['comments'] as $question => $comments)
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
                @foreach ($helper->report['qStat'] as $question => $options)
                    <div class="col-md-12 mb-4">
                        <p class="mb-2 border-bottom border-dark"><b>{{ $question }}</b></p>
                        <div class="row">
                            @foreach ($options as $option => $count)
                                <div class="col-md-6 mb-2">
                                    <p class="border-bottom border-secondary border-right"><b>{{ round(100 * $count / $helper->report['respondents'], 2) }}%</b> respondents said '<i>{{ $option }}</i>'</p>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        <button class="btn btn-danger d-print-none" id="print-btn" onclick="window.print()">Print Report</button>
        <script src="https://cdn.jsdelivr.net/npm/mathjs@9.3.2/lib/browser/math.min.js"></script>
        <script>
            let factorsMatrix = {!! $helper->getFactorVals() !!};
            let cats = {!! json_encode($helper->report['cats']) !!};
            let computeExpression = `{!! preg_replace( "/\r|\n/", "", $helper->getScoreExpression('lab') ) !!}`;

            window.onload = () => {
                setScore();
            }

            const setScore = () => {
                if (computeExpression == null || computeExpression == '') {
                    document.getElementById('overall-score').innerHTML = 'Score formula not decided by HOD/Dean';
                } else {
                    try {
                        let finalScore = math.evaluate(unmarkExpression(computeExpression), buildScope());
                        finalScore = typeof(finalScore) != 'object' ? finalScore.toFixed(2) : finalScore.entries[0].toFixed(2);
                        document.getElementById('overall-score').innerHTML = finalScore;
                    } catch (error) {
                        document.getElementById('overall-score').innerHTML = 'Error in formula, please contact HOD/Dean';
                    }
                }
            }

            const unmarkExpression = (exp) => {
                return exp.replaceAll('$', '');
            }

            const buildScope = () => {
                let scope = {};

                for (let f in factorsMatrix) {
                    if (computeExpression.includes(`$${ f }$`)) {
                        if (cats.hasOwnProperty(f)) {
                            scope[f] = cats[f] == null ? 0 : cats[f];
                        } else {
                            scope[f] = 0;
                        }
                    }
                }

                return scope;
            }

            const getIndicesOf = (searchStr, str, caseSensitive = false) => {
                let searchStrLen = searchStr.length;

                if (searchStrLen == 0) {
                    return [];
                }

                let startIndex = 0, index, indices = [];
                if (!caseSensitive) {
                    str = str.toLowerCase();
                    searchStr = searchStr.toLowerCase();
                }

                while ((index = str.indexOf(searchStr, startIndex)) > -1) {
                    indices.push(index);
                    startIndex = index + searchStrLen;
                }

                return indices;
            }
        </script>
    </body>
</html>