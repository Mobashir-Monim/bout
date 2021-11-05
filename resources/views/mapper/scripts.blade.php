<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.16.8/jszip.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/2.0.0/FileSaver.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.16.8/xlsx.min.js"></script>
<script>
    let mapTypesComplex = {
        username_to_id: {
            id: 'username',
            description: 'Convert buX usernames of students to Student ID <br><b><span class="text-danger">NOTE:</span> The file must contain a header column titled "username"</b>',
            to: 'id',
            selector: document.getElementById('username_to_id')
        },
        id_to_username: {
            id: 'student_id',
            description: 'Convert Student ID of students to buX username <br><b><span class="text-danger">NOTE:</span> The file must contain a header column titled "student_id"</b>',
            to: 'username',
            selector: document.getElementById('id_to_username')

        },
        id_to_email: {
            id: 'student_id',
            description: 'Convert Student ID of students to USIS email address <br><b><span class="text-danger">NOTE:</span> The file must contain a header column titled "student_id"</b>',
            to: 'usis_email',
            selector: document.getElementById('id_to_email')
        },
        id_to_gsuite: {
            id: 'student_id',
            description: 'Convert Student ID of students to BracU G-suite email address <br><b><span class="text-danger">NOTE:</span> The file must contain a header column titled "student_id"</b>',
            to: 'gsuite_email',
            selector: document.getElementById('id_to_gsuite')
        },
        gsuite_to_id: {
            id: 'email',
            description: 'Convert G-Suite address of students to student_id <br><b><span class="text-danger">NOTE:</span> The file must contain a header column titled "email"</b>',
            to: 'student_id',
            selector: document.getElementById('gsuite_to_id')
        },
    };
    let mapType = document.getElementById('map_type');
    let mapDescription = document.getElementById('map_description');
    let selectorCont = document.getElementById('selector-cont');
    let fileInputBtn = document.getElementById('file_input_btn');
    let textInputBtn = document.getElementById('text_input_btn');
    let fileInputArea = document.getElementById('file_input_area');
    let textInputArea = document.getElementById('text_input_area');
    let textInputData = document.getElementById('text_data');
    let usernameFileHeaders = null;
    let fileData = [];
    let mappableState = 0;
    let mappedData = [];
    let returnee;

    const changeMapTypeBtn = (el) => {
        [...mapType.options].find(opt => opt.value == el.id).selected = true;
        toggleActiveBtn(el);
        changeMapDescription();
    }

    const changeMapTypeDropDown = () => {
        toggleActiveBtn(mapTypesComplex[mapType.value].selector);
        changeMapDescription();
    }

    const changeInputType = (el) => {
        if (el.id == fileInputBtn.id) {
            toggleInputBtn(fileInputBtn, 'dark', 'primary');
            toggleInputBtn(textInputBtn, 'primary', 'dark');
            fileInputArea.classList.remove('hidden');
            textInputArea.classList.add('hidden');
        } else {
            toggleInputBtn(textInputBtn, 'dark', 'primary');
            toggleInputBtn(fileInputBtn, 'primary', 'dark');
            fileInputArea.classList.add('hidden');
            textInputArea.classList.remove('hidden');
        }
    }

    const toggleInputBtn = (el, from, to) => {
        if (el.classList.contains(`btn-${ from }`)) {
            el.classList.remove(`btn-${ from }`);
        }
        
        if (!el.classList.contains(`btn-${ to }`)) {
            el.classList.add(`btn-${ to }`);
        }
    }

    const toggleActiveBtn = (el) => {
        let prev = Array.from(selectorCont.children).find(btn => btn.classList.contains('btn-primary'));
        prev.classList.remove('btn-primary');
        prev.classList.add('btn-dark');
        el.classList.remove('btn-dark');
        el.classList.add('btn-primary');
    }

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
        if (textInputArea.classList.contains('hidden')) {
            if (document.getElementById(`${ marker }_file`).value != "") {
                return true;
            }

            alert('You forgot to select the file 😶😶😶');
            
            return false;
        } else {
            if (textInputData.value != "") {
                return true;
            }

            alert('You forgot to enter the data 😶😶😶');

            return false;
        }
    }

    const startFileProcess = (marker) => {
        if (checkForFile(marker)) {
            changeStatus(marker, 'Reading data 📄🔍')
            setTimeout(() => {
                if (fileInputBtn.classList.contains('btn-primary')) {
                    readFile(marker);
                } else {
                    readText(marker);
                }
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
        console.log(mappable);
        console.log(encodeURI('http://127.0.0.1:8000/map/studentss?mapType=id_to_gsuite&data=' + JSON.stringify(mappable)))
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
            console.log(data);
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

            if (textInputArea.classList.contains('hidden')) {
                let filename = `mapped-${ getFilename(document.getElementById('username_file').value) }`.replace('.csv', '').replace('.xls', '').replace('.xlsx', '');
                document.getElementById('username-output').innerHTML = `<a href="#/" class="text-primary stretched-link" id="downloader" onclick="downloadCrunchedData(fileData, '${ filename }')">${ filename }</a>`;
            } else {
                textInputData.value = mappedData.map(item => {
                    return item[mapTypesComplex[mapType.value].to];
                }).join("\n");
            }

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
        postReaderOps[file]();
    };

    const readText = () => {
        let mappables = textInputData.value.replaceAll(" ", "").replaceAll(",", "||").replaceAll("\n", "||").replaceAll("||||", "||").split("||").filter(x => x != "");
        
        mappables = mappables.map(item => {
            return {[mapTypesComplex[mapType.value].id]: item};
        })

        putResults("username", [mapTypesComplex[mapType.value].id], mappables);
        postReaderOps["username"]();
    }

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