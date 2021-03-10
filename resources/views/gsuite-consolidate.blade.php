@extends('layouts.dashboard')

@section('content')
    <div class="row">
        <div class="col-md">
            <input type="file" name="pre" id="pre" class="form-control" accept=".xlsx, .xls">
        </div>
        <div class="col-md">
            <input type="file" name="con" id="con" class="form-control" accept=".xlsx, .xls">
        </div>
        <div class="col-md">
            <input type="file" name="pos" id="pos" class="form-control" accept=".xlsx, .xls">
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 my-3">
            <button class="btn btn-primary w-100" onclick="downloadCrunchedData()" id="download-btn" style="display: none;">Download User List</button>
        </div>
        <div class="col-md-6 text-right" id="spinner">

        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.16.0/jszip.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.16.0/xlsx.js"></script>
    <script>
        let consolidatedHeader = ['name', 'gsuite', 'ref', 'id'];
        let consolidated = [];
        let preHeader = null;
        let pre = [];
        let conHeader = null;
        let con = [];
        let posHeader = null;
        let pos = [];


        $("input#pre").change(function () {
            readFile('pre');
        });

        $("input#con").change(function () {
            readFile('con');
        });

        $("input#pos").change(function () {
            readFile('pos');
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
                } else if (file == "pos") {
                    posHeader = headers;
                    pos = result;
                }

                if (preHeader != null && conHeader != null && posHeader != null) {
                    consolidateList();
                }


                out.innerHTML = "";
            });
        }

        const consolidateList = () => {
            pre = pre.filter(row => { return row["Home Secondary Email"] });
            copyToConsolidated(pre, "Employee ID", "Email Address [Required]", "Home Secondary Email", "Full Name");
            con = con.filter(row => { return row["EMAIL"] });
            copyToConsolidated(con, "ID", "G suite Email", "EMAIL", "NAME");
            pos = pos.filter(row => { return row["EMAIL"] });
            copyToConsolidated(pos, "STUDENT ID", "G suite Email", "EMAIL", "NAME");
            document.getElementById('download-btn').style.display = 'inline-block';
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

        const downloadCrunchedData = () => {
            let resultingWS = XLSX.utils.json_to_sheet(consolidated); 
            let wb = XLSX.utils.book_new();
            XLSX.utils.book_append_sheet(wb, resultingWS, 'BracU student List');   
            XLSX.writeFile(wb, 'BracU student List.xlsx');
        }
    </script>
@endsection