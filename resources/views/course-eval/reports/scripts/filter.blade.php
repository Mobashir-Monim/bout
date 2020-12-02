<script>
    const selectable = {!! json_encode($helper->createSelectionList()) !!};
    const dept = document.getElementById('dept');
    const deptBtn = document.getElementById('dept-btn');
    const courseRow = document.getElementById('course-row');
    const course = document.getElementById('course');
    const sectionRow = document.getElementById('section-row');
    const section = document.getElementById('section');
    const labRow = document.getElementById('lab-row');
    const lab = document.getElementById('lab');
    const types = ['dept', 'course', 'section', 'lab'];
    const locations = [dept, course, section, lab];
    const links = {
        dept: "{{ $helper->buildRoute('dept') }}",
        course: "{{ $helper->buildRoute('dept', 'course') }}",
        section: "{{ $helper->buildRoute('dept', 'course', 'section') }}",
        lab: "{{ $helper->buildRoute('dept', 'course', 'section', true) }}",
    };

    const showCourses = () => {
        controlElVisibility(selectable[dept.value], [deptBtn, courseRow]);
        hideEl(sectionRow);
        hideEl(labRow);
        let options = buildOptions(selectable[dept.value], 'course')
        course.innerHTML = options;
    }

    const showSections = () => {
        controlElVisibility(selectable[dept.value][course.value].sections, [sectionRow]);
        let options = buildOptions(selectable[dept.value][course.value].sections, 'section', true);
        section.innerHTML = options;
        showLabs();
    }

    const showLabs = () => {
        controlElVisibility(selectable[dept.value][course.value].labs, [labRow]);
        let options = buildOptions(selectable[dept.value][course.value].labs, 'section', true);
        lab.innerHTML = options;
    }

    const buildOptions = (cont, name, val = false) => {
        let options = `<option value="">Please select a ${ name }</option>`;

        for (c in cont) {
            options = `${ options }<option value="${ c }">${ val ? cont[c] : c }</option>`;
        }

        return options;
    }

    const toggleRow = el => {
        if (el.classList.contains('hidden')) {
            el.classList.remove('hidden');
        } else {   
            el.classList.add('hidden');
        }
    }

    const hideEl = el => {
        if (!el.classList.contains('hidden')) {
            el.classList.add('hidden');
        }
    }

    const showEl = el => {
        if (el.classList.contains('hidden')) {
            el.classList.remove('hidden');
        }
    }

    const controlElVisibility = (cont, els) => {
        if (Object.keys(cont).length < 1) {
            els.forEach(el => {
                hideEl(el);
            });
        } else {
            els.forEach(el => {
                showEl(el);
            });
        }
    }

    const openReport = type => {
        let link = links[type];

        for (let index = 0; index <= types.indexOf(type); index++) {
            link = link.replaceAll(types[index], locations[index].value);
        }

        window.open(link, '_blank')
    }
</script>