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

{{-- SQLSTATE[22001]:
String data, right truncated: 1406 Data too long for column 'id' at row 1
(SQL: insert into `students` (`id`, `name`, `updated_at`, `created_at`)
values (3a2b9078-9397-4676-b558-7e4448ae0cd1, Chathuri Weerasinghe, 2020-11-08 19:10:38, 2020-11-08 19:10:38)) --}}

{{-- SQLSTATE[01000]:
Warning: 1265 Data truncated for column 'student_id' at row 1
(SQL: insert into `student_maps` (`student_id`, `email`, `username`, `id`, `updated_at`, `created_at`)
values (1930 1278, raad.hasan@g.bracu.ac.bd, 19301278.raad.hasan, 82f6440d-c37f-46a0-90e3-968a02ad1f00, 2020-11-08 19:11:40, 2020-11-08 19:11:40)) --}}

{{-- SQLSTATE[22001]:
String data, right truncated: 1406 Data too long for column 'id' at row 1
(SQL: insert into `students` (`id`, `name`, `updated_at`, `created_at`)
values (20121074(Cancelled admission Replied on Mar21 2:56AM), SANJANA FYRUJ ANANNA, 2020-11-08 19:11:51, 2020-11-08 19:11:51)) --}}

{{-- SQLSTATE[23000]:
Integrity constraint violation: 1062 Duplicate entry 'ramiz.ihteshamur.rahman@g.bracu.ac.bd' for key 'student_maps_email_unique'
(SQL: insert into `student_maps` (`student_id`, `email`, `username`, `id`, `updated_at`, `created_at`)
values (20366010, ramiz.ihteshamur.rahman@g.bracu.ac.bd, 20366010.ramiz.rahman, a0330150-0626-4cf5-a58c-3f138e3bbdd6, 2020-11-08 19:12:13, 2020-11-08 19:12:13)) --}}

{{-- SQLSTATE[23000]:
Integrity constraint violation: 1062 Duplicate entry 'tamjid.islam@g.bracu.ac.bd' for key 'student_maps_email_unique'
(SQL: insert into `student_maps` (`student_id`, `email`, `username`, `id`, `updated_at`, `created_at`)
values (20201064, tamjid.islam@g.bracu.ac.bd, 20201064.Tamjid, ae69a845-9408-4216-81c1-583faf95ac41, 2020-11-08 19:12:13, 2020-11-08 19:12:13)) --}}

{{-- SQLSTATE[23000]:
Integrity constraint violation: 1062 Duplicate entry 'saamin.bin.iqbal@g.bracu.ac.bd' for key 'student_maps_email_unique'
(SQL: insert into `student_maps` (`student_id`, `email`, `username`, `id`, `updated_at`, `created_at`)
values (20204024, saamin.bin.iqbal@g.bracu.ac.bd, Saamin, b9e2e4fb-aa0e-49ff-9302-0ec8b62a5024, 2020-11-08 19:12:17, 2020-11-08 19:12:17)) --}}

{{-- SQLSTATE[23000]:
Integrity constraint violation: 1062 Duplicate entry 'asm.hafizul.islam@g.bracu.ac.bd' for key 'student_maps_email_unique'
(SQL: insert into `student_maps` (`student_id`, `email`, `username`, `id`, `updated_at`, `created_at`)
values (20274004, asm.hafizul.islam@g.bracu.ac.bd, Hafizul Islam, e773552d-32a5-44ea-8b6c-6d4b2d0c2e87, 2020-11-08 19:12:30, 2020-11-08 19:12:30)) --}}

{{-- SQLSTATE[23000]:
Integrity constraint violation: 1062 Duplicate entry 'ahnaf.akif@g.bracu.ac.bd' for key 'student_maps_email_unique'
(SQL: insert into `student_maps` (`student_id`, `email`, `username`, `id`, `updated_at`, `created_at`)
values (20201006, ahnaf.akif@g.bracu.ac.bd, Ahnaf Akif, 741707d4-333e-4eff-b133-51f273f17977, 2020-11-08 19:31:31, 2020-11-08 19:31:31)) --}}

{{-- SQLSTATE[23000]:
Integrity constraint violation: 1062 Duplicate entry 'tasnim.ferdous.nishat@g.bracu.ac.bd' for key 'student_maps_email_unique'
(SQL: insert into `student_maps` (`student_id`, `email`, `username`, `id`, `updated_at`, `created_at`)
values (20201100, tasnim.ferdous.nishat@g.bracu.ac.bd, tasnimferdous12, 2286ed85-5f41-4436-a2ba-c9be5da92608, 2020-11-08 19:31:31, 2020-11-08 19:31:31)) --}}

{{-- SQLSTATE[23000]:
Integrity constraint violation: 1062 Duplicate entry 'emon.hossen.jony@g.bracu.ac.bd' for key 'student_maps_email_unique'
(SQL: insert into `student_maps` (`student_id`, `email`, `username`, `id`, `updated_at`, `created_at`)
values (20201045, emon.hossen.jony@g.bracu.ac.bd, Leviackerman, 88060fea-707e-461b-970c-2f4ace2ad2c0, 2020-11-08 19:41:26, 2020-11-08 19:41:26)) --}}

{{-- SQLSTATE[23000]:
Integrity constraint violation: 1062 Duplicate entry 'abir.chowdhury1@g.bracu.ac.bd' for key 'student_maps_email_unique'
(SQL: insert into `student_maps` (`student_id`, `email`, `username`, `id`, `updated_at`, `created_at`)
values (20201112, abir.chowdhury1@g.bracu.ac.bd, Abir Chowdhury, 07f9e95b-0ed6-4dc9-b0f2-7ae40c974e6f, 2020-11-08 19:41:26, 2020-11-08 19:41:26)) --}}

{{-- SQLSTATE[23000]:
Integrity constraint violation: 1062 Duplicate entry 'md.rakibul.islam8@g.bracu.ac.bd' for key 'student_maps_email_unique'
(SQL: insert into `student_maps` (`student_id`, `email`, `username`, `id`, `updated_at`, `created_at`)
values (20201114, md.rakibul.islam8@g.bracu.ac.bd, Rakibul94, 91e36c2c-2736-40f2-934b-bb8a6013e8a5, 2020-11-08 19:47:22, 2020-11-08 19:47:22)) --}}

{{-- SQLSTATE[23000]:
Integrity constraint violation: 1062 Duplicate entry 'samia.tasnim.orpa@g.bracu.ac.bd' for key 'student_maps_email_unique'
(SQL: insert into `student_maps` (`student_id`, `email`, `username`, `id`, `updated_at`, `created_at`)
values (20201115, samia.tasnim.orpa@g.bracu.ac.bd, 20201115.samia.tasnim.orpa, 2e7484e9-f3ea-4d7c-a205-3237aa1a6b2f, 2020-11-08 19:48:59, 2020-11-08 19:48:59)) --}}