<script>
    const semester = document.getElementById('semester');
    const year = document.getElementById('year');
    const studentTable = {
        table: document.getElementById('tracker-table'),
        course: document.getElementById('tracker-course'),
        body: document.getElementById('tracker-body'),
    }
    const statsConts = {
        theory: {
            percentage: document.getElementById('theory-p'),
            count: document.getElementById('theory-c'),
            remaining: document.getElementById('theory-r'),
        },
        lab: {
            percentage: document.getElementById('lab-p'),
            count: document.getElementById('lab-c'),
            remaining: document.getElementById('lab-r'),
        },
    }
    let sectionData = {};
    let responses = {};
    const evaluated = `<span class="material-icons-outlined" style="color: green">done</span>`
    const notEvaluated = `<span class="material-icons-outlined" style="color: red">close</span>`

    const getStudentList = (section) => {
        fetch("{{ route('eval-tracker.student-list') }}", {
                headers: {
                    "Content-Type": "application/json",
                    "Accept": "application/json, text-plain, */*",
                    "X-Requested-With": "XMLHttpRequest",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    },
                method: 'post',
                credentials: "same-origin",
                body: JSON.stringify({
                    semester: semester.value,
                    year: year.value,
                    section: section
                })
            }).then(response => {
                return response.json();
            }).then(data => {
                sectionData.students = data.students,
                sectionData.section = data.section;
                buildTableBody(data.students, data.section);
                
                if (Object.keys(responses).length === 0) {
                    fetchResponseData(section);
                } else {
                    markResponses();
                }
            }).catch(error => {
                console.log(error);
                alert('Whoop! Something went wrong, please refresh the page and try again');
            });
    }

    const buildTableBody = (students, section) => {
        let studentBody = ``
        
        for (let s in students) {
            studentBody = `
                ${ studentBody }
                <tr>
                    <th class="my-auto">${ students[s].student_id }</th>
                    <td class="my-auto">${ students[s].name }</td>
                    <td class="my-auto text-center" id="r-${ students[s].student_id }"></td>
                </tr>
            `

            // <td class="my-auto text-center" id="t-${ students[s].student_id }">${ section.is_lab ? 'N/A' : '<div class="mt-2 spinner-border" role="status"><span class="sr-only">Loading...</span></div>' }</td>
            // <td class="my-auto text-center" id="l-${ students[s].student_id }">${ section.has_lab ? '<div class="mt-2 spinner-border" role="status"><span class="sr-only">Loading...</span></div>' : 'N/A' }</td>
        }

        studentTable.course.innerText = `${ section.code }: ${ section.title } - Section ${ section.section }`;
        studentTable.body.innerHTML = studentBody;
        studentTable.table.classList.remove('hidden');
    }

    const fetchResponseData = (section) => {
        console.log(JSON.stringify({
                    semester: semester.value,
                    year: year.value,
                    section: section
                }));
        fetch("{{ route('eval-tracker.responses') }}", {
                headers: {
                    "Content-Type": "application/json",
                    "Accept": "application/json, text-plain, */*",
                    "X-Requested-With": "XMLHttpRequest",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    },
                method: 'post',
                credentials: "same-origin",
                body: JSON.stringify({
                    semester: semester.value,
                    year: year.value,
                    section: section
                })
            }).then(response => {
                return response.json();
            }).then(data => {
                responses = data.collated;
                markResponses();
            }).catch(error => {
                console.log(error);
                alert('Whoop! Something went wrong, please refresh the page and try again');
            });
    }

    const markResponses = () => {
        markNoEmails();
        let stats = {'theory': 0, 'lab': 0};
        let targetStudents = sectionData.students.filter(x => x.email.length === 1);
        
        for (let s in targetStudents) {
            for (let r in responses) {
                let records = responses[r].filter(row => row.email === targetStudents[s].email[0]);
                records = records.filter(t => t.course === sectionData.section.code);
                records = records.filter(t => t.section == sectionData.section.section);
                
                if ((r === 'theory' && !sectionData.section.is_lab) || (r === 'lab' && sectionData.section.has_lab)) {
                    // document.getElementById(`${r[0]}-${targetStudents[s].student_id}`).innerHTML = records.length !== 0 ? evaluated : notEvaluated;
                    stats[r] += records.length !== 0 ? 1 : 0;
                }
            }
        }

        computeStats(stats);
    }

    const computeStats = stats => {
        for (let r in stats) {
            statsConts[r].count.innerHTML = stats[r];
            statsConts[r].remaining.innerHTML = sectionData.students.length - stats[r];
            statsConts[r].percentage.innerHTML = (100 * stats[r] / sectionData.students.length).toFixed(2);
        }
    }

    const markNoEmails = () => {
        let targetStudents = sectionData.students.filter(x => x.email.length !== 1);

        for (let s in targetStudents) {
            console.log(targetStudents[s]);
            document.getElementById(`r-${ targetStudents[s].student_id }`).innerHTML = 'Gsuite not found, collect from student';
            // document.getElementById(`t-${ targetStudents[s].student_id }`).innerHTML = 'Gsuite not found, collect from student';
            // document.getElementById(`l-${ targetStudents[s].student_id }`).innerHTML = 'Gsuite not found, collect from student';
        }
    }
</script>