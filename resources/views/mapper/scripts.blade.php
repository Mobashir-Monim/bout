<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.16.0/jszip.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.16.0/xlsx.js"></script>
<script>
    let usernameFileHeaders = null;
    let usernameFileData = [];
    let mappableState = 0;
    let mappedData = [];

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
        usernameFileHeaders = null, usernameFileData = [], mappableState = 0, mappedData = [];
        startFileProcess('username');
    }

    const continueMapOperation = () => {
        let mappableState = usernameFileHeaders.includes('email') || usernameFileHeaders.includes('username'), mappable, objName = 'username';
        
        if (!mappableState) {
            if (usernameFileHeaders.includes('Username')) {
                objName = 'Username';
            } else {
                alert('The file does not contain usernames or email addresses 😶😶😶');
                changeStatus('username', 'Waiting to be run 🙃');
            }
        }

        mappable = collectMapData(objName);
        changeStatus('username', 'Fetching data from servers 📡🎛');

        setTimeout(() => {
            fetchMapData(mappable, objName);
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
            })
        }).then(response => {
            return response.json();
        }).then(data => {
            data = data.data;

            for (u in usernameFileData) {
                let row = usernameFileData[u];
                row[objName] = data.filter(r => { return r.username == row[objName] })[0].id;
            }

            let filename = `mapped-${ getFilename(document.getElementById('username_file').value) }`.replace('.csv', '').replace('.xls', '').replace('.xlsx', '');
            document.getElementById('username-output').innerHTML = `<a href="#/" class="text-primary stretched-link" onclick="downloadCrunchedData(usernameFileData, '${ filename }')">${ filename }</a>`;
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

        usernameFileData.forEach(row => {
            temp.push({'username': row[objName]});
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
            usernameFileData = result;
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
        let resultingWS = XLSX.utils.json_to_sheet(marker); 
        let wb = XLSX.utils.book_new();
        XLSX.utils.book_append_sheet(wb, resultingWS, 'Sheet');   
        XLSX.writeFile(wb, `${ name }.xlsx`);
    }

    let postReaderOps = {'username': continueMapOperation, 'test': ''};
</script>