<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://fonts.googleapis.com/css2?family=Nunito:ital,wght@0,400;0,700;1,400&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
        <link rel="stylesheet" href="/css/report.css">
        <title>Evaluation Report for {{ $helper->results['name'] . " - " .  $helper->year . " " . $helper->semester }}</title>
    </head>
    <body>
        <div class="container" id="out-div">
            <!-- <p class="pb"></p> -->
            <div class="row my-4 align-items-center">
                <div class="col-4 col-sm-2">
                    <img src="/img/buX-color.png" alt="buX-logo" class="img-fluid">
                </div>
                <div class="col-8 col-sm">
                    <h2 class="border-bottom d-none d-sm-block">Department Overall Evaluation Report</h2>
                    <h5 class="border-bottom d-block d-sm-none">Department Overall Evaluation Report</h5>
                </div>
            </div>
            <div class="row mt-4 mb-2 border-bottom">
                <div class="col-md-12" id="co-out">
                    <h5 class="mb-0">{{ $helper->results['name'] }} Overall Report</h5>
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
                                <div class="col-md-8"><p>Courses Evaluated</p></div>
                                <div class="col-md text-right"><p>{{ $helper->results['course_count'] }}</p></div>
                            </div>
                            <div class="row border-bottom">
                                <div class="col-md-8"><p>Course-Sections Evaluated</p></div>
                                <div class="col-md text-right"><p>{{ $helper->results['section_count'] }}</p></div>
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
                                <div class="col-md text-right"><p>{{ $helper->results['students'] }}</p></div>
                            </div>
                            <div class="row border-bottom">
                                <div class="col-md-8"><p>Course-Student Repondents</p></div>
                                <div class="col-md text-right"><p>{{ $helper->results['respondents'] }}</p></div>
                            </div>
                            <div class="row border-bottom">
                                <div class="col-md-8"><p>Respondent-Registration ratio</p></div>
                                <div class="col-md text-right"><p>{{ round($helper->results['respondents'] / $helper->results['students'], 2) }}</p></div>
                            </div>
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
                                <th scope="col"><p class="text-center">Percentile</p></th>
                                <th scope="col"><p class="text-center">Dept Highest</p></th>
                                <th scope="col"><p class="text-center">University Highest</p></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><p><b>Lecture Quality</b></p></td>
                                <td><p class="text-center">{{ $helper->results['cats']['lq'] }}</p></td>
                                <td><p class="text-center">{{ $helper->results['overall']['percentiles']['lq'] }}</p></td>
                                <td><p class="text-center">{{ $helper->results['overall']['deptCourseHighests']['lq'] }}</p></td>
                                <td><p class="text-center">{{ $helper->results['overall']['uniCourseHighests']['lq'] }}</p></td>
                            </tr>
                            <tr>
                                <td><p><b>Course Quality</b></p></td>
                                <td><p class="text-center">{{ $helper->results['cats']['cq'] }}</p></td>
                                <td><p class="text-center">{{ $helper->results['overall']['percentiles']['cq'] }}</p></td>
                                <td><p class="text-center">{{ $helper->results['overall']['deptCourseHighests']['cq'] }}</p></td>
                                <td><p class="text-center">{{ $helper->results['overall']['uniCourseHighests']['cq'] }}</p></td>
                            </tr>
                            <tr>                                
                                <td><p><b>Lecture Effort</b></p></td>
                                <td><p class="text-center">{{ $helper->results['cats']['le'] }}</p></td>
                                <td><p class="text-center">{{ $helper->results['overall']['percentiles']['le'] }}</p></td>
                                <td><p class="text-center">{{ $helper->results['overall']['deptCourseHighests']['le'] }}</p></td>
                                <td><p class="text-center">{{ $helper->results['overall']['uniCourseHighests']['le'] }}</p></td>
                            </tr>
                            <tr>                                
                                <td><p><b>Assessment Effort</b></p></td>
                                <td><p class="text-center">{{ $helper->results['cats']['ae'] }}</p></td>
                                <td><p class="text-center">{{ $helper->results['overall']['percentiles']['ae'] }}</p></td>
                                <td><p class="text-center">{{ $helper->results['overall']['deptCourseHighests']['ae'] }}</p></td>
                                <td><p class="text-center">{{ $helper->results['overall']['uniCourseHighests']['ae'] }}</p></td>
                            </tr>
                            <tr>                                
                                <td><p><b>Learning Experince Effort</b></p></td>
                                <td><p class="text-center">{{ $helper->results['cats']['lx'] }}</p></td>
                                <td><p class="text-center">{{ $helper->results['overall']['percentiles']['lx'] }}</p></td>
                                <td><p class="text-center">{{ $helper->results['overall']['deptCourseHighests']['lx'] }}</p></td>
                                <td><p class="text-center">{{ $helper->results['overall']['uniCourseHighests']['lx'] }}</p></td>
                            </tr>
                            <tr>                                
                                <td><p><b>Student pressure factor</b></p></td>
                                <td><p class="text-center">{{ $helper->results['cats']['sp'] }}</p></td>
                                <td><p class="text-center">{{ $helper->results['overall']['percentiles']['sp'] }}</p></td>
                                <td><p class="text-center">{{ $helper->results['overall']['deptCourseHighests']['sp'] }}</p></td>
                                <td><p class="text-center">{{ $helper->results['overall']['uniCourseHighests']['sp'] }}</p></td>
                            </tr>
                            <tr>                                
                                <td><p><b>Course Administration</b></p></td>
                                <td><p class="text-center">{{ $helper->results['cats']['ca'] }}</p></td>
                                <td><p class="text-center">{{ $helper->results['overall']['percentiles']['ca'] }}</p></td>
                                <td><p class="text-center">{{ $helper->results['overall']['deptCourseHighests']['ca'] }}</p></td>
                                <td><p class="text-center">{{ $helper->results['overall']['uniCourseHighests']['ca'] }}</p></td>
                            </tr>
                            <tr>                                
                                <td><p><b>Technical Aptitude</b></p></td>
                                <td><p class="text-center">{{ $helper->results['cats']['ta'] }}</p></td>
                                <td><p class="text-center">{{ $helper->results['overall']['percentiles']['ta'] }}</p></td>
                                <td><p class="text-center">{{ $helper->results['overall']['deptCourseHighests']['ta'] }}</p></td>
                                <td><p class="text-center">{{ $helper->results['overall']['uniCourseHighests']['ta'] }}</p></td>
                            </tr>
                            <tr>                                
                                <td><p><b>Course Rating</b></p></td>
                                <td><p class="text-center">{{ $helper->results['cats']['cr'] }}</p></td>
                                <td><p class="text-center">{{ $helper->results['overall']['percentiles']['cr'] }}</p></td>
                                <td><p class="text-center">{{ $helper->results['overall']['deptCourseHighests']['cr'] }}</p></td>
                                <td><p class="text-center">{{ $helper->results['overall']['uniCourseHighests']['cr'] }}</p></td>
                            </tr>
                            <tr>                                
                                <td><p><b>Excellence Indicator</b></p></td>
                                <td><p class="text-center">{{ $helper->results['cats']['ei'] }}</p></td>
                                <td><p class="text-center">{{ $helper->results['overall']['percentiles']['ei'] }}</p></td>
                                <td><p class="text-center">{{ $helper->results['overall']['deptCourseHighests']['ei'] }}</p></td>
                                <td><p class="text-center">{{ $helper->results['overall']['uniCourseHighests']['ei'] }}</p></td>
                            </tr>
                            <tr>                                
                                <td><p><b>Irresponsibility Indicator</b></p></td>
                                <td><p class="text-center">{{ $helper->results['cats']['ii'] }}</p></td>
                                <td><p class="text-center">{{ $helper->results['overall']['percentiles']['ii'] }}</p></td>
                                <td><p class="text-center">{{ $helper->results['overall']['deptCourseHighests']['ii'] }}</p></td>
                                <td><p class="text-center">{{ $helper->results['overall']['uniCourseHighests']['ii'] }}</p></td>
                            </tr>
                            <tr>                                
                                <td><p><b>Lab Rating</b></p></td>
                                <td><p class="text-center">{{ is_null($helper->results['cats']['lr']) ? '---' : $helper->results['cats']['lr'] }}</p></td>
                                <td><p class="text-center">{{ is_null($helper->results['overall']['percentiles']['lr']) ? '---' : $helper->results['overall']['percentiles']['lr'] }}</p></td>
                                <td><p class="text-center">{{ is_null($helper->results['overall']['deptCourseHighests']['lr']) ? '---' : $helper->results['overall']['deptCourseHighests']['lr'] }}</p></td>
                                <td><p class="text-center">{{ is_null($helper->results['overall']['uniCourseHighests']['lr']) ? '---' : $helper->results['overall']['uniCourseHighests']['lr'] }}</p></td>
                            </tr>
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
                                <th scope="col"><p class="text-center">Lowest Scoring Courses</p></th>
                                <th scope="col"><p class="text-center">Highest Scoring Courses</p></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><p><b>Lecture Quality</b></p></td>
                                <td><p class="text-center">{{ $helper->results['lowest']['lq'] }}</p></td>
                                <td><p class="text-center">{{ $helper->results['highest']['lq'] }}</p></td>
                            </tr>
                            <tr>
                                <td><p><b>Course Quality</b></p></td>
                                <td><p class="text-center">{{ $helper->results['lowest']['cq'] }}</p></td>
                                <td><p class="text-center">{{ $helper->results['highest']['cq'] }}</p></td>
                            </tr>
                            <tr>                                
                                <td><p><b>Lecture Effort</b></p></td>
                                <td><p class="text-center">{{ $helper->results['lowest']['le'] }}</p></td>
                                <td><p class="text-center">{{ $helper->results['highest']['le'] }}</p></td>
                            </tr>
                            <tr>                                
                                <td><p><b>Assessment Effort</b></p></td>
                                <td><p class="text-center">{{ $helper->results['lowest']['ae'] }}</p></td>
                                <td><p class="text-center">{{ $helper->results['highest']['ae'] }}</p></td>
                            </tr>
                            <tr>                                
                                <td><p><b>Learning Experince Effort</b></p></td>
                                <td><p class="text-center">{{ $helper->results['lowest']['lx'] }}</p></td>
                                <td><p class="text-center">{{ $helper->results['highest']['lx'] }}</p></td>
                            </tr>
                            <tr>                                
                                <td><p><b>Student pressure factor</b></p></td>
                                <td><p class="text-center">{{ $helper->results['lowest']['sp'] }}</p></td>
                                <td><p class="text-center">{{ $helper->results['highest']['sp'] }}</p></td>
                            </tr>
                            <tr>                                
                                <td><p><b>Course Administration</b></p></td>
                                <td><p class="text-center">{{ $helper->results['lowest']['ca'] }}</p></td>
                                <td><p class="text-center">{{ $helper->results['highest']['ca'] }}</p></td>
                            </tr>
                            <tr>                                
                                <td><p><b>Technical Aptitude</b></p></td>
                                <td><p class="text-center">{{ $helper->results['lowest']['ta'] }}</p></td>
                                <td><p class="text-center">{{ $helper->results['highest']['ta'] }}</p></td>
                            </tr>
                            <tr>                                
                                <td><p><b>Course Rating</b></p></td>
                                <td><p class="text-center">{{ $helper->results['lowest']['cr'] }}</p></td>
                                <td><p class="text-center">{{ $helper->results['highest']['cr'] }}</p></td>
                            </tr>
                            <tr>                                
                                <td><p><b>Excellence Indicator</b></p></td>
                                <td><p class="text-center">{{ $helper->results['lowest']['ei'] }}</p></td>
                                <td><p class="text-center">{{ $helper->results['highest']['ei'] }}</p></td>
                            </tr>
                            <tr>                                
                                <td><p><b>Irresponsibility Indicator</b></p></td>
                                <td><p class="text-center">{{ $helper->results['lowest']['ii'] }}</p></td>
                                <td><p class="text-center">{{ $helper->results['highest']['ii'] }}</p></td>
                            </tr>
                            <tr>                                
                                <td><p><b>Lab Rating</b></p></td>
                                <td><p class="text-center">{{ strlen($helper->results['lowest']['lr']) == 0 ? '---' : $helper->results['lowest']['lr'] }}</p></td>
                                <td><p class="text-center">{{ strlen($helper->results['highest']['lr']) == 0 ? '---' : $helper->results['highest']['lr'] }}</p></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <button class="btn btn-danger d-print-none" id="print-btn" onclick="window.print()">Print Report</button>
    </body>
</html>