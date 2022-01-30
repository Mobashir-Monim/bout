<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://fonts.googleapis.com/css2?family=Nunito:ital,wght@0,400;0,700;1,400&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
        <link rel="stylesheet" href="/css/report.css">
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Outlined" rel="stylesheet">
        <title>Evaluation Report for {{ $helper->dept . " - " .  $helper->year . " " . $helper->semester }}</title>
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
                    <h5 class="mb-0">{{ $helper->dept }} Overall Report</h5>
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
                                <div class="col-md text-right"><p>{{ $helper->report['courseCount'] }}</p></div>
                            </div>
                            <div class="row border-bottom">
                                <div class="col-md-8"><p>Course-Sections Evaluated</p></div>
                                <div class="col-md text-right"><p>{{ $helper->report['sectionCount'] }}</p></div>
                            </div>
                            <div class="row border-bottom">
                                <div class="col-md-8"><p>Lab-Sections Evaluated</p></div>
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
                                        <td colspan="10" class="py-1">The arbitrary score received by the departments/schools/institutions for given assessment item</td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" class="py-1">Percentile</td>
                                        <td colspan="10" class="py-1">The percentile rank in comparision to all departments/schools/institutions for given assessment item</td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" class="py-1">Dept Highest</td>
                                        <td colspan="10" class="py-1">The highest arbitrary score amongst all the courses of the departments/schools/institutions for given assessment item</td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" class="py-1">University Highest</td>
                                        <td colspan="10" class="py-1">The highest arbitrary score amongst all the courses university wide for given assessment item</td>
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
                                <th scope="col"><p class="text-center">Percentile</p></th>
                                <th scope="col"><p class="text-center">Dept Highest</p></th>
                                <th scope="col"><p class="text-center">University Highest</p></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($helper->factors as $key => $factor)
                                <tr>
                                    <td><p><b>[ <i class="text-primary">{{ $key }}</i> ] {{ $factor['name'] }}</b></p></td>
                                    <td><p class="text-center">{{ !array_key_exists($key, $helper->report['cats']) ? '---' : $helper->report['cats'][$key] }}</p></td>
                                    <td><p class="text-center">{{ !array_key_exists($key, $helper->report['overall']['percentiles']) ? '---' : $helper->report['overall']['percentiles'][$key] }}</p></td>
                                    <td><p class="text-center">{{ !array_key_exists($key, $helper->report['overall']['deptCourseHighests']) ? '---' : $helper->report['overall']['deptCourseHighests'][$key] }}</p></td>
                                    <td><p class="text-center">{{ !array_key_exists($key, $helper->report['overall']['uniCourseHighests']) ? '---' : $helper->report['overall']['uniCourseHighests'][$key] }}</p></td>
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
                                <th scope="col"><p class="text-center">Lowest Scoring Courses</p></th>
                                <th scope="col"><p class="text-center">Highest Scoring Courses</p></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><p><b>Lecture Quality</b></p></td>
                                <td><p class="text-center">{{ $helper->report['lowest']['lq'] }}</p></td>
                                <td><p class="text-center">{{ $helper->report['highest']['lq'] }}</p></td>
                            </tr>
                            <tr>
                                <td><p><b>Course Quality</b></p></td>
                                <td><p class="text-center">{{ $helper->report['lowest']['cq'] }}</p></td>
                                <td><p class="text-center">{{ $helper->report['highest']['cq'] }}</p></td>
                            </tr>
                            <tr>                                
                                <td><p><b>Lecture Effort</b></p></td>
                                <td><p class="text-center">{{ $helper->report['lowest']['le'] }}</p></td>
                                <td><p class="text-center">{{ $helper->report['highest']['le'] }}</p></td>
                            </tr>
                            <tr>                                
                                <td><p><b>Assessment Effort</b></p></td>
                                <td><p class="text-center">{{ $helper->report['lowest']['ae'] }}</p></td>
                                <td><p class="text-center">{{ $helper->report['highest']['ae'] }}</p></td>
                            </tr>
                            <tr>                                
                                <td><p><b>Learning Experince Effort</b></p></td>
                                <td><p class="text-center">{{ $helper->report['lowest']['lx'] }}</p></td>
                                <td><p class="text-center">{{ $helper->report['highest']['lx'] }}</p></td>
                            </tr>
                            <tr>                                
                                <td><p><b>Student pressure factor</b></p></td>
                                <td><p class="text-center">{{ $helper->report['lowest']['sp'] }}</p></td>
                                <td><p class="text-center">{{ $helper->report['highest']['sp'] }}</p></td>
                            </tr>
                            <tr>                                
                                <td><p><b>Course Administration</b></p></td>
                                <td><p class="text-center">{{ $helper->report['lowest']['ca'] }}</p></td>
                                <td><p class="text-center">{{ $helper->report['highest']['ca'] }}</p></td>
                            </tr>
                            <tr>                                
                                <td><p><b>Technical Aptitude</b></p></td>
                                <td><p class="text-center">{{ $helper->report['lowest']['ta'] }}</p></td>
                                <td><p class="text-center">{{ $helper->report['highest']['ta'] }}</p></td>
                            </tr>
                            <tr>                                
                                <td><p><b>Course Rating</b></p></td>
                                <td><p class="text-center">{{ $helper->report['lowest']['cr'] }}</p></td>
                                <td><p class="text-center">{{ $helper->report['highest']['cr'] }}</p></td>
                            </tr>
                            <tr>                                
                                <td><p><b>Excellence Indicator</b></p></td>
                                <td><p class="text-center">{{ $helper->report['lowest']['ei'] }}</p></td>
                                <td><p class="text-center">{{ $helper->report['highest']['ei'] }}</p></td>
                            </tr>
                            <tr>                                
                                <td><p><b>Irresponsibility Indicator</b></p></td>
                                <td><p class="text-center">{{ $helper->report['lowest']['ii'] }}</p></td>
                                <td><p class="text-center">{{ $helper->report['highest']['ii'] }}</p></td>
                            </tr>
                            <tr>                                
                                <td><p><b>Lab Rating</b></p></td>
                                <td><p class="text-center">{{ strlen($helper->report['lowest']['lr']) == 0 ? '---' : $helper->report['lowest']['lr'] }}</p></td>
                                <td><p class="text-center">{{ strlen($helper->report['highest']['lr']) == 0 ? '---' : $helper->report['highest']['lr'] }}</p></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <hr>

            <div class="row d-print-none mb-4">
                <div class="col-md-6 my-1">
                    <input type="text" class="form-control" id="filter-text" placeholder="Search using faculty email address or name">
                </div>
                <div class="col-md-4 my-1">
                    <select class="form-control" id="filter-type" onchange="setFilterType()">
                        <option value="faculty">Faculty</option>
                        <option value="lab">Labs Only</option>
                        <option value="theory">Theory Only</option>
                        <option value="code">Course Code</option>
                    </select>
                </div>
                <div class="col-md-2 my-1">
                    <button class="btn btn-dark w-100" type="button" onclick="setFilterType(true)"><span class="material-icons-outlined" style="font-size: 1em">search</span></button>
                </div>
            </div>
            
            <hr class="pb">

            <div class="row">
                <div class="col-md-12 mb-4">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th scope="row"><p class="text-center">Faculty</p></th>
                                <th scope="row"><p class="text-center">Course</p></th>
                                <th scope="row"><p class="text-center">Section</p></th>
                                <th scope="row"><p class="text-center">Respondents</p></th>
                                <th scope="row"><p class="text-center">Students</p></th>
                                <th scope="row"><p class="text-center">Score</p></th>
                            </tr>
                        </thead>
                        <tbody id="faculty-info">
                            {{-- <tr>
                                <td><p>Faculty</p></td>
                                <td><p>Course</p></td>
                                <td><p>Section</p></td>
                                <td><p>Respondents</p></td>
                                <td><p>Students</p></td>
                                <td><p>Score</p></td>
                            </tr> --}}
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <button class="btn btn-danger d-print-none" id="print-btn" onclick="window.print()">Print Report</button>
        <script src="https://cdn.jsdelivr.net/npm/mathjs@9.3.2/lib/browser/math.min.js"></script>
        <script>
            const courseSectionData = {!! json_encode($helper->report['course_section_data']) !!};
            const facultyInfo = document.getElementById('faculty-info');
            const filterText = document.getElementById('filter-text');
            const filterType = document.getElementById('filter-type');
            let factorsMatrix = {!! $helper->getFactorVals() !!};
            let theoryComputeExpression = `{!! preg_replace( "/\r|\n/", "", $helper->getScoreExpression('theory') ) !!}`;
            let labComputeExpression = `{!! preg_replace( "/\r|\n/", "", $helper->getScoreExpression('lab') ) !!}`;

            window.onload = () => {
                setTable(courseSectionData);
            }

            const setTable = dataRows => {
                let count = 0;
                facultyInfo.innerHTML = '';
                dataRows.forEach(row => {
                    let eval = getEvalVals(row.evaluation, row.is_lab);

                    setTimeout(() => {
                        facultyInfo.innerHTML += `
                            <tr>
                                <th scope="row"><p class="text-center">${ row.name }<br>${ row.email }</p></th>
                                <td><p class="text-center">${ row.code }</p></td>
                                <td><p class="text-center">${ row.section }<br>(${ row.is_lab ? 'Lab' : 'Theory' })</p></td>
                                <td><p class="text-center">${ eval.respondents }</p></td>
                                <td><p class="text-center">${ eval.students }</p></td>
                                <td><p class="text-center">${ eval.score }</p></td>
                            </tr>
                        `;
                        count += 1;
                        console.log(count)
                    }, 100);
                });
            }

            const getEvalVals = (eval, is_lab) => {
                if (eval == null) {
                    return {
                        respondents: 0,
                        students: '??',
                        score: 'N/A'
                    };
                } else {
                    let computeExpression = is_lab ? labComputeExpression : theoryComputeExpression;

                    return {
                        respondents: eval.respondents,
                        students: eval.hasOwnProperty('students') ? eval.students : '??',
                        score: getScore(eval.cats, computeExpression)
                    };
                }
            }
            
            const getScore = (cats, computeExpression) => {
                if (computeExpression == null || computeExpression == '') {
                    return 'No formula set'
                } else {
                    try {
                        let finalScore = math.evaluate(unmarkExpression(computeExpression), buildScope(cats, computeExpression));
                        finalScore = typeof(finalScore) != 'object' ? finalScore.toFixed(2) : finalScore.entries[0].toFixed(2);
                        return finalScore;
                    } catch (error) {
                        return 'Error in formula, please correct it!';
                    }
                }
            }

            const unmarkExpression = (exp) => {
                return exp.replaceAll('$', '');
            }

            const buildScope = (cats, computeExpression) => {
                let scope = {};

                for (let f in factorsMatrix) {
                    if (computeExpression.includes(`$${ f }$`)) {
                        if (cats.hasOwnProperty(f)) {
                            scope[f] = cats[f];
                        } else {
                            scope[f] = 0;
                        }
                    }
                }

                return scope;
            }

            const setFilterType = (filterBtnClicked = false) => {
                if (filterType.value == 'lab') {
                    filterBySectionType(true);
                } else if (filterType.value == 'theory') {
                    filterBySectionType(false);
                } else if (filterType.value == 'faculty') {
                    filterByFaculty(filterBtnClicked);
                } else {
                    filterByCourse(filterBtnClicked);
                }
            }

            const filterBySectionType = type => {
                filterText.disabled = true;
                filterText.placeholder = 'Filtered Automatically';
                filterText.value = '';

                if (!filterText.classList.contains('disabled')) {
                    filterText.classList.add('disabled');
                }

                setTable(courseSectionData.filter(x => x.is_lab == type));
            }

            const filterByFaculty = filterBtnClicked => {
                filterText.disabled = false;
                filterText.placeholder = 'Search using faculty email address or name';

                if (!filterText.classList.contains('disabled')) {
                    filterText.classList.add('disabled');
                }

                if (filterBtnClicked) {
                    setTable(courseSectionData.filter(x => {
                        return x.name.toLowerCase().includes(filterText.value.toLowerCase())
                        || x.email.toLowerCase().includes(filterText.value.toLowerCase());
                    }));
                }
            }

            const filterByCourse = filterBtnClicked => {
                filterText.disabled = false;
                filterText.placeholder = 'Search using course code';

                if (!filterText.classList.contains('disabled')) {
                    filterText.classList.add('disabled');
                }

                if (filterBtnClicked) {
                    setTable(courseSectionData.filter(x => {
                        return x.code.toLowerCase().includes(filterText.value.toLowerCase());
                    }));
                }
            }
        </script>
    </body>
</html>