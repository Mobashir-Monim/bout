<script>
    let skeleton = {};
    let parts = [{type: 'skeleton', dept: null, course: null, section: null, data: skeleton}];
    let startingIndex = 0;
    let maxParts = 0;

    const containerizer = (cont, checks = []) => {
        let temp = {};

        for (let p in cont) {
            let flag = true;
            checks.forEach(check => { flag &&= (p != check); });

            if (flag) {
                temp[p] = deepCopy(cont[p]);
            }
        }

        return window.btoa(unescape(encodeURIComponent(JSON.stringify(temp))));
    }

    const segregateParts = () => {
        console.log('Segregating results for export');
        let out = document.getElementById('spinner');
        out.innerHTML = '<div class="mt-2 spinner-border" role="status"><span class="sr-only">Loading...</span></div>';
        
        setTimeout(() => {
            startingIndex = 0;

            for (let d in evaluationResults) {
                skeleton[d] = {};

                for (let c in evaluationResults[d].courses) {
                    skeleton[d][c] = {};

                    for (let l in evaluationResults[d].courses[c].labs) {
                        if (!skeleton[d][c].hasOwnProperty('labs')) {
                            skeleton[d][c].labs = [];
                        }

                        skeleton[d][c].labs.push(l);
                        parts.push({type: 'lab', dept: d, course: c, section: l, data: containerizer(evaluationResults[d].courses[c].labs[l])});
                    }

                    for (let s in evaluationResults[d].courses[c].sections) {
                        if (!skeleton[d][c].hasOwnProperty('sections')) {
                            skeleton[d][c].sections = [];
                        }

                        skeleton[d][c].sections.push(s);
                        parts.push({type: 'section', dept: d, course: c, section: s, data: containerizer(evaluationResults[d].courses[c].sections[s])});
                    }

                    parts.push({type: 'course', dept: d, course: c, section: null, data: containerizer(evaluationResults[d].courses[c], ['sections', 'labs'])});
                }

                parts.push({type: 'dept', dept: d, course: null, section: null, data: containerizer(evaluationResults[d], ['courses'])});
            }

            parts[0].data = window.btoa(unescape(encodeURIComponent(JSON.stringify(parts[0].data))));
            let max = 0, avgP = 0;

            parts.forEach(p => {
                let t = JSON.stringify(p).length;
                avgP += t;
                if (t > max) { max = t; }
            });

            avgP /= parts.length;
        }, 100);
    }

    $("#downloader").click(function(){
        console.log('Initiating download');
        storeResults();
        // saveAs(new Blob([s2ab(downloadResults())],{type:"application/octet-stream"}), "{{ $helper->year . '-' . $helper->semester }}-eval-results.xlsx");
    });

    const s2ab = s => {
        var buf = new ArrayBuffer(s.length);
        var view = new Uint8Array(buf);
        for (var i=0; i!=s.length; ++i) view[i] = s.charCodeAt(i) & 0xFF;
        return buf;
    }

    const storeResults = () => {
        // var ws = XLSX.utils.json_to_sheet(parts);
        // var wb = XLSX.utils.book_new();
        // XLSX.utils.book_append_sheet(wb, ws, "Results");
        // var wbout = XLSX.write(wb, {bookType:'xlsx', type:'binary'});
        
        // return wbout;
        
        fetch("{{ route('course-eval.evaluate.store', ['year' => $helper->year, 'semester' => $helper->semester]) }}", {
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
                console.log(response)
                return response.json();
            }).then(data => {
                console.log(data);

                if (startingIndex < parts.length) {
                    setTimeout(() => {
                        storeResults();
                    }, 1000);
                } else {
                    alert('Completed Uploading to server');
                    // window.location.href = "{!! route('eval') . '?year=' . $helper->year . '&semester=' . $helper->semester !!}";
                }
            }).catch(error => {
                console.log(error);
                alert('Whoop! Something went wrong, please refresh the page and try again');
            });
    }

    const generateParts = () => {
        let temp = [], max = 32, i = 0;

        for (; (i + startingIndex - 1) < parts.length && max > 0; i++, max--) {
            temp.push(deepCopy(parts[i + startingIndex - 1]));
        }
        
        startingIndex += 32;
        
        return temp;
    }
</script>
