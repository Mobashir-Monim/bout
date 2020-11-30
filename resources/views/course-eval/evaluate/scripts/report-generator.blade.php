<script>
    let rsl = document.getElementById('report_type');
    let dsl = document.getElementById('department');
    let csl = document.getElementById('course');
    let ssl = document.getElementById('section');

    const showReportGenOptions = () => {
        document.getElementById('report-options').classList.remove('hidden');
    }

    const populateDeptSelectList = () => {
        for (d in evaluationResults) {
            dsl.innerHTML += `<option value="${ d }">${ d }</option>`;
        }
    }

    const showRepFields = () => {
        if (rsl.value == '') {
            hideEl(csl);
            hideEl(ssl);
        } else if (rsl.value == 'dept') {
            hideEl(csl);
            hideEl(ssl);
        } else if (rsl.value == 'course') {
            unhideEl(csl);
            hideEl(ssl);
        } else {
            unhideEl(csl);
            unhideEl(ssl);
        }
    }

    const hideEl = el => {
        if (!el.classList.contains('hidden')) {
            el.classList.add('hidden');
        }
    }

    const unhideEl = el => {
        if (el.classList.contains('hidden')) {
            el.classList.remove('hidden');
        }
    }

    const showDeptCourseList = () => {
        csl.innerHTML = `<option value="">Please select a course</option>`

        for (c in evaluationResults[dsl.value].courses) {
            csl.innerHTML += `<option value="${ c }">${ c }</option>`;
        }
    }

    const showCourseSectionList = () => {
        ssl.innerHTML = `<option value="">Please select a section</option>`

        for (s in evaluationResults[dsl.value].courses[csl.value].sections) {
            ssl.innerHTML += `<option value="${ s }">Section ${ s }</option>`;
        }
    }
</script>