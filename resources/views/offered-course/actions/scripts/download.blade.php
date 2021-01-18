<script>
    const downloadDept = document.getElementById('download-dept');
    const downloadSpinner = document.getElementById('download-spinner');
    const template = [{
        department: "",
        code: "",
        title: "",
        section: "",
        coordinator_faculty_name: "",
        coordinator_faculty_initials: "",
        coordinator_faculty_email: "",
        theory_faculty_name: "",
        theory_faculty_initials: "",
        theory_faculty_email: "",
        lab_faculty_name: "",
        lab_faculty_initials: "",
        lab_faculty_email: "",
        has_lab: "",
        is_lab: ""
    }];

    const downloadAll = () => {
        let downloadable = [];

        for (dept in offeredCourses) {
            for (let c in offeredCourses[dept]) {
                for (let s in offeredCourses[dept][c].sections) {
                    let row = {department: dept, code: c, title: offeredCourses[dept][c].title, section: s};
                    addFaculty('coordinator', {coordinator: [{name: offeredCourses[dept][c].coordinator, initials: offeredCourses[dept][c].initials, email: offeredCourses[dept][c].email}]}, row);
                    addFaculty('theory', offeredCourses[dept][c].sections[s], row);
                    addFaculty('lab', offeredCourses[dept][c].sections[s], row);
                    row['has_lab'] = offeredCourses[dept][c].has_lab;
                    row['is_lab'] = offeredCourses[dept][c].is_lab;
                    downloadable.push(row);
                }
            }
        }

        downloader(downloadable);
    }

    const downloadExistingData = () => {
        let downloadable = [];

        for (let c in offeredCourses[downloadDept.value]) {
            for (let s in offeredCourses[downloadDept.value][c].sections) {
                let row = {department: downloadDept.value, code: c, title: offeredCourses[downloadDept.value][c].title, section: s};
                addFaculty('coordinator', {coordinator: [{name: offeredCourses[downloadDept.value][c].coordinator, initials: offeredCourses[downloadDept.value][c].initials, email: offeredCourses[downloadDept.value][c].email}]}, row);
                addFaculty('theory', offeredCourses[downloadDept.value][c].sections[s], row);
                addFaculty('lab', offeredCourses[downloadDept.value][c].sections[s], row);
                row['has_lab'] = offeredCourses[downloadDept.value][c].has_lab;
                row['is_lab'] = offeredCourses[downloadDept.value][c].is_lab;
                downloadable.push(row);
            }
        }

        return downloadable;
    }

    const addFaculty = (type, cont, row) => {
        let details = {name: '', initials: '', email: ''};
        if (cont.hasOwnProperty(type)) { details = complileFacultyData(cont[type]); }
        row[`${ type }_faculty_name`] = details.name;
        row[`${ type }_faculty_initials`] = details.initials;
        row[`${ type }_faculty_email`] = details.email;
    }

    const complileFacultyData = facultyCont => {
        let details = {name: '', initials: '', email: ''};
        let num = facultyCont.length - 1;

        for (let i = 0; i <= num; i++) {
            let appender = ', ';
            
            if (i == num) { appender = ''; }
            
            details.name = `${ details.name }${ facultyCont[i].name }${ appender }`;
            details.initials = `${ details.initials }${ facultyCont[i].initials }${ appender }`;
            details.email = `${ details.email }${ facultyCont[i].email }${ appender }`;
        }

        return details;
    }

    const downloader = (data = null) => {
        if (downloadDept.value == '' && data == null) {
            alert('Please select a department before trying to download the offered course data');
        } else {
            downloadSpinner.classList.remove('hidden');
            console.log('Initiating download');
            let ws = XLSX.utils.json_to_sheet(data == null ? (Object.keys(offeredCourses).length == 0 ? template : downloadExistingData()) : data);
            let wb = XLSX.utils.book_new();
            XLSX.utils.book_append_sheet(wb, ws, `Offered Courses Details`);
            let wbout = XLSX.write(wb, {bookType:'xlsx', type:'binary'});
            saveAs(new Blob([s2ab(wbout)],{type:"application/octet-stream"}), `${ data == null ? (Object.keys(offeredCourses).length == 0 ? 'Template' : downloadDept.value) : 'All' } {{ $helper->year }} {{ $helper->semester }} Offered Courses Details.xlsx`);
            downloadSpinner.classList.add('hidden');
        }
    }

    $("#downloader").click(() => { downloader() });

    const s2ab = s => {
        let buf = new ArrayBuffer(s.length);
        let view = new Uint8Array(buf);
        for (let i=0; i!=s.length; ++i) view[i] = s.charCodeAt(i) & 0xFF;
        return buf;
    }
</script>