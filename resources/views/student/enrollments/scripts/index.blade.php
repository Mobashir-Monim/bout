<script>
    const semester = document.getElementById('semester');
    const year = document.getElementById('year');
    const enrollments = document.getElementById('enrollments');
    const uploadSpinner = document.getElementById('upload-spinner');
    const uploadIndex = {department: 0, course: 0, section: 0};
    let uploadable = {};

    $("#uploader").click(function(){
        if (semester.value !== "" && year.value !== "") {
            if (enrollments.value !== "") {
                uploadSpinner.classList.remove('hidden');
                console.log('Reading File');
                readFile();
            } else {
                alert("Please select the file containing the enrollment data");
            }
        } else {
            alert("Please select a semester and year");
        }
    });

    const readFile = () => {
        uploadable = {};
        
        setTimeout(() => {
            let reader = new FileReader();

            reader.onload = function () {
                exelToJSON(reader.result);
            };

            reader.readAsBinaryString(enrollments.files[0]);
        }, 100);
    };

    const exelToJSON = data => {
        let cfb = XLSX.read(data, {type: 'binary'});
            
        cfb.SheetNames.forEach(function(sheetName) {   
            let oJS = XLS.utils.sheet_to_json(cfb.Sheets[sheetName], {defval: ""});

            for (let index = 0; index < oJS.length; index++) {
                oJS[index].department = oJS[index].department.toUpperCase();
                appendKey(uploadable, oJS[index].department, {});
                oJS[index].course = oJS[index].course.replaceAll(' ', '').toUpperCase();
                appendKey(uploadable[oJS[index].department], oJS[index].course, {});
                appendKey(uploadable[oJS[index].department][oJS[index].course], oJS[index].section, []);
                uploadable[oJS[index].department][oJS[index].course][oJS[index].section].push({
                    student_id: oJS[index].student_id,
                    name: oJS[index].name,
                    gsuite: oJS[index].gsuite
                }) 
                
            }
        });

        enrollStudents();
    }

    const appendKey = (cont, key, fill) => {
        if (!cont.hasOwnProperty(key)) {
            cont[key] = fill;
        }
    }

    const getNextSectionStudents = () => {
        const department = Object.keys(uploadable)[uploadIndex.department];
        const course = Object.keys(uploadable[department])[uploadIndex.course];
        const section = Object.keys(uploadable[department][course])[uploadIndex.section];
        
        return {
            semester: semester.value,
            year: year.value,
            department: department,
            course: course,
            section: section,
            students: uploadable[department][course][section],
        }
    }

    const incrementUploadIndex = ({department, course, section}) => {
        let departments = Object.keys(uploadable);
        let courses = Object.keys(uploadable[departments[department]]);
        let sections = Object.keys(uploadable[departments[department]][courses[course]]);

        if (sections[section + 1] !== undefined) {
            uploadIndex.section = section + 1;
            enrollStudents();
        } else {
            uploadIndex.section = 0;

            if (courses[course + 1] !== undefined) {
                uploadIndex.course = course + 1;
                enrollStudents();
            } else {
                uploadIndex.course = 0;

                if (departments[department + 1] !== undefined) {
                    uploadIndex.department = department + 1;
                    enrollStudents();
                } else {
                    uploadSpinner.classList.add('hidden');
                }
            }
        }
    }

    const enrollStudents = () => {
        fetch("{{ route('student-admin.enrollment.enroll') }}", {
                headers: {
                    "Content-Type": "application/json",
                    "Accept": "application/json, text-plain, */*",
                    "X-Requested-With": "XMLHttpRequest",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    },
                method: 'post',
                credentials: "same-origin",
                body: JSON.stringify(getNextSectionStudents())
            }).then(response => {
                return response.json();
            }).then(data => {
                console.log(uploadIndex);
                if (data.success) {
                    incrementUploadIndex(uploadIndex)
                }
            }).catch(error => {
                console.log(error);
                alert('Whoop! Something went wrong, please refresh the page and try again');
            });
    }
</script>