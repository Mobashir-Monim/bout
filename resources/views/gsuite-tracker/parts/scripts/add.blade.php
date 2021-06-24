<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.16.8/jszip.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/2.0.0/FileSaver.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.16.8/xlsx.min.js"></script>
<script>
    const studentsFile = document.getElementById('students-file');
    const massUploadOut = document.getElementById('mass-upload');
    const students = [];
    let uploadIndex = 0;
    let uploadErrors = [];

    const massUploadStudents = () => {
        uploadErrors = [];
        uploadIndex = 0;
        massUploadOut.innerHTML = '<div class="mt-2 spinner-border" role="status"><span class="sr-only">Loading...</span></div>';
        setTimeout(() => {
            let reader = new FileReader();
            reader.onload = () => { exelToJSON(reader.result); };
            reader.readAsBinaryString(studentsFile.files[0]);
        }, 100);
    }

    function exelToJSON(data, out, file) {
        let cfb = XLSX.read(data, {type: 'binary'});
            
        cfb.SheetNames.forEach(function(sheetName) {   
            let oJS = XLS.utils.sheet_to_json(cfb.Sheets[sheetName], {defval: ""});
            let headers = Object.keys(oJS[0]);

            for (let index = 0; index < oJS.length; index++) {
                let imm = {};

                headers.forEach(key => {
                    imm[key] = oJS[index][key] != undefined ? oJS[index][key].toString().replace(/\s+/g,' ').trim() : oJS[index][key];
                });

                students.push(imm);
            }
        });

        uploadStudents();
    }

    const uploadStudents = () => {
        fetch("{{ route('it-team.students.add') }}", {
                headers: {
                    "Content-Type": "application/json",
                    "Accept": "application/json, text-plain, */*",
                    "X-Requested-With": "XMLHttpRequest",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    },
                method: 'post',
                credentials: "same-origin",
                body: JSON.stringify({
                    students: groupStudentsForUpload(),
                })
            }).then(response => {
                return response.json();
            }).then(data => {
                if (data.success) {
                    if (uploadIndex < students.length) {
                        uploadIndex += 100;

                        if (data.errors.length > 0) {
                            for (let e in data.errors) {
                                uploadErrors.push(data.errors[e]);
                            }
                        }

                        uploadStudents();
                    } else {
                        if (uploadErrors.length > 0) {
                            logErrors();
                        }

                        massUploadOut.innerHTML = `<button class="btn btn-dark w-100" type="button" onclick="massUploadStudents()">Add</button>`;
                        alert('Successfully done uploading');
                    }
                }
            }).catch(error => {
                console.log(error);
            });
    }

    const groupStudentsForUpload = () => {
        let temp = [];

        for (let i = 0; i < 100 && i + uploadIndex < students.length; i++) {
            temp.push(students[i + uploadIndex]);
        }

        return temp;
    }

    const logErrors = () => {
        let messages = ``;
        
        for (let e in uploadErrors) {
            messages = `${ messages }<div class="alert alert-danger" role="alert">${ uploadErrors[e] }</div>`;
        }

        document.getElementById('error-log').innerHTML = messages;
    }
</script>