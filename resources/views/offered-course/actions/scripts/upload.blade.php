<script>
    let fileInput = document.getElementById('file');
    let uploaded = {};
    let diffTable = {};
    const uploadDept = document.getElementById('upload-dept');
    const uploadSpinner = document.getElementById('upload-spinner');

    $("#uploader").click(function(){
        if (uploadDept.value != "") {
            if (file.value != "") {
                uploadSpinner.classList.remove('hidden');
                console.log('Reading File');
                readFile();
            } else {
                alert("Please select the file containing the offered course data");
            }
        } else {
            alert("Please select a department before trying to uplaod the offered course data");
        }
    });

    const readFile = () => {
        uploaded = {};
        
        setTimeout(() => {
            let reader = new FileReader();

            reader.onload = function () {
                exelToJSON(reader.result);
            };

            reader.readAsBinaryString(fileInput.files[0]);
        }, 100);
    };

    const exelToJSON = data => {
        let cfb = XLSX.read(data, {type: 'binary'});
            
        cfb.SheetNames.forEach(function(sheetName) {   
            let oJS = XLS.utils.sheet_to_json(cfb.Sheets[sheetName], {defval: ""});

            for (let index = 0; index < oJS.length; index++) {
                keyCheck(uploaded, oJS[index].department, {});
                keyCheck(uploaded[oJS[index].department], oJS[index].code, {});
                keyCheck(uploaded[oJS[index].department][oJS[index].code], 'sections', {});
                setCourseDetails(oJS, index);
                compileFaculty(oJS[index]);
            }
        });

        console.log('Building DiffTable');
        createDiffObject();
    }

    const createDiffObject = () => {
        diffTable = {};
        let dept = Object.keys(uploaded)[0];

        for (let c in uploaded[dept]) {
            keyCheck(diffTable, c, courseCheck(dept, c));

            for (let s in uploaded[dept][c].sections) {
                sectionCheck(dept, c, s).forEach(block => {
                    diffTable[c].sections.push(block);
                });
            }
        }

        markDeletes(dept);
        console.log('Uploading changes');
        performChanges();
    }

    const markDeletes = (dept) => {
        for (let c in offeredCourses[dept]) {
            if (!diffTable.hasOwnProperty(c)) {
                markCourseForDeletion(c, offeredCourses[dept][c].id);
            } else {
                for (let s in offeredCourses[dept][c].sections) {
                    ['theory', 'lab'].forEach(type => {
                        if (offeredCourses[dept][c].sections[s].hasOwnProperty(type)) {
                            offeredCourses[dept][c].sections[s][type].forEach(part => {
                                if (diffTable[c].sections.
                                    filter(fac => {return fac.mode == 'none' || fac.mode == 'update'}).
                                    filter(fac => { return fac.details.id == part.id }).length == 0
                                ) {
                                    markSectionForDeletion(c, s, part.id);
                                }
                            });
                        }
                    })
                }
            }
        }
    }

    const setCourseDetails = (row, i) => {
        uploaded[row[i].department][row[i].code].has_lab = row[i].lab_faculty_email != "";
        uploaded[row[i].department][row[i].code].is_lab = row[i].theory_faculty_email == "";
        uploaded[row[i].department][row[i].code].title = row[i].title;
        uploaded[row[i].department][row[i].code].coordinator = row[i].coordinator_faculty_name;
        uploaded[row[i].department][row[i].code].initials = row[i].coordinator_faculty_initials;
        uploaded[row[i].department][row[i].code].email = row[i].coordinator_faculty_email;
    }

    const keyCheck = (cont, key, defVal) => {
        if (!cont.hasOwnProperty(key)) {
            cont[key] = defVal;
        }
    }

    const compileFaculty = row => {
        keyCheck(uploaded[row.department][row.code].sections, row.section, {});

        if (uploaded[row.department][row.code].is_lab || uploaded[row.department][row.code].has_lab) {
            uploaded[row.department][row.code].sections[row.section].lab = extractFaculty(row, 'lab');
        }

        if (!uploaded[row.department][row.code].is_lab) {
            uploaded[row.department][row.code].sections[row.section].theory = extractFaculty(row, 'theory');
        }
    }

    const extractFaculty = (row, type) => {
        let faculty = [];
        let names = row[`${ type }_faculty_name`].trim().replaceAll(/\s\s+/g, ' ').replaceAll(", ", ",").split(',');
        let initials = row[`${ type }_faculty_initials`].replaceAll(/\s\s+/g, ' ').replaceAll(", ", ",").split(',');
        let emails = row[`${ type }_faculty_email`].replaceAll(/\s\s+/g, ' ').replaceAll(", ", ",").split(',');
        let lim = Math.max(names.length, initials.length, emails.length);

        for (let i = 0; i < lim; i++) {
            faculty.push({
                name: lim == names.length ? names[i].trim() : " ",
                initials: lim == initials.length ? initials[i].trim() : " ",
                email: lim == emails.length ? emails[i].trim() : " ",
            });
        }

        return faculty;
    }

    const courseCheck = (dept, c) => {
        let createable = !offeredCourses.hasOwnProperty(dept) ? true : !offeredCourses[dept].hasOwnProperty(c);

        if (createable) {
            return {mode: 'create', details: getCourseDetails(uploaded[dept][c], dept, c), sections: []};
        } else {
            if (courseIsUpdateable(dept, c)) {
                return {mode: 'update', details: getCourseDetails(uploaded[dept][c], dept, c, offeredCourses[dept][c].id), sections: []};
            } else {
                return {mode: 'none', details: getCourseDetails(uploaded[dept][c], dept, c, offeredCourses[dept][c].id), sections: []};
            }
        }
    }

    const courseIsUpdateable = (dept, c) => {
        return offeredCourses[dept][c].title != uploaded[dept][c].title ||
            offeredCourses[dept][c].has_lab != uploaded[dept][c].has_lab ||
            offeredCourses[dept][c].is_lab != uploaded[dept][c].is_lab ||
            offeredCourses[dept][c].coordinator != uploaded[dept][c].coordinator ||
            offeredCourses[dept][c].initials != uploaded[dept][c].initials ||
            offeredCourses[dept][c].email != uploaded[dept][c].email;
    }

    const getCourseDetails = (cont, dept, code, id = null) => {
        return {
            code: code,
            provider: dept,
            title: cont.title,
            coordinator: cont.coordinator,
            initials: cont.initials,
            email: cont.email,
            has_lab: cont.has_lab,
            is_lab: cont.is_lab,
            id: id,
        };
    }

    const sectionCheck = (dept, c, s) => {
        let results = [];

        if (uploaded[dept][c].has_lab || uploaded[dept][c].is_lab) {
            buildSectionBlocks(dept, c, s, 'lab', results);
        }

        if (!uploaded[dept][c].is_lab) {
            buildSectionBlocks(dept, c, s, 'theory', results);
        }

        return results;
    }

    const buildSectionBlocks = (dept, c, s, type, results) => {
        if (uploaded[dept][c].sections[s].hasOwnProperty(type)) {
            for (let i = 0; i < uploaded[dept][c].sections[s][type].length; i++) {
                let createable = diffTable[c].mode == 'create' ? true : !offeredCourses[dept][c].sections.hasOwnProperty(s);
                createable = createable ? true : !offeredCourses[dept][c].sections[s].hasOwnProperty(type);
                createable = createable ? true : offeredCourses[dept][c].sections[s][type].length - 1 < i;

                if (createable) {
                    results.push({mode: 'create', details: getSectionDetails(uploaded[dept][c].sections[s], s, type, i)});
                } else if (sectionIsUpdateable(dept, c, s, type, i)) {
                    results.push({mode: 'update', details: getSectionDetails(uploaded[dept][c].sections[s], s, type, i, offeredCourses[dept][c].sections[s][type][i].id)})
                } else {
                    results.push({mode: 'none', details: getSectionDetails(uploaded[dept][c].sections[s], s, type, i, offeredCourses[dept][c].sections[s][type][i].id)});
                }
            }
        } else {
            alert(`Error in file!!! ${ c } is defined to have ${ type }, but no ${ type } faculty record found in file. Press "OK" to continue`);
        }
    }

    const sectionIsUpdateable = (dept, c, s, type, i) => {
        if (offeredCourses[dept][c].sections[s].hasOwnProperty(type)) {
            return offeredCourses[dept][c].sections[s][type][i].name != uploaded[dept][c].sections[s][type][i].name ||
                offeredCourses[dept][c].sections[s][type][i].initials != uploaded[dept][c].sections[s][type][i].initials ||
                offeredCourses[dept][c].sections[s][type][i].email != uploaded[dept][c].sections[s][type][i].email;
        } else {
            return true;
        }
    }

    const getSectionDetails = (cont, section, type, index, id = null) => {
        return {
            section: section,
            name: cont[type][index].name,
            initials: cont[type][index].initials,
            email: cont[type][index].email,
            is_lab_faculty: type == 'lab',
            id: id,
        };
    }

    const markCourseForDeletion = (c, id) => {
        keyCheck(diffTable, c, {mode: 'delete', id: id});
    }

    const markSectionForDeletion = (c, s, id) => {
        diffTable[c].sections.push({mode: 'delete', id: id});
    }

    const performChanges = () => {
        let changeable = performCourseChanges();
        let flag = 'course'
        
        if (changeable === undefined) {
            flag = 'section';
            changeable = performSectionChanges();
        }

        if (changeable !== undefined) {
            if (changeable.type == 'create') {
                creator(flag, changeable.details);
            } else if (changeable.type == 'update') {
                updator(flag, changeable.details);
            } else if (changeable.type == 'delete') {
                deletor(flag, changeable.details);
            }
        } else {
            uploadSpinner.classList.add('hidden');
            refreshPage();
        }
    }

    const performCourseChanges = () => {
        let changeable = {type: false, details: null}
        let types = ['create', 'update', 'delete'];

        for (let i = 0; i < types.length; i++) {
            let changeables = Object.filter(diffTable, 'mode', types[i]);
            let keys = Object.keys(changeables);

            if (keys.length != 0) {
                changeable.type = types[i];
                changeable.details = types[i] == 'delete' ? {code: keys[0], id: changeables[keys[0]].id} : changeables[keys[0]].details;

                return changeable;
            }
        }
    }

    const performSectionChanges = () => {
        let changeable = {type: false, details: {offered_id: null, sections: []}};
        let types = ['create', 'update', 'delete'];
        let nonDeletables = Object.filterOut(diffTable, 'mode', 'delete');
        for (let c in nonDeletables) {
            for (let i = 0; i < types.length; i++) {
                let changeables = diffTable[c].sections.filter(fac => fac.mode == types[i] );

                if (changeables.length != 0) {
                    changeable.type = types[i];
                    changeable.details.offered_id = diffTable[c].details.id;
                    let lim = Math.min(20, changeables.length);

                    for (let i = 0; i < lim; i++) {
                        changeable.details.sections.push(changeables[i]);
                    }

                    return changeable;
                }
            }
        }
    }

    const creator = (type, creationData) => {
        fetch("{{ route('offered-courses.create', ['year' => $helper->year, 'semester' => $helper->semester]) }}", {
                headers: {
                    "Content-Type": "application/json",
                    "Accept": "application/json, text-plain, */*",
                    "X-Requested-With": "XMLHttpRequest",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                method: 'post',
                credentials: "same-origin",
                body: JSON.stringify({
                    type: type,
                    creationData: creationData,
                })
            }).then(response => {
                return response.json();
            }).then(data => {
                if (type == 'course') {
                    diffTable[creationData.code].details.id = data.creation_id;
                    diffTable[creationData.code].mode = 'none';
                } else {
                    for (let i = 0; i < creationData.sections.length; i++) {
                        creationData.sections[i].mode = 'none';
                        creationData.sections[i].details.id = data.creation_id[i];
                    }
                }

                performChanges();
            }).catch(error => {
                console.log(error);
                alert('Whoop! Something went wrong, please refresh the page and try again');
            });
    }

    const updator = (type, updateData) => {
        fetch("{{ route('offered-courses.update', ['year' => $helper->year, 'semester' => $helper->semester]) }}", {
                headers: {
                    "Content-Type": "application/json",
                    "Accept": "application/json, text-plain, */*",
                    "X-Requested-With": "XMLHttpRequest",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                method: 'post',
                credentials: "same-origin",
                body: JSON.stringify({
                    type: type,
                    updateData: updateData,
                })
            }).then(response => {
                return response.json();
            }).then(data => {
                if (type == 'course') {
                    diffTable[updateData.code].mode = 'none';
                } else {
                    updateData.sections.forEach(section => {
                        section.mode = 'none';
                    });
                }

                performChanges();
            }).catch(error => {
                console.log(error);
                alert('Whoop! Something went wrong, please refresh the page and try again');
            });
    }

    const deletor = (type, deletionData) => {
        fetch("{{ route('offered-courses.delete', ['year' => $helper->year, 'semester' => $helper->semester]) }}", {
                headers: {
                    "Content-Type": "application/json",
                    "Accept": "application/json, text-plain, */*",
                    "X-Requested-With": "XMLHttpRequest",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                method: 'post',
                credentials: "same-origin",
                body: JSON.stringify({
                    type: type,
                    deletionData: deletionData,
                })
            }).then(response => {
                return response.json();
            }).then(data => {
                if (type == 'course') {
                    delete diffTable[deletionData.code];
                } else {
                    deletionData.sections.forEach(section => {
                        section.mode = 'none';
                    });
                }

                performChanges();
            }).catch(error => {
                console.log(error);
                alert('Whoop! Something went wrong, please refresh the page and try again');
            });
    }

    const refreshPage = () => {
        document.getElementById('semester').value = '{{ $helper->semester }}';
        document.getElementById('year').value = '{{ $helper->year }}';
        document.getElementById('run-confirm').submit();
    }

    Object.filter = (obj, key, value) => {
        let result = {}, k;

        for (let k in obj) {
            if (obj[k].hasOwnProperty(key)) {
                if (obj[k][key].includes(value)) {
                    result[k] = obj[k];
                }
            }
        }

        return result;
    }

    Object.filterOut = (obj, key, value) => {
        let result = {}, k;

        for (let k in obj) {
            if (obj[k].hasOwnProperty(key)) {
                if (!obj[k][key].includes(value)) {
                    result[k] = obj[k];
                }
            }
        }

        return result;
    }
</script>