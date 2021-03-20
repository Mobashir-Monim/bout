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
        setUploadTableIndex();
            
        cfb.SheetNames.forEach(function(sheetName) {
            if (tables.find(x => x.name == sheetName) != undefined) {
                uploadable[sheetName] = [];
                let oJS = XLS.utils.sheet_to_json(cfb.Sheets[sheetName], {raw: true, defval: "N/A"});
                
                if (oJS.length > 0) {
                    uploadable[sheetName] = [];
                    let headers = Object.keys(oJS[0]);
                    let descriptions = {};

                    headers.forEach(key => {
                        descriptions[key] = tables[uploadTableIndex].description.find(x => { return x['Field'] == key });
                    });

                    for (let index = 0; index < oJS.length; index++) {
                        let imm = {};

                        headers.forEach(key => {
                            imm[key] = setData(descriptions, key, oJS[index][key]);
                        });

                        uploadable[sheetName].push(imm);
                    }
                }

                setUploadTableIndex(true);
            }
        });

        setUploadTableIndex();
        uploadTable();
    }

    const setData = (description, key, val) => {
        if (description[key]['Type'] == 'tinyint(1)') {
            return handleBooleanData(description[key], val);
        } else if (description[key]['Type'].includes('timestamp')) {
            return handleTimestampData(description[key], val);
        } else if (description[key]['Type'].includes('int')) {
            return handleNumericData(description[key], val);
        } else {
            return handleStringData(description[key], val);
        }
    }

    const handleBooleanData = (des, val) => {
        if (val == 'N/A' || val === '' || val === ' ' || val == null) {
            if (des['Null'] == 'NO' && des['Default'] == null) {
                return false;
            } else if (des['Null'] == 'NO' && des['Default'] != null) {
                return des['Default'];
            } else {
                return null;
            }
        } else {
            return val;
        }
    }

    const handleTimestampData = (des, val) => {
        if (val.includes('N/A')) {
            return null;
        } else {
            return val;
        }
    }

    

    const handleNumericData = (des, val) => {
        if (val == 'N/A' || val === '' || val === ' ' || val == null) {
            if (des['Null'] == 'NO' && des['Default'] == null) {
                return 0;
            } else if (des['Null'] == 'NO' && des['Default'] != null) {
                return des['Default'];
            } else {
                return null;
            }
        } else {
            return val;
        }
    }

    const handleStringData = (des, val) => {
        if (val === '' || val === ' ' || val == null) {
            if (des['Null'] == 'NO' && des['Default'] == null) {
                return 'N/A';
            } else if (des['Null'] == 'NO' && des['Default'] != null) {
                if (des['Default'] === '' || des['Default'] === ' ') {
                    return 'N/A';
                } else {
                    return des['Default'];
                }
            } else {
                return null;
            }
        } else {
            return val;
        }
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
            // console.log(`
            //             table=${ tables[uploadTableIndex].name }&
            //             rows=${ JSON.stringify(getUploadableRows()) }&
            //             prune=${ uploadIndex == 0 }`)
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
            console.log(`Completed ${ tables[uploadTableIndex].name }`)
            makeNextUploadCall();
        }
    }

    const getUploadableRows = () => {
        let temp = [];

        for (let i = 0; i + uploadIndex < uploadable[tables[uploadTableIndex].name].length && i < 100; i++) {
            temp.push(uploadable[tables[uploadTableIndex].name][i + uploadIndex]);
        }

        return temp;
    }

    const makeNextUploadCall = () => {
        setUploadTableIndex(true);
        uploadIndex = 0;
        
        if (uploadMode == 'multi' && uploadTableIndex < tables.length) {
            uploadTable();
        } else {
            uploadModeUpdateStatus = true;
            alert('Uploaded');
        }
    }
</script>