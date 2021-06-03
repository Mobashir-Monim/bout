<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.16.8/jszip.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/2.0.0/FileSaver.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.16.8/xlsx.min.js"></script>
<script>
    const registrationsFile = document.getElementById('registrations');
    const emailSubject = document.getElementById('subject');
    const formURL = document.getElementById('form_url');
    const courseKey = document.getElementById('cc_key');
    const theoryKey = document.getElementById('ts_key');
    const ls1Key = document.getElementById('ls1_key');
    const ls2Key = document.getElementById('ls2_key');
    const emailBtnCont = document.getElementById('email-btn-cont');
    const labCourses = document.getElementById('lab_courses');
    const errors = [
        {
            check: registrationsFile,
            error: false,
            message: 'Please select a registration file to start emailing'
        },
        {
            check: emailSubject,
            error: false,
            message: 'Please type the subject for the email'
        },
        {
            check: formURL,
            error: false,
            message: 'Please provide the form URL for the evaluation'
        },
        {
            check: courseKey,
            error: false,
            message: 'Please provide the course key for the form'
        },
        {
            check: theoryKey,
            error: false,
            message: 'Please provide the theory section key for the form'
        },
        {
            check: ls1Key,
            error: false,
            message: 'Please provide the ls1 key for the form'
        },
        {
            check: ls2Key,
            error: false,
            message: 'Please provide the ls2 key for the form'
        },
        {
            check: labCourses,
            error: false,
            message: 'Please provide the lab courses of the given semester'
        },
    ];
    let emailables = [];

    const startEmailing = () => {
        for (let i in errors) {
            errors[i].error = errors[i].check.value == "";
        }

        if (errors.filter(e => e.error).length == 0) {
            readFile(registrationsFile);
        } else {
            alert(errors.find(e => e.error).message);
        }
    }

    const readFile = (fileInput) => {
        emailBtnCont.innerHTML = '<div class="mt-2 spinner-border" role="status"><span class="sr-only">Loading...</span></div>';
        setTimeout(() => {
            let reader = new FileReader();

            reader.onload = function () {
                exelToJSON(reader.result);
            };

            reader.readAsBinaryString(fileInput.files[0]);
        }, 100);
    };

    const exelToJSON = (data) => {
        let cfb = XLSX.read(data, {type: 'binary'});
            
        cfb.SheetNames.forEach(function(sheetName) {   
            let oJS = XLS.utils.sheet_to_json(cfb.Sheets[sheetName], {defval: ""});

            for (let index = 0; index < oJS.length; index++) {
                if (emailables.filter(e => e.id == oJS[index]['Student_ID']).length == 0) {
                    let student = {
                        id: oJS[index]['Student_ID'],
                        name: oJS[index]['full_name'],
                        email: oJS[index]['email'],
                        emailed: false,
                        courses: [],
                    }
                    emailables.push(student);

                    let courses = oJS.filter(x => x['Student_ID'] == oJS[index]['Student_ID']);

                    for (let i in courses) {
                        student.courses.push({
                            code: courses[i]['Course_Code'],
                            title: courses[i]['course_title'],
                            section: parseInt(`${ courses[i]['section'] }`.match(/\d+/)[0]),
                            semester: oJS[index]['semester'],
                            has_lab: labCourses.value.includes(courses[i]['Course_Code']),
                            url: buildURL(courses[i]['Course_Code'], parseInt(`${ courses[i]['section'] }`.match(/\d+/)[0]), labCourses.value.includes(courses[i]['Course_Code'])),
                        });
                    }

                    index += courses.length;
                }
            }
        });

        emailNextStudent();
    }

    const buildURL = (code, section, hasLab) => `${ formURL.value }?${ courseKey.value }=${ code }&${ theoryKey.value }=${ section }&${ hasLab ? ls1Key.value : ls2Key.value }=${ section }`;

    const emailNextStudent = () => {
        fetch("{{ route('emailer.eval.send') }}", {
                headers: {
                    "Content-Type": "application/json",
                    "Accept": "application/json, text-plain, */*",
                    "X-Requested-With": "XMLHttpRequest",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    },
                method: 'post',
                credentials: "same-origin",
                body: JSON.stringify({
                    student: emailables.find(e => e.emailed == false),
                    subject: emailSubject.value
                })
            }).then(response => {
                return response.json();
            }).then(data => {
                console.log(data);

                if (data.success) {
                    emailables.find(e => e.emailed == false).emailed = true;

                    if (emailables.filter(e => e.emailed == false).length > 0) {
                        emailNextStudent();
                    } else {
                        emailBtnCont.innerHTML = 'Done emailing';
                    }
                }
            }).catch(error => {
                console.log(error);
                alert('Whoop! Something went wrong, please refresh the page and try again');
            });
    }
</script>