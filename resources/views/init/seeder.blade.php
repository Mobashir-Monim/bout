@extends('layouts.app')

@section('content')
    <div class="row mb-3">
        <div class="col-md-6">
            <input type="file" name="student_list" id="student_list" class="form-control">
        </div>
        <div class="col-md-6 my-auto">
            <div class="row">
                <div class="col-md my-auto" id="main-status">Waiting for file input</div>
                <div class="col-md-2 my-auto"><div class="mt-2 spinner-border" role="status" id="spinner" style="display: none"><span class="sr-only">Loading...</span></div></div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header py-1 px-2">
                    Status Log
                </div>
                <div class="card-body" id="status-log" style="height: 300px; overflow-y: scroll">

                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.16.0/jszip.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.16.0/xlsx.js"></script>
    <script>
        let studentListHeader = null;
        let studentList = [];
        let parts = [];
        let requestIndex = 0;

        $("input#student_list").change(function () {
            readFile('student_list');
        });

        const changeStatus = status => {
            document.getElementById('main-status').innerHTML = `<p class="mb-0">${ status }</p>`;
            document.getElementById('status-log').innerHTML = `<p style="font-size: 0.8em">${ status }</p> ${ document.getElementById('status-log').innerHTML }`;
        }

        function readFile(file) {
            let fileInput = document.getElementById(file);
            changeStatus('Reading input file');
            document.getElementById('spinner').style.display = 'inline-block';
            setTimeout(() => {
                let reader = new FileReader();

                reader.onload = function () {
                    exelToJSON(reader.result, file);
                };

                reader.readAsBinaryString(fileInput.files[0]);
            }, 100);
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

                studentListHeader = headers;
                studentList = result;
                seedList();
            });
        }

        const seedList = () => {
            createParts();
            seedPart();
        }

        const createParts = () => {
            let part = [], i = 0;
            changeStatus(`Building request packets for seeding -- part: ${ i }`);

            setTimeout(() => {
                studentList.forEach(row => {
                    if (part.length == 100) {
                        parts.push(part);
                        part = [], i++;
                        changeStatus(`Building request packets for seeding -- part: ${ i }`); }

                    part.push(deepCopy(row)); });

                    if (part.length != 0) {
                        i++;
                        parts.push(part); }
                changeStatus(`Completed creating request packets -- total parts: ${ i }`);
            }, 100);

        }

        const seedPart = () => {
            changeStatus(`Seeding part ${ requestIndex }`);

            setTimeout(() => {
                postData();
            }, 100);
        }

        const postData = () => {
            fetch("{{ route('student-map-seeder') }}", {
                headers: {
                    "Content-Type": "application/json",
                    "Accept": "application/json, text-plain, */*",
                    "X-Requested-With": "XMLHttpRequest",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    },
                method: 'post',
                credentials: "same-origin",
                body: JSON.stringify({
                    data: parts[requestIndex],
                })
            }).then(response => {
                return response.json();
            }).then(data => {
                requestIndex++;
                console.log(data);

                if (requestIndex < parts.length) {
                    seedPart();
                } else {
                    document.getElementById('spinner').style.display = 'none';
                    changeStatus(`Completed seeding ${ requestIndex } parts`);
                }
            }).catch(error => {
                console.log(error.json());
            });
        }

        const deepCopy = inObject => {
            let outObject, value, key;
            if (typeof inObject !== "object" || inObject === null) { return inObject; }
            outObject = Array.isArray(inObject) ? [] : {};
            for (key in inObject) { value = inObject[key]; outObject[key] = deepCopy(value); }
            return outObject;
        }
    </script>
@endsection