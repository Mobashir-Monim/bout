<script>
    let uploadModeUpdateStatus = true;
    let uploadable = [];
    let uploadIndex = 0;
    let uploadTableIndex = null;
    let uploadMode = null;
    const uploadSelect = document.getElementById('upload-select');
    const uploadModeRow = document.getElementById('upload-mode');
    const uploadSpinnerRow = document.getElementById('upload-spinner');

    const toggleUploadStatusVisual = () => {
        if (uploadModeRow.classList.contains('hidden')) {
            uploadModeRow.classList.remove('hidden');
            uploadSpinnerRow.classList.add('hidden');
        } else {
            uploadModeRow.classList.add('hidden');
            uploadSpinnerRow.classList.remove('hidden');
        }
    }

    function readFile() {
        toggleUploadStatusVisual();
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
                let oJS = XLS.utils.sheet_to_json(cfb.Sheets[sheetName], {raw: true, defval: "N/A"});
                
                if (oJS.length > 0) {
                    let headers = Object.keys(oJS[0]);
                    let descriptions = {}; let rows = []; let i = 0;
                    headers.forEach(key => { descriptions[key] = tables[uploadTableIndex].description.find(x => { return x['Field'] == key }); });

                    oJS.forEach(row => {
                        rows.push({}); i++;
                        headers.forEach(key => { rows[rows.length - 1][key] = setData(descriptions, key, row[key]); });

                        if (i % 100 == 0 && i != 0) {
                            uploadable.push({ table: sheetName, rows: rows });
                            rows = [];
                        }
                    });

                    if (i % 100 != 0) { uploadable.push({ table: sheetName, rows: rows }); }
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
            uploadable = [];
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
        console.log(uploadIndex);
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
                    table: uploadable[uploadIndex].table,
                    rows: uploadable[uploadIndex].rows,
                    current: uploadIndex + 1,
                    last: uploadable.length,
                })
            }).then(response => {
                return response.json();
            }).then(data => {
                if (data.success) {
                    uploadIndex += 1;
                    if (uploadIndex < uploadable.length) { setTimeout(() => { uploadTable(); }, 100); }
                    else { toggleUploadStatusVisual(); }
                } else {
                    throw `${ data.message }`;
                }
            }).catch(error => {
                console.log(error);
                alert(`Whoops! Something went wrong while trying to upload. Please try again later.`);
            });
    }

    const setDelay = () => {
        let apiCallTime = uploadable.length * 1.5;
        if (uploadIndex == 0) { return apiCallTime; }

        let delTime = uploadable.length * 1.5;
        let prevProcessTime = uploadIndex * 1.5;

        return Math.ceil(apiCallTime + delTime + prevProcessTime);
    }
</script>