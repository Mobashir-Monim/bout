<script>
    $("input#eval-response").change(function () {
        readFile('eval-response');
    });

    $("input#usis-registrations").change(function () {
        readFile('usis-registrations');
    });

    $("input#gsuite").change(function () {
        readFile('gsuite');
    });

    let evalsHeader = null;
    let evals = [];
    let gsuiteHeader = null;
    let gsuite = [];
    let usisRegHeader = null;
    let usisReg = [];
    let idMap = [];
    let duplicates = [];
    let unverifyable = [];
    let unregistered = [];
    let markers = {
        'course-code-header': null,
        'theory-section-header': null,
        'rs-indicator-header': null,
    };

    const fetchGsuiteList = () => {
        if (gsuite.length == 0) {
            console.log('Initiating G-suite fetch');
            let out = document.getElementById('spinner');
            out.innerHTML = '<div class="mt-2 spinner-border" role="status"><span class="sr-only">Loading...</span></div>';
        }
        
        fetch("{{ route('student.academic.list') }}", {
                headers: {
                    "Content-Type": "application/json",
                    "Accept": "application/json, text-plain, */*",
                    "X-Requested-With": "XMLHttpRequest",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    },
                method: 'post',
                credentials: "same-origin",
                body: JSON.stringify({
                    data: ['id', 'gsuite_email'],
                    index: gsuite.length == 0 ? 0 : gsuite[gsuite.length - 1].id
                })
            }).then(response => {
                return response.json();
            }).then(data => {
                for (let i in data.results) {
                    gsuite.push(data.results[i]);
                }

                console.log(`Current count: ${ gsuite.length }`)

                if (data.results.length == 100) {
                    fetchGsuiteList();
                } else {
                    let out = document.getElementById('spinner');
                    out.innerHTML = "";
                    gsuiteHeader = ['id', 'gsuite_email'];
                    
                    if (usisRegHeader != null && gsuiteHeader != null && idMap.length == 0) { console.log('Generating ID Map'); generateIDMap(); }
                    if (usisRegHeader != null && evalsHeader != null && gsuiteHeader != null) {
                        document.getElementById('evaluator').classList.remove('hidden');
                    }
                }
            }).catch(error => {
                console.log(error);
            });
    }

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
            let oJS = XLS.utils.sheet_to_json(cfb.Sheets[sheetName], {defval: ""});
            let result = [];
            let headers = Object.keys(oJS[0]);

            for (let index = 0; index < oJS.length; index++) {
                let imm = {};

                if (file == "usis-registrations") {
                    headers.forEach(key => {
                        if (key == "section") {
                            imm[key] = oJS[index][key] != undefined ? parseInt(oJS[index][key].toString().replace(/\s+/g,' ').trim().replace(/\D/g,'')) : oJS[index][key];
                        } else {
                            imm[key] = oJS[index][key] != undefined ? oJS[index][key].toString().replace(/\s+/g,' ').trim() : oJS[index][key];
                        }
                    });
                } else {
                    headers.forEach(key => {
                        if (file == "eval-response" && key == markers['course-code-header']) {
                            imm[key] = oJS[index][key] != undefined ? oJS[index][key].toString().replace(/\s+/g,' ').trim().replaceAll(/\s/g, '').replaceAll('-', '.') : oJS[index][key];
                        } else {
                            imm[key] = oJS[index][key] != undefined ? oJS[index][key].toString().replace(/\s+/g,' ').trim() : oJS[index][key];
                        }
                    });
                }

                if (file == "eval-response") {
                    imm['timed-identifier'] = `${ imm["Identifier"] }-${ imm["Timestamp"] }`;
                }

                result.push(imm);
            }

            if (file == "eval-response") {
                evalsHeader = headers;
                evals = result;
            } else if (file == "usis-registrations") {
                usisRegHeader = headers;
                usisReg = result;
            } else if (file == "gsuite") {
                gsuiteHeader = headers;
                gsuite = result;
            } else {
                parts = result;
                storeResults();
            }

            if (usisRegHeader != null && gsuiteHeader != null && file != 'backup' && idMap.length == 0) { console.log('Generating ID Map'); generateIDMap(); }
            if (usisRegHeader != null && evalsHeader != null && gsuiteHeader != null && file != 'backup') {
                document.getElementById('evaluator').classList.remove('hidden');
            }


            out.innerHTML = "";
        });
    }

    const startEvaluating = () => {
        document.getElementById('evaluator').classList.add('hidden');
        document.getElementById('spinner').innerHTML = '<div class="mt-2 spinner-border" role="status"><span class="sr-only">Loading...</span></div>';
        setTimeout(() => {
            console.log('Preprocessing Data for analysis');
            setEvalSections();
            findDuplicates();
            analyzeCourseSection();
            document.getElementById('spinner').innerHTML = '';
        }, 100);
    }

    function setEvalSections() {
        evals.forEach(eRow => {
            row = idMap.find(r => { return (eRow["Email Address"] == r.email && eRow[markers['course-code-header']].includes(r.course)) });
            
            if (row != undefined) {
                eRow[markers['theory-section-header']] = row.section;
            } else {
                eRow[markers['theory-section-header']] = 'Not registered';
            }

            if (gsuite.filter(r => { return eRow["Email Address"] == r["gsuite_email"] })[0]) {
                eRow["id"] = gsuite.filter(r => { return eRow["Email Address"] == r["gsuite_email"] })[0]["id"];
            } else {
                unverifyable.push(eRow);
            }
        })

        removeUnverifiables();
    }

    function removeUnverifiables() {
        unverifyable.forEach(u => {
            let index = evals.map(item => item["timed-identifier"]).indexOf(u["timed-identifier"]);
            evals.splice(index, 1);
        })

        removeUnregistered();
    }

    function removeUnregistered() {
        evals.filter(row => { return row[markers['theory-section-header']] == 'Not registered'; }).forEach(u => {
            unregistered.push(u);
            let index = evals.map(item => item["timed-identifier"]).indexOf(u["timed-identifier"]);
            evals.splice(index, 1);
        })
    }

    function buildUnverifiableTable() {
        let header = Object.keys(unverifyable[0]);
        let table = '<table class="table"><thead><tr>';

        header.forEach(key => {
            table = `${ table }<th scope="col">${ key }</th>`;
        })

        table = `${ table }</tr><tbody>`;

        unverifyable.forEach(row => {
            table = `${ table }<tr>`;

            header.forEach(key => {
                table = `${ table }<td>${ row[key] }</td>`;
            })

            table = `${ table }</tr>`;
        })

        document.getElementById('unv-out').innerHTML = table;
    }

    function findDuplicates() {
        evals.forEach(row => {

            let rows = evals.filter(r => { return r[evalsHeader[3]] == row[evalsHeader[3]] });
            if (rows.length > 1 && duplicates.filter(d => { return d.email == rows[0]["Email Address"] }).length == 0) {
                duplicates.push({id: rows[0]["id"], email: rows[0]["Email Address"], course: rows[0][markers['course-code-header']], count: rows.length, section: rows[0]['Section Number']});
                rows.shift();
                rows.forEach(dup => {
                    let index = evals.map((item) => item["timed-identifier"]).indexOf(dup["timed-identifier"]);
                    evals.splice(index, 1);
                })
            }
        })

        // printDuplicatesTable();
    }

    function printDuplicatesTable() {
        let str = `<table class="table"><thead><tr><th scope="col">Student ID</th><th scope="col">Email Address</th><th scope="col">Course</th><th scope="col">Times</th><th scope="col">Section</th></tr></thead><tbody>`;
        
        duplicates.forEach(d => {
            str += `<tr><td>${ d.id }</td><td>${ d.email }</td><td>${ d.course }</td><td>${ d.count }</td><td>${ d.section }</td></tr>`;
        })

        str += `</tbody></table>`;
        document.getElementById('dup-out').innerHTML = str;
    }

    function generateIDMap() {
        gsuite.forEach(row => {
            let sRegs = usisReg.filter(function (reg) { return reg["Student_ID"] == row["id"] });

            if (sRegs.length > 0) {
                sRegs.forEach(reg => {
                    idMap.push({id: row["id"], email: row["gsuite_email"], course: reg["Course_ID"], section: reg["section"]})
                })
            }
        })
    }

    const setMarkers = () => {
        let cch = document.getElementById('course-code-header');
        let tsh = document.getElementById('theory-section-header');
        let rih = document.getElementById('rs-indicator-header');
        markers['course-code-header'] = cch.value;
        markers['theory-section-header'] = tsh.value;
        markers['rs-indicator-header'] = rih.value == "" ? null : rih.value;
        showEvalDataInputs();
    }

    const showEvalDataInputs = () => {
        let evalDataInps = document.getElementsByClassName('eval-data-inp');
        let evalDataSelectors = document.getElementsByClassName('eval-data-selector');

        Array.from(evalDataInps).forEach(evalDataInp => {
            evalDataInp.classList.remove('hidden');
        });

        Array.from(evalDataSelectors).forEach(evalDataSelector => {
            evalDataSelector.classList.add('hidden');
        });
    }
</script>