<script>
    let questionMatrix = null;
    let parts = [];
    let startingIndex = 0;

    $("input#bulk_upload").change(function () {
        readFile('bulk_upload');
    });

    function readFile(file) {
        let fileInput = document.getElementById(file);
        document.getElementById('spinner').innerHTML = '<div class="mt-2 spinner-border" role="status"><span class="sr-only">Loading...</span></div>';
        setTimeout(() => {
            let reader = new FileReader();

            reader.onload = function () {
                exelToJSON(reader.result);
            };

            reader.readAsBinaryString(fileInput.files[0]);
        }, 100);
    };

    function exelToJSON(data) {
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

            structureMatrix(result);
            segregateParts();
            storeMatrix();
            document.getElementById('spinner').innerHTML = '';
        });
    }

    const structureMatrix = m => {
        try {
            let structured = {};
            
            for (let index = 0; index < m.length;) {
                let q = m[index].question, t = m[index].type, c = m[index].calc;
                let options = {}, opts = m.filter(r => r.question == m[index].question);
                opts.forEach(opt => {
                    options[opt.options] = JSON.parse(`{${ quoteAnalysisMatrix(opt.analysis) }}`);
                })

                structured[q] = {"type": t, "calc": c, "options": options}
                index += opts.length;
            }

            questionMatrix = structured;
        } catch (error) {
            console.log(error);
            alert('Whoops! Seems like there is something wrong in the file. Please check it carefully');
        }
    }

    const quoteAnalysisMatrix = analysis => {
        if (analysis == undefined || analysis == null || analysis == NaN || analysis == "") {
            return '';
        }

        analysis = analysis.replaceAll(' ', '').split(',').filter(a => a != "");

        for (let i = 0; i < analysis.length; i++) {
            analysis[i] = analysis[i].split(':');
            analysis[i][0] = `"${ analysis[i][0] }"`;
            analysis[i][1] = parseFloat(analysis[i][1]);
            analysis[i] = analysis[i].join(':');
        }

        return analysis.join(',');
    }

    const segregateParts = () => {
        parts = JSON.stringify(questionMatrix).match(/.{1,65000}/g);
    }

    const storeMatrix = () => {
        fetch("{{ route('course-eval.matrix-config', ['year' => $helper->year, 'semester' => $helper->semester]) }}", {
                headers: {
                    "Content-Type": "application/json",
                    "Accept": "application/json, text-plain, */*",
                    "X-Requested-With": "XMLHttpRequest",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    },
                method: 'post',
                credentials: "same-origin",
                body: JSON.stringify({
                    starting_index: startingIndex,
                    parts: generateParts(),
                })
            }).then(response => {
                return response.json();
            }).then(data => {
                console.log(data);

                if (startingIndex < parts.length) {
                    storeMatrix();
                } else {
                    window.location.href = "{{ route('course-eval.matrix-config', ['year' => $helper->year, 'semester' => $helper->semester]) }}";
                }
            }).catch(error => {
                console.log(error);
                // alert('Whoop! Something went wrong, please refresh the page and try again');
            });
    }

    const generateParts = () => {
        let temp = [], max = 32;

        for (let i = 0; (i + startingIndex) < parts.length && max > 0; i++, max--) {
            temp.push(parts[i + startingIndex]);
        }

        startingIndex += 32;
        
        return temp;
    }
</script>