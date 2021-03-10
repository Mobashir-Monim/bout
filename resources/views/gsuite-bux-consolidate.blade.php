@extends('layouts.dashboard')

@section('content')
    <div class="row">
        <div class="col-md">
            <input type="file" name="pre" id="pre" class="form-control" accept=".xlsx, .xls">
        </div>
        <div class="col-md">
            <input type="file" name="con" id="con" class="form-control" accept=".xlsx, .xls">
        </div>
    </div>
    <div class="row">
        <div class="col-md my-3">
            <button class="btn btn-primary w-100" onclick="downloadConData()" id="download-btn-1" style="display: none;">Download consolidated List</button>
        </div>
        <div class="col-md my-3">
            <button class="btn btn-primary w-100" onclick="downloadUnData()" id="download-btn-2" style="display: none;">Download unidentifiable List</button>
        </div>
        <div class="col-md text-right" id="spinner">

        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.16.0/jszip.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.16.0/xlsx.js"></script>
    <script>
        // let consolidatedHeader = ['name', 'gsuite', 'ref', 'id', 'gsuite-username', 'non-gsuite', 'non-gsuite-username'];
        // let consolidated = [];
        let preHeader = null;
        let pre = [];
        let conHeader = null;
        let con = [];
        let unidentifiable = [];

        $("input#pre").change(function () {
            readFile('pre');
        });

        $("input#con").change(function () {
            readFile('con');
        });

        function readFile(file) {
            let fileInput = document.getElementById(file);
            let out = document.getElementById('spinner');
            out.innerHTML = '<div class="mt-2 spinner-border" role="status"><span class="sr-only">Loading...</span></div>';
            setTimeout(() => {
                let reader = new FileReader();

                reader.onload = function () {
                    exelToJSON(reader.result, out, file);
                };

                reader.readAsBinaryString(fileInput.files[0]);
            }, 100);
        };

        function exelToJSON(data, out, file) {
            let cfb = XLSX.read(data, {type: 'binary'});
                
            cfb.SheetNames.forEach(function(sheetName) {   
                let oJS = XLS.utils.sheet_to_json(cfb.Sheets[sheetName]);
                let result = [];
                let headers = Object.keys(oJS[0]);

                for (let index = 0; index < oJS.length; index++) {
                    let imm = {};

                    headers.forEach(key => {
                        imm[key] = oJS[index][key] != undefined ? oJS[index][key].toString() : oJS[index][key];
                    });

                    result.push(imm);
                }

                if (file == "pre") {
                    preHeader = headers;
                    pre = result;
                } else if (file == "con") {
                    conHeader = headers;
                    con = result;
                }

                if (preHeader != null && conHeader != null) {
                    consolidateList();
                }


                out.innerHTML = "";
            });
        }

        const consolidateList = () => {
            pre.forEach(row => {
                let flag = true;

                if (con.find(r => { return r.gsuite.includes(row.email) }) != null) {
                    con.find(r => { return r.gsuite.includes(row.email) })['gsuite-username'] = row.username;
                    flag = false;
                }

                if (con.find(r => { return r.ref.includes(row.email) }) != null) {
                    con.find(r => { return r.ref.includes(row.email) })['non-gsuite'] = row.email;
                    con.find(r => { return r.ref.includes(row.email) })['nongsuite-username'] = row.username;
                    flag = false;
                }

                if (flag) {
                    if (!row.email.endsWith('@bracu.ac.bd')) {
                        unidentifiable.push({'username': row.username, 'email': row.email, 'name': row.name})
                    }
                }
            });

            document.getElementById('download-btn-1').style.display = 'inline-block';
            document.getElementById('download-btn-2').style.display = 'inline-block';
        }

        const copyToConsolidated = (rows, rIdentifier, rGsuite, rEmail, rName) => {
            rows.forEach(row => {
                let flag = consolidated.filter(r => { return (r.id == row[rIdentifier] || r.gsuite == row.rGsuite) }).length == 0;

                if (flag) {
                    consolidated.push({'id': row[rIdentifier], 'gsuite': row[rGsuite], 'name': row[rName], 'ref': row[rEmail]});
                }
            })
        }

        const deepCopy = inObject => {
            let outObject, value, key;
            if (typeof inObject !== "object" || inObject === null) { return inObject; }
            outObject = Array.isArray(inObject) ? [] : {};
            for (key in inObject) { value = inObject[key]; outObject[key] = deepCopy(value); }
            return outObject;
        }

        const downloadConData = () => {
            let resultingWS = XLSX.utils.json_to_sheet(con); 
            let wb = XLSX.utils.book_new();
            XLSX.utils.book_append_sheet(wb, resultingWS, 'buX-USIS-gsuite');   
            XLSX.writeFile(wb, 'buX-USIS-gsuite.xlsx');
        }

        const downloadUnData = () => {
            let resultingWS = XLSX.utils.json_to_sheet(unidentifiable); 
            let wb = XLSX.utils.book_new();
            XLSX.utils.book_append_sheet(wb, resultingWS, 'buX-USIS-gsuite-unidentifiable');   
            XLSX.writeFile(wb, 'buX-USIS-gsuite-unidentifiable.xlsx');
        }
    </script>
@endsection