<script>
    let uploadModeUpdateStatus = true;
    let uploadable = [];
    let uploadIndex = 0;
    let uploadTableIndex = null;
    let uploadMode = null;
    const uploadSelect = document.getElementById('upload-select');

    function readFile() {
        let fileInput = document.getElementById(`upload_file`);
        let reader = new FileReader();

        reader.onload = function () {
            exelToJSON(reader.result);
        };

        reader.readAsBinaryString(fileInput.files[0]);
    };

    function exelToJSON(data) {
        let cfb = XLSX.read(data, {type: 'binary'});
            
        cfb.SheetNames.forEach(function(sheetName) {
            uploadable[sheetName] = [];
            let oJS = XLS.utils.sheet_to_json(cfb.Sheets[sheetName], {raw: true, defval: "N/A"});
            
            if (oJS.length > 0) {
                let result = [];
                let headers = Object.keys(oJS[0]);

                for (let index = 0; index < oJS.length; index++) {
                    let imm = {};

                    headers.forEach(key => {
                        if (key != 'created_at' && key != 'updated_at') {
                            if (key == 'is_academic_part' || key == 'is_lab_faculty' || key == 'has_lab' || key == 'is_lab' || key == 'is_rerun' || key == 'is_head' || key == 'current_team_id') {
                                imm[key] = oJS[index][key] == "" ? 0 : oJS[index][key];
                            } else {
                                imm[key] = oJS[index][key] == "" || oJS[index][key] == " " ? "N/A" : oJS[index][key];
                            }
                        } else {
                            imm[key] = isNaN(Date.parse(oJS[index][key])) || oJS[index][key] == "N/A" ? null : oJS[index][key];
                        }
                    });

                    result.push(imm);
                }

                uploadable[sheetName] = result;
            }
        });

        setUploadTableIndex();
        uploadTable();
    }

    const initiateUpload = () => {
        if (validateUploadSelect()) {
            uploadable = {};
            uploadIndex = 0;
            readFile();
        }
    }

    const validateUploadSelect = () => {
        if (uploadSelect.value != "") {
            if (uploadSelect.value != 'all' && tables.map((e) => e.name).indexOf(uploadSelect.value) == -1) {
                setTimeout(() => { alert("Please select a valid table to upload") }, 10);
            } else {
                return true;
            }
        } else {
            setTimeout(() => { alert("Please select a table to upload") }, 10);
            return false;
        }
    }

    const setUploadTableIndex = (findNext = false) => {
        if (uploadMode == 'multi' && findNext) {
            uploadTableIndex += 1;
        } else {
            if (uploadMode == 'multi') {
                uploadTableIndex = 0;
            } else {
                uploadTableIndex = tables.map((e) => e.name).indexOf(uploadSelect.value);
            }
        }
    }

    const updateUploadMode = () => {
        if (uploadModeUpdateStatus) {
            if (uploadSelect.value == "all") {
                uploadMode = 'multi';
            } else if (uploadSelect.value == "") {
                uploadMode = null;
            } else {
                uploadMode = 'single';
            }
        }
    }

    const uploadTable = () => {
        if (uploadIndex < uploadable[tables[uploadTableIndex].name].length) {
            fetch(`{{ route('data-backup.upload') }}`, {
                    headers: {
                        "Content-Type": "application/json",
                        "Accept": "application/json, text-plain, */*",
                        "X-Requested-With": "XMLHttpRequest",
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                        },
                    method: 'post',
                    credentials: "same-origin",
                    body: JSON.stringify({
                        table: tables[uploadTableIndex].name,
                        rows: getUploadableRows(),
                        prune: uploadIndex == 0,
                    })
                }).then(response => {
                    console.log(response)
                    return response.json();
                }).then(data => {
                    if (data.success) {
                        uploadIndex += 100;
                        uploadTable();
                    } else {
                        throw `${ data.message }`;
                    }
                }).catch(error => {
                    console.log(error);
                    alert(`Whoops! Something went wrong while trying to upload. Please try again later.`);
                });
        } else {
            makeNextUploadCall();
        }
    }

    const getUploadableRows = () => {
        let temp = [];

        for (let i = 0; i < uploadable[tables[uploadTableIndex].name].length && i < 100; i++) {
            temp.push(uploadable[tables[uploadTableIndex].name][i]);
        }

        return temp;
    }

    const makeNextUploadCall = () => {
        setUploadTableIndex(true);
        
        if (uploadMode == 'multi' && uploadTableIndex < tables.length) {
            uploadIndex = 0;
            uploadTable();
        } else {
            uploadModeUpdateStatus = true;
            alert('Uploaded');
        }
    }
</script>