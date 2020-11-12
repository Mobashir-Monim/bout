@extends('layouts.app')

@section('content')
    <div class="row mb-2">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-dark text-light">
                    <h6 class="mb-0">Map usernames to student ID</h6>
                </div>
                <div class="card-body p-3">
                    <div class="row">
                        <div class="col-md-6 text-center my-2">
                            <input type="file" name="username_file" id="username_file" class="form-control">
                            <button class="btn btn-dark my-2 r-25" type="button" data-toggle="tooltip" data-placement="right" title="Click me to map the selected file!" onclick="mapStudentIDs()">
                                <i class="fas fa-project-diagram"></i>
                            </button>
                            <ul class="list-group text-left">
                                <li class="list-group-item" id="username-output">No file has been mapped yet</li>
                            </ul>
                        </div>
                        <div class="col-md-6 my-2">
                            <div class="row">
                                <div class="col-10 my-auto">
                                    <p class="mb-0"><b>Status</b></p>
                                    <span id="username-status-text">Waiting to be run 🙃</span>
                                </div>
                                <div class="col-2 my-auto text-right"><div class="spinner-border" role="status" id="username-status-spinner" style="display: none"><span class="sr-only" style="font-size: 0.5em">Loading...</span></div></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-2">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-dark text-light">
                    <h6 class="mb-0">Format saved responses</h6>
                </div>
                <div class="card-body p-3">
                    <div class="row">
                        <div class="col-md-6 text-center my-2">
                            <textarea name="saved_response" id="saved_response" class="form-control" style="height: 10em; resize: none;" placeholder="Please paste the saved response here"></textarea>
                            <button class="btn btn-dark w-100 mt-2" onclick="formatJSONToText()">Format saved response</button>
                        </div>
                        <div class="col-md-6 my-2">
                            <textarea name="saved_response_output" id="saved_response_output" class="form-control" style="height: 10em; resize: none;" placeholder="The formated response will be shown here"></textarea>
                            <button class="btn btn-dark w-100 mt-2" onclick="copyCode()">Copy formated output</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
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
            let mappableState = usernameFileHeaders.includes('email') || usernameFileHeaders.includes('username'), mappable;
            
            if (mappableState) {
                mappable = collectMapData();
            } else {
                alert('The file does not contain usernames or email addresses 😶😶😶');
                changeStatus('username', 'Waiting to be run 🙃');
            }

            changeStatus('username', 'Fetching data from servers 📡🎛');

            setTimeout(() => {
                fetchMapData(mappable);
            }, 100);
        }

        const fetchMapData = mappable => {
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
                    row.username = data.filter(r => { return r.username == row.username })[0].id;
                }

                let filename = `mapped-${ getFilename(document.getElementById('username_file').value) }`.replace('.csv', '').replace('.xls', '').replace('.xlsx', '');
                document.getElementById('username-output').innerHTML = `<a href="#/" class="text-primary stretched-link" onclick="downloadCrunchedData(usernameFileData, '${ filename }')">${ filename }</a>`;
                changeStatus('username', 'Completed! 💪😎😇✌');
                altert('Completed! 💪😎😇✌');
            }).catch(error => {
                console.log(error);
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

        const collectMapData = () => {
            let mapID = [], temp = [];
            if (usernameFileHeaders.includes('username')) { mapID.push('username'); }
            if (usernameFileHeaders.includes('email')) { mapID.push('email'); }

            usernameFileData.forEach(row => {
                let imm = {};

                mapID.forEach(id => {
                    imm[id] = row[id];
                });

                temp.push(imm);
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

        const formatJSONToText = () => {
            let jsonText = JSON.parse(document.getElementById('saved_response').value);
            document.getElementById('saved_response_output').value = traverseNConcat("", jsonText);
        }

        const traverseNConcat = (text, part) => {
            if (!Array.isArray(part) && typeof(part) != "object") { return `${ text }\n${ part }`; }
            for (p in part) { text = `${ traverseNConcat(text, part[p]) }`; }
            return text;
        }

        const copyCode = () => {
            $("#saved_response_output").select();
            document.execCommand('copy');
            alert('Formatted text has been copied!');
        }

        const downloadCrunchedData = (marker, name) => {
            let resultingWS = XLSX.utils.json_to_sheet(marker); 
            let wb = XLSX.utils.book_new();
            XLSX.utils.book_append_sheet(wb, resultingWS, 'Sheet');   
            XLSX.writeFile(wb, `${ name }.xlsx`);
        }

        let postReaderOps = {'username': continueMapOperation, 'test': ''};
    </script>
@endsection