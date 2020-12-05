<script>
    const aggregateDeptCourseScores = () => {
        console.log('Aggregating results and stats');
        for (let d in evaluationResults) { aggregateContParts(evaluationResults[d].courses, 'sections', true); }
        aggregateContParts(evaluationResults, 'courses');

        for (let d in evaluationResults) {
            averageValues(evaluationResults[d]);

            for (let c in evaluationResults[d].courses) {
                averageValues(evaluationResults[d].courses[c]);
                
                for (s in evaluationResults[d].courses[c].sections) {
                    averageValues(evaluationResults[d].courses[c].sections[s]);
                }

                for (let l in evaluationResults[d].courses[c].labs) {
                    averageValues(evaluationResults[d].courses[c].labs[l]);
                }
            }
        }

        rankAll();
        countAll();
    }

    const countAll = () => {
        for (let d in evaluationResults) {
            evaluationResults[d].courseCount = Object.keys(evaluationResults[d].courses).length;
            evaluationResults[d].sectionCount = 0;
            evaluationResults[d].labCount = 0;

            for (let c in evaluationResults[d].courses) {
                evaluationResults[d].courses[c].sectionCount = Object.keys(evaluationResults[d].courses[c].sections).length;
                evaluationResults[d].courses[c].labCount = Object.keys(evaluationResults[d].courses[c].labs).length;
                evaluationResults[d].sectionCount += evaluationResults[d].courses[c].sectionCount;
                evaluationResults[d].labCount += evaluationResults[d].courses[c].labCount;

                for (let s in evaluationResults[d].courses[c].sections) {
                    evaluationResults[d].courses[c].sections[s].sectionCount = evaluationResults[d].courses[c].sectionCount;
                }

                for (let l in evaluationResults[d].courses[c].labs) {
                    evaluationResults[d].courses[c].labs[l].labCount = evaluationResults[d].courses[c].labCount;
                }
            }
        }
    }

    const aggregateContParts = (cL, contName, flag = false) => {
        for (let c in cL) {
            let temp = cct(), segment = cL[c];

            for (let part in segment[contName]) {
                for (let cat in segment.cats) { temp[cat] += segment[contName][part].cats[cat]; }
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

            for(let cat in temp) { segment.cats[cat] = temp[cat] };
        }
    }

    const averageValues = (cont, temp = null) => {
        for (let cat in cont.cats) {
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
        for (let c in courseList) {

        }
    }

    const aggregateSectionComments = (cont, row, qCont) => {
        for (let q in qCont) {
            if (!cont.comments.hasOwnProperty(q)) {
                cont.comments[q] = [];
            }

            cont.comments[q].push(row[q]);
        }
    }
</script>