<script>
    const departmentFormat = {
        name: "",
        eval: {},
        formula: "",
        courses: []
    }

    const courseFormat = {
        course: "",
        coordinator: null,
        eval: {},
        sections: []
    }

    const sectionFormat = {
        section: "",
        theory: [],
        lab: [],
        score: "",
        eval: {}
    }

    const facultyFormat = {
        name: "",
        email: "",
        initial: ""
    }

    const formatExportable = () => {
        for (let d in stats.values.progress.department) {
            exportable.depts.push(formatDepartment(d));
            const courses = stats.values.progress.course.filter(course => course.department === stats.values.progress.department[d].dept);
            
            for (let c in courses) {
                exportable.depts[d].courses.push(formatCourse(courses[c]));
                const sections = stats.values.progress.section.filter(section => section.offered_course_id === courses[c].id);

                for (let s in sections) {

                }
            }
        }
    }

    const formatDepartment = index => {
        return {
            name: stats.values.progress.department[index].dept,
            eval: stats.values.progress.department[index].value,
            formula: stats.values.progress.department[index].score_expression,
            courses: []
        };
    }

    const formatCourse = course => {
        return {
            course: course.code,
            coordinator: {
                name: course.coordinator,
                email: course.email,
                initial: course.initials
            },
            eval: course.evaluation,
            sections: []
        };
    }

    const formatSection = section => {

    }
</script>