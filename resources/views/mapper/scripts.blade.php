<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.16.8/jszip.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/2.0.0/FileSaver.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.16.8/xlsx.min.js"></script>
<script>
    let mapTypesComplex = {
        username_to_id: {
            id: 'username',
            description: 'Convert buX usernames of students to Student ID <br><b><span class="text-danger">NOTE:</span> The file must contain a header column titled "username"</b>',
            to: 'id',
        },
        id_to_username: {
            id: 'student_id',
            description: 'Convert Student ID of students to buX username <br><b><span class="text-danger">NOTE:</span> The file must contain a header column titled "student_id"</b>',
            to: 'username',
        },
        id_to_email: {
            id: 'student_id',
            description: 'Convert Student ID of students to USIS email address <br><b><span class="text-danger">NOTE:</span> The file must contain a header column titled "student_id"</b>',
            to: 'usis_email',
        },
        id_to_gsuite: {
            id: 'student_id',
            description: 'Convert Student ID of students to BracU G-suite email address <br><b><span class="text-danger">NOTE:</span> The file must contain a header column titled "student_id"</b>',
            to: 'gsuite_email',
        },
    };
    let mapType = document.getElementById('map_type');
    let mapDescription = document.getElementById('map_description');
    let usernameFileHeaders = null;
    let fileData = [];
    let mappableState = 0;
    let mappedData = [];
    let returnee;

    const changeMapDescription = () => {
        mapDescription.innerHTML = mapTypesComplex[mapType.value].description;
    }

    const toggleSpinner = marker => {
        let spinner = document.getElementById(`${ marker }-status-spinner`);

        if (spinner.style.display != 'inline-block') {
            spinner.style.display = 'inline-block';
        } else {
            spinner.style.display = 'none';
        }
    }

    const changeStatus = (marker, status) => {
        document.getElementById(`${ marker }-status-text`).innerHTML = status;
    }

    const checkForFile = marker => {
        if (document.getElementById(`${ marker }_file`).value != "") {
            return true;
        }

        alert('You forgot to select the file 😶😶😶');
        
        return false;
    }

    const startFileProcess = (marker) => {
        if (checkForFile(marker)) {
            changeStatus(marker, 'Reading file 📄🔍')
            setTimeout(() => {
                readFile(marker);
            }, 100);
        }
    }

    const mapStudentIDs = () => {
        usernameFileHeaders = null, fileData = [], mappableState = 0, mappedData = [];
        startFileProcess('username');
    }

    const continueMapOperation = () => {
        let mappableState = usernameFileHeaders.includes(mapTypesComplex[mapType.value].id), mappable, objName = mapTypesComplex[mapType.value].id;
        
        if (!mappableState) {
            if (usernameFileHeaders.includes('Username') && mapTypesComplex[mapType.value].id == 'username') {
                objName = 'Username';
            } else {
                alert(`The file does not contain ${ mapTypesComplex[mapType.value].id } addresses 😶😶😶`);
                changeStatus('username', 'Waiting to be run 🙃');
            }
        }

        mappable = collectMapData(objName);
        changeStatus('username', 'Fetching data from servers 📡🎛');

        setTimeout(() => {
            if (typeof adminAlert === "undefined") {
                fetchMapData(mappable, objName);
            } else {
                if (!considerAdminMap) {
                    fetchMapData(mappable, objName);
                } else {
                    adminMap(mappable, objName);
                }
            }
        }, 100);
    }

    const fetchMapData = (mappable, objName) => {
        fetch("{{ route('student-map') }}", {
            headers: {
                "Content-Type": "application/json",
                "Accept": "application/json, text-plain, */*",
                "X-Requested-With": "XMLHttpRequest",
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
            method: 'post',
            credentials: "same-origin",
            body: JSON.stringify({
                data: mappable,
                mapType: mapType.value,
            })
        }).then(response => {
            return response.json();
        }).then(data => {
            data = data.data;
            returnee = data;
            for (let fRowNum in fileData) {
                let fRow = fileData[fRowNum];
                let temp = {};

                for (let key in fRow) {
                    if (key != objName) {
                        temp[key] = fRow[key];
                    } else {
                        temp[key] = fRow[key];
                        temp[mapTypesComplex[mapType.value].to] = data.filter(r => { return r[mapTypesComplex[mapType.value].id] == fRow[objName] })[0][mapTypesComplex[mapType.value].to];
                    }
                }

                mappedData.push(temp);
            }

            let filename = `mapped-${ getFilename(document.getElementById('username_file').value) }`.replace('.csv', '').replace('.xls', '').replace('.xlsx', '');
            document.getElementById('username-output').innerHTML = `<a href="#/" class="text-primary stretched-link" id="downloader" onclick="downloadCrunchedData(fileData, '${ filename }')">${ filename }</a>`;
            changeStatus('username', 'Completed! 💪😎😇✌');
            alert('Completed! 💪😎😇✌');
        }).catch(error => {
            console.log(error);
            alert('Whoops! Something went wrong. Please try again')
        });
    }

    const getFilename = fullPath => {
        let startIndex = (fullPath.indexOf('\\') >= 0 ? fullPath.lastIndexOf('\\') : fullPath.lastIndexOf('/'));
        let filename = fullPath.substring(startIndex);
        if (filename.indexOf('\\') === 0 || filename.indexOf('/') === 0) {
            filename = filename.substring(1);
        }
        return filename
    }

    const collectMapData = (objName) => {
        let temp = [];

        fileData.forEach(row => {
            let t = {};
            t[mapTypesComplex[mapType.value].id] = row[objName]
            temp.push(t);
        });

        return temp;
    }

    function readFile(file) {
        let fileInput = document.getElementById(`${ file }_file`);
        let reader = new FileReader();

        reader.onload = function () {
            exelToJSON(reader.result, file);
        };

        reader.readAsBinaryString(fileInput.files[0]);
    };

    function exelToJSON(data, file) {
        let cfb = XLSX.read(data, {type: 'binary'});
            
        cfb.SheetNames.forEach(function(sheetName) {   
            let oJS = XLS.utils.sheet_to_json(cfb.Sheets[sheetName], {raw: true, defval: null});
            let result = [];
            let headers = Object.keys(oJS[0]);

            for (let index = 0; index < oJS.length; index++) {
                let imm = {};

                headers.forEach(key => {
                    imm[key] = oJS[index][key] != undefined ? oJS[index][key].toString() : oJS[index][key];
                });

                result.push(imm);
            }

            putResults(file, headers, result);
            postReaderOps[file]();
        });
    }

    const putResults = (file, headers, result) => {
        if (file == "username") {
            usernameFileHeaders = headers;
            fileData = result;
        } else if (file == "test") {
            conHeader = headers;
            con = result;
        }
    }

    const traverseNConcat = (text, part) => {
        if (!Array.isArray(part) && typeof(part) != "object") { return `${ text }\n${ part }`; }
        for (p in part) { text = `${ traverseNConcat(text, part[p]) }`; }
        return text;
    }

    const downloadCrunchedData = (marker, name) => {
        console.log('Initiating download');
        let ws = XLSX.utils.json_to_sheet(mappedData);
        let wb = XLSX.utils.book_new();
        XLSX.utils.book_append_sheet(wb, ws, "Results");
        let wbout = XLSX.write(wb, {bookType:'xlsx', type:'binary'});
        saveAs(new Blob([s2ab(wbout)],{type:"application/octet-stream"}), `${ name }.xlsx`);
    }

    const s2ab = s => {
        let buf = new ArrayBuffer(s.length);
        let view = new Uint8Array(buf);
        for (let i=0; i!=s.length; ++i) view[i] = s.charCodeAt(i) & 0xFF;
        return buf;
    }

    let postReaderOps = {'username': continueMapOperation, 'test': ''};
</script>