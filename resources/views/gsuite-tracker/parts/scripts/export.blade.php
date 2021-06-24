<script>
    let lastID = 0;
    let exportStudents = [];
    let exportBtn = document.getElementById('export-btn');
    let exportSpinner = document.getElementById('export-spinner');

    const initiateExport = () => {
        exportBtn.classList.add('hidden');
        exportSpinner.classList.remove('hidden');
        fetchStudents();
    }

    const fetchStudents = () => {
        fetch(`{{ route('it-team.students.export') }}?last_id=${ lastID }`, {
                headers: {
                    "Content-Type": "application/json",
                    "Accept": "application/json, text-plain, */*",
                    "X-Requested-With": "XMLHttpRequest",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    },
                method: 'get',
                credentials: "same-origin",
            }).then(response => {
                return response.json();
            }).then(data => {
                if (data.success) {
                    if (data.has_more) {
                        for (let i in data.students) {
                            exportStudents.push(data.students[i]);
                            lastID = data.students[i].student_id;
                        }

                        fetchStudents();
                    } else {
                        downloadExportData();
                        exportSpinner.classList.add('hidden');
                        exportBtn.classList.remove('hidden');
                    }
                }
            }).catch(error => {
                console.log(error);
            });
    }

    const downloadExportData = () => {
        let ws = XLSX.utils.json_to_sheet(exportStudents);
        let wb = XLSX.utils.book_new();
        XLSX.utils.book_append_sheet(wb, ws, "Student Data");
        let wbout = XLSX.write(wb, {bookType:'xlsx', type:'binary'});
        saveAs(new Blob([s2ab(wbout)],{type:"application/octet-stream"}), `Student Data - ${ Date.now() }.xlsx`);
    }

    const s2ab = s => {
        let buf = new ArrayBuffer(s.length);
        let view = new Uint8Array(buf);
        for (let i=0; i!=s.length; ++i) view[i] = s.charCodeAt(i) & 0xFF;
        return buf;
    }
</script>