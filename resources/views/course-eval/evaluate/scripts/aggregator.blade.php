<script>
    const aggregateDeptCourseScores = () => {
        for (d in evaluationResults) { aggregateContParts(evaluationResults[d].courses, 'sections', true); }
        aggregateContParts(evaluationResults, 'courses');

        for (d in evaluationResults) {
            averageValues(evaluationResults[d]);

            for (c in evaluationResults[d].courses) {
                averageValues(evaluationResults[d].courses[c]);
                
                for (s in evaluationResults[d].courses[c].sections) {
                    averageValues(evaluationResults[d].courses[c].sections[s]);
                }
            }
        }

        rankAll();
        // showReportGenOptions();
        segregateParts();
        storeResults();
    }

    const aggregateContParts = (cL, contName, flag = false) => {
        for (c in cL) {
            let temp = cct(), segment = cL[c];

            for (part in segment[contName]) {
                for (cat in segment.cats) { temp[cat] += segment[contName][part].cats[cat]; }
                segment.respondents += segment[contName][part].respondents;
                            
                if (flag) {
                    qStatAgSec(segment, part);
                    segment[contName][part].students = usisReg.filter(reg => { return reg["Course_ID"] == segment.name && reg["section"] == segment[contName][part].section }).length;
                } else {
                    segment.students += segment[contName][part].students;
                }
            }

            if (flag) {
                segment.students = usisReg.filter(reg => { return reg["Course_ID"] == segment.name }).length;
            }

            for(cat in temp) { segment.cats[cat] = temp[cat] };
        }
    }

    const averageValues = (cont, temp = null) => {
        for (cat in cont.cats) {
            if (temp != null) {
                cont.cats[cat] = temp[cat];
            }

            cont.cats[cat] /= cont.respondents;
        }
    }

    const addToCourse = (temp, templ, cs, cl) => {
        Object.keys(cs.cats).forEach(cat => {
            cs.cats[cat] += temp[cat];
        })

        if (templ != null) {
            Object.keys(templ.cats).forEach(key => {
                cl.cats[key] += templ.cats[key];
            })
            
            templ.lfs.forEach(fac => {
                cl.lfs.push(deepCopy(fac))
            })

            cl.respondents += 1;
        }
        
        cs.respondents += 1;
    }

    const qStatAg = (cont, q, op, mult = 1) => {
        if (!cont.qStat.hasOwnProperty(q)) {
            cont.qStat[q] = {};
        }

        if (!cont.qStat[q].hasOwnProperty(op)) {
            cont.qStat[q][op] = 0;
        }

        cont.qStat[q][op] += 1 * mult;
    }

    const qStatAgSec = (course, section) => {
        for (q in course.sections[section].qStat) {
            for (op in course.sections[section].qStat[q]) {
                qStatAg(course, q, op, course.sections[section].qStat[q][op]);
            }
        }
    }

    const segregateSections = () => {
        for (c in courseList) {

        }
    }

    const aggregateSectionComments = (cont, row, qCont) => {
        for (q in qCont) {
            if (const.comments.hasOwnProperty(q)) {
                cont.comments[q] = [];
            }

            cont.comments[q].push(row[q]);
        }
    }
</script>