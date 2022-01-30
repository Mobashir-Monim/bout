<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://fonts.googleapis.com/css2?family=Nunito:ital,wght@0,400;0,700;1,400&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
        <link rel="stylesheet" href="/css/report.css">
        <title>Evaluation Report for {{ $helper->report['name'] . " - " .  $helper->year . " " . $helper->semester }}</title>
    </head>
    <body>
        <div class="container" id="out-div">
            <!-- <p class="pb"></p> -->
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
                    <h5 class="mb-0">{{ $helper->report['name'] }} Course Overall Report</h5>
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
                                <div class="col-md-8"><p>Sections Evaluated</p></div>
                                <div class="col-md text-right"><p>{{ $helper->report['sectionCount'] }}</p></div>
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
                            <div class="row border-bottom">
                                <div class="col-md-8"><p>Course-Student Registrations</p></div>
                                <div class="col-md text-right"><p>{{ $helper->report['students'] }}</p></div>
                            </div>
                            <div class="row border-bottom">
                                <div class="col-md-8"><p>Course-Student Repondents</p></div>
                                <div class="col-md text-right"><p>{{ $helper->report['respondents'] }}</p></div>
                            </div>
                            <div class="row border-bottom">
                                <div class="col-md-8"><p>Respondent-Registration ratio</p></div>
                                <div class="col-md text-right"><p>{{ $helper->report['students'] != 0 ? round($helper->report['respondents'] / $helper->report['students'], 2) : '---' }}</p></div>
                            </div>
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
                                        <td colspan="10" class="py-1">The percentile rank of the course in comparision to all the courses of the department for given assessment item</td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" class="py-1">Section Highest (course)</td>
                                        <td colspan="10" class="py-1">The highest arbitrary score amongst all the sections of the course for given assessment item</td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" class="py-1">University Highest (courses)</td>
                                        <td colspan="10" class="py-1">The highest arbitrary score amongst all the courses university wide for given assessment item</td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" class="py-1">University Highest (sections)</td>
                                        <td colspan="10" class="py-1">The highest arbitrary score amongst all the sections university wide for given assessment item</td>
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
                                    <p class="text-center">Score <br> (out of 100)</p>
                                </th>
                                <th scope="col"><p class="text-center">Percentile</p></th>
                                <th scope="col"><p class="text-center">Section Highest<br>(course)</p></th>
                                <th scope="col"><p class="text-center">University Highest<br>(courses)</p></th>
                                <th scope="col"><p class="text-center">University Highest<br>(sections)</p></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($helper->factors as $key => $factor)
                                <tr>
                                    <td><p><b>[ <i class="text-primary">{{ $key }}</i> ] {{ $factor['name'] }}</b></p></td>
                                    <td><p class="text-center">{{ !array_key_exists($key, $helper->report['cats']) ? '---' : $helper->report['cats'][$key] }}</p></td>
                                    <td><p class="text-center">{{ !array_key_exists($key, $helper->report['overall']['percentiles']) ? '---' : $helper->report['overall']['percentiles'][$key] }}</p></td>
                                    <td><p class="text-center">{{ !array_key_exists($key, $helper->report['overall']['courseSectionHighests']) ? '---' : $helper->report['overall']['courseSectionHighests'][$key] }}</p></td>
                                    <td><p class="text-center">{{ !array_key_exists($key, $helper->report['overall']['uniCourseHighests']) ? '---' : $helper->report['overall']['uniCourseHighests'][$key] }}</p></td>
                                    <td><p class="text-center">{{ !array_key_exists($key, $helper->report['overall']['uniSectionHighests']) ? '---' : $helper->report['overall']['uniSectionHighests'][$key] }}</p></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="row mb-4">
                <div class="col-md-12">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col"><p>Assessment Item</p></th>
                                <th scope="col"><p class="text-center">Lowest Scoring Sections</p></th>
                                <th scope="col"><p class="text-center">Highest Scoring Sections</p></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($helper->factors as $key => $factor)
                                <tr>
                                    <td><p><b>[ <i class="text-primary">{{ $key }}</i> ] {{ $factor['name'] }}</b></p></td>
                                    <td><p class="text-center">{{ !array_key_exists($key, $helper->report['lowest']) ? '---' : $helper->report['lowest'][$key] }}</p></td>
                                    <td><p class="text-center">{{ !array_key_exists($key, $helper->report['highest']) ? '---' : $helper->report['highest'][$key] }}</p></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
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
    </body>
</html>