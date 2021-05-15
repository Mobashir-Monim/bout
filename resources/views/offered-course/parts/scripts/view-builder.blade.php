<script>
    const tempIDHolder = document.getElementById('temp-id-holder');

    const buildHeaderSection = (details) => {
        return `
            <h5 class="border-bottom mb-0">
                ${ details.code } : ${ details.title }
                ${ details.coordinator.has_evaluation ? 
                    `<i class="far fa-check-circle" style="color: rgba(0,255,0,1)"></i>` :
                    `<i class="far fa-times-circle" style="color: rgba(255,0,0,1)"></i>`
                }
            </h5>
            <p class="mb-3">${ details.provider }</p>
            <div class="row">
                ${ setCoordinatorDetails(details) }
                ${ setOfferedIDDetails(details) }
            </div>

            ${ buildSections(details) }
        `;
    }

    const setCoordinatorDetails = (details) => {
        return `
            <div class="col-md-6">
                <div class="row">
                    <div class="col-md-12">
                        <input type="text" name="" id="${ details.id }-coordinator-name" placeholder="Coordinator Name" class="form-control my-2" value="${ details.coordinator.name }">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <input type="text" name="" id="${ details.id }-coordinator-email" placeholder="Coordinator Email" class="form-control my-2" value="${ details.coordinator.email }">
                    </div>
                </div>
                <div class="row">
                    <div class="col-8 my-auto">
                        <input type="text" name="" id="${ details.id }-coordinator-initials" placeholder="Coordinator Initials" class="form-control my-2" value="${ details.coordinator.initials }">
                    </div>
                    <div class="col-4 my-auto">
                        <button class="btn btn-dark w-100" type="button" onclick="updateListItem('${ details.id }', 'course')"><i class="far fa-save"></i></button>
                    </div>
                </div>
            </div>
        `;
    }

    const setOfferedIDDetails = (details) => {
        return `
            <div class="col-md-6">   
                <div class="row">
                    <div class="col-3 my-auto">
                        Offered ID:
                    </div>
                    <div class="col-9">
                        <p onclick="copyText('offered-id-${ details.id }')" class="mb-0">
                            <input type="text" class="form-control my-2" readonly id="offered-id-${ details.id }" value="${ details.id }">
                        </p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-3 my-auto">
                        Course ID:
                    </div>
                    <div class="col-9">
                        <p onclick="copyText('course-id-${ details.course_id }')" class="mb-0">
                            <input type="text" class="form-control my-2" readonly id="course-id-${ details.course_id }" value="${ details.course_id }">
                        </p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-9">
                        <input type="text" id="${ details.id }-offered-copy" placeholder="Copy Evaluation from" class="form-control my-2">
                    </div>
                    <div class="col-3 my-auto">
                        <button class="btn btn-dark w-100" type="button" onclick="copyEvaluation('${ details.id }', 'course')"><i class="far fa-copy"></i></i></button>
                    </div>
                </div>
            </div>
        `;
    }

    const buildSections = (details) => {
        let sections = '';

        for (let s in details.sections) {
            for (let type in details.sections[s]) {
                if (details.sections[s][type].length > 0) {
                    sections = `
                        ${ sections }
                        <div class="row">
                            <div class="col-md-12 my-2">
                                <h5 class="border-bottom mb-0">
                                    Section ${ s } ${ type == 'theory' ? 'Theory' : 'Lab' } Instructor(s)
                                </h5>
                                ${ buildSectionInstructors(details.sections[s][type]) }
                            </div>
                        </div>
                    `;
                }
            }
        }

        return sections;
    }

    const buildSectionInstructors = (instructors) => {
        let instructorCont = '<div class="row">';

        for (let i in instructors) {
            instructorCont = `
                ${ instructorCont }
                <div class="col-md-6 my-2" id="${ instructors[i].id }-section">
                    <div class="card">
                        <div class="card-body bg-light">
                            <input type="text" name="" id="${ instructors[i].id }-instructor-name" placeholder="Instructor Name" class="form-control my-2" value="${ instructors[i].name }">
                            <input type="text" name="" id="${ instructors[i].id }-instructor-email" placeholder="Instrcutor Email" class="form-control my-2" value="${ instructors[i].email }">
                            <div class="row">
                                <div class="col-md-8">
                                    <input type="text" name="" id="${ instructors[i].id }-instructor-initials" placeholder="Instructor Initials" class="form-control my-2" value="${ instructors[i].initials }">
                                </div>
                                <div class="col-md-4 my-auto">
                                    <button class="btn btn-dark w-100" type="button" onclick="updateListItem('${ instructors[i].id }', 'section')"><i class="far fa-save"></i></button>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-8">
                                    <p onclick="copyText('${ instructors[i].id }-section-id')" class="mb-0">
                                        <input type="text" name="" id="${ instructors[i].id }-section-id" class="form-control my-2" readonly value="${ instructors[i].id }">
                                    </p>
                                </div>
                                <div class="col-md-2 col-4 my-auto text-right">
                                    <button class="btn btn-dark w-100" type="button" onclick="deletePart('${ instructors[i].id }', 'section')"><span class="material-icons-outlined" style="font-size: 1em">delete</span></button>
                                </div>
                                <div class="col-md-2 col-4 my-auto text-right">
                                    ${ instructors[i].has_evaluation ? 
                                        `<i class="far fa-check-circle" style="color: rgba(0,255,0,1); font-size: 1.5em"></i>` :
                                        `<i class="far fa-times-circle" style="color: rgba(255,0,0,1); font-size: 1.5em"></i>`
                                    }
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-8">
                                    <input type="text" name="" id="${ instructors[i].id }-section-copy" placeholder="Copy Evaluation From" class="form-control my-2">
                                </div>
                                <div class="col-md-4 my-auto">
                                    <button class="btn btn-dark w-100" type="button" onclick="copyEvaluation('${ instructors[i].id }', 'section')"><i class="far fa-copy"></i></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            `;
        }

        return `${ instructorCont }</div>`;
    }

    const copyText = (copyTarget) => {
        let target = document.getElementById(copyTarget);
        target.select();
        document.execCommand('copy');
    }
</script>