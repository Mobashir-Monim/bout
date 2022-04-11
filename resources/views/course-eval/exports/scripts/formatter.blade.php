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
                const numbers = sections.map(({ section }) => section);

                for (let s in numbers) {
                    exportable.depts[d].courses[c].sections.push(
                        formatSection(
                            sections.filter(sec => sec.section === numbers[s]),
                            exportable.depts[d].formula
                        )
                    );
                }
            }
        }
    }

    const formatDepartment = index => {
        return {
            name: stats.values.progress.department[index].dept,
            eval: parseEval(stats.values.progress.department[index].value),
            formula: JSON.parse(stats.values.progress.department[index].score_expression),
            courses: []
        };
    }

    const formatCourse = course => {
        return {
            course: course.code,
            coordinator: formatFaculty(course, 'coordinator'),
            eval: parseEval(course.evaluation),
            sections: []
        };
    }

    const formatSection = (sections, formula) => {
        let faculty = {theory: [], lab: []};
        let eval = {theory: null, lab: null};
        let score = {theory: null, lab: null};

        for (let s in sections) {
            let key = sections[s].is_lab_faculty ? 'lab' : 'theory';
            faculty[key].push(formatFaculty(sections[s], 'name'));
            eval[key] = parseEval(sections[s].evaluation);
            
            if (formula !== null && eval.lab !== null) {
                score[key] = calculateScore(eval[key].cats, formula[key]);
            }
        }

        return {
            section: sections[0].section,
            theory: faculty.theory,
            lab: faculty.lab,
            score: score,
            eval: eval
        };
    }

    const formatFaculty = (cont, key) => {
        return {
            name: cont[key],
            email: cont.email,
            initial: cont.initials
        }
    }

    const parseEval = (eval) => {
        let evaluation = null;

        try {
            evaluation = JSON.parse(eval);
        } catch (error) {}


        return evaluation
    }

    const calculateScore = (cats, exp) => {
        let score = null;
        if (cats !== null && exp !== null && exp !== '') {
            score = math.evaluate(unmarkExpression(exp), buildScope(cats, exp));
            score = typeof(score) != 'object' ? score.toFixed(2) : score.entries[0].toFixed(2);
        }

        return score;
    }
    
    const unmarkExpression = (exp) => {
        return exp.replaceAll('$', '');
    }

    const buildScope = (cats, exp) => {
        let scope = {};

        for (let f in exportable.factors) {
            if (exp.includes(`$${ f }$`)) {
                if (cats.hasOwnProperty(f)) {
                    scope[f] = cats[f];
                } else {
                    scope[f] = 0;
                }
            }
        }

        return scope;
    }
</script>

{{-- non bengli speakers around the world
non-degree certificate --}}

{{-- CFO feed back --}}