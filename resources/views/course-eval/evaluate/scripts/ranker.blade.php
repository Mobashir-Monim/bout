<script>
    let deptOverallReport = {
        percentiles: null,
        deptCourseHighests: null,
        uniCourseHighests: null,
        uniHighests: null,
        courseCount: 0,
        sectionCount: 0,
    };
    let courseOverallReport = {
        percentiles: null,
        courseSectionHighests: null,
        uniSectionHighests: null,
        uniCourseHighests: null,
        sectionCount: 0,
    };
    let sectionReport = {
        percentiles: null, // compare with all the sections of the course
        deptPercentiles: null, // compare with all the sections of the department
        courseSectionHighests: null,
        uniSectionHighests: null,
        sectionCount: 0,
    };
    let labReport = {
        percentiles: null, // compare with all the sections of the course
        deptPercentiles: null, // compare with all the sections of the department
        courseSectionHighests: null,
        deptHighest: null,
    };
    let resultingRank = {depts: {}, cats: {}};

    const sorter = (list, store) => {
        let m = {};
        if (store.hasOwnProperty('max')) { m = store.max; }

        for (let l in list) {
            for (let c in list[l].cats) {
                if (!store.hasOwnProperty(c)) { store[c] = []; }
                store[c].push(list[l].cats[c]);
            }
        }

        for (let c in store) {
            store[c].sort((a, b) => { return a - b; });
            m[c] = store[c][store[c].length - 1];
        }

        if (Object.keys(store).length > 0) {
            store.max = m;
        }
    }

    const rankAll = () => {
        console.log('Ranking results and stats');
        let out = document.getElementById('spinner');
        out.innerHTML = '<div class="mt-2 spinner-border" role="status"><span class="sr-only">Loading...</span></div>';
        setTimeout(() => {
            rankSections();
            rankLabs();
            findGlobalMax();
            makeDeptSectionScores();
            addDeptReport();
            findExtremeScoringCourses();
            findExtremeScoringSections();
            roundFigures();
            segregateParts();
            out.innerHTML = '';
            document.getElementById('evaluator').classList.add('hidden');
            document.getElementById('downloader').classList.remove('hidden');
        }, 100);
    }

    const rankSections = () => {
        sorter(evaluationResults, resultingRank.cats);

        for (let d in evaluationResults) {
            initializeRankingObjects(resultingRank.depts, d, 'courses');
            sorter(evaluationResults[d].courses, resultingRank.depts[d].cats);

            for (let c in evaluationResults[d].courses) {
                initializeRankingObjects(resultingRank.depts[d].courses, c);
                sorter(evaluationResults[d].courses[c].sections, resultingRank.depts[d].courses[c].cats);
            }
        }
    }

    const initializeRankingObjects = (cont, contName, objName = null) => {
        cont[contName] = {};
        cont[contName].cats = {};

        if (objName != null) {
            cont[contName][objName] = {};
        }
    }

    const rankLabs = () => {
        for (let d in resultingRank.depts) {
            resultingRank.depts[d].labSections = {};

            for (let c in resultingRank.depts[d].courses) {
                resultingRank.depts[d].courses[c].labs = {};
                sorter(evaluationResults[d].courses[c].labs, resultingRank.depts[d].courses[c].labs);
                
                for (let cat in resultingRank.depts[d].courses[c].labs) {
                    if (!resultingRank.depts[d].labSections.hasOwnProperty(cat)) {
                        resultingRank.depts[d].labSections[cat] = [];
                    }

                    resultingRank.depts[d].labSections[cat] = resultingRank.depts[d].labSections[cat].concat(resultingRank.depts[d].courses[c].labs[cat]);
                }
            }
        }
    }

    const makeDeptSectionScores = () => {
        for (let d in resultingRank.depts) {
            resultingRank.depts[d].deptSections = {};

            for (let c in resultingRank.depts[d].courses) {
                for (let cat in resultingRank.depts[d].courses[c].cats) {
                    if (cat != 'max') {
                        if (!resultingRank.depts[d].deptSections.hasOwnProperty(cat)) {
                            resultingRank.depts[d].deptSections[cat] = [];
                        }

                        resultingRank.depts[d].deptSections[cat] = resultingRank.depts[d].deptSections[cat].concat(resultingRank.depts[d].courses[c].cats[cat]);
                        resultingRank.depts[d].deptSections[cat].sort((a, b) => { return a - b; });
                    }
                }
            }
        }
    }

    const findGlobalMax = () => {
        resultingRank.cats.courseMax = {};
        resultingRank.cats.sectionMax = {};

        for (let d in resultingRank.depts) {
            compareWithMax(resultingRank.cats.courseMax, resultingRank.depts[d].cats.max)

            for (let c in resultingRank.depts[d].courses) {
                compareWithMax(resultingRank.cats.sectionMax, resultingRank.depts[d].courses[c].cats.max)
            }
        }
    }

    const compareWithMax = (cont, maxInstance) => {
        for (let cat in maxInstance) {
            if (!cont.hasOwnProperty(cat)) { cont[cat] = null; }
            if (cont[cat] == null) { cont[cat] = maxInstance[cat]; }
            else if (cont[cat] < maxInstance[cat]) { cont[cat] = maxInstance[cat]; }
        }
    }

    const addDeptReport = () => {
        for (let d in evaluationResults) {
            evaluationResults[d].overall = deepCopy(deptOverallReport);
            evaluationResults[d].overall.percentiles = findPercentile(evaluationResults[d].cats, resultingRank.cats);
            evaluationResults[d].overall.deptCourseHighests = deepCopy(resultingRank.depts[d].cats.max);
            evaluationResults[d].overall.uniCourseHighests = deepCopy(resultingRank.cats.courseMax);
            evaluationResults[d].overall.uniHighests = deepCopy(resultingRank.cats.max);
            evaluationResults[d].overall.courseCount = Object.keys(evaluationResults[d].courses).length;
            evaluationResults[d].overall.sectionCount = Object.keys(resultingRank.depts[d].deptSections).length;
            addCourseReport(evaluationResults[d].courses, d);
        }
    }

    const addCourseReport = (courses, d) => {
        for (let c in courses) {
            courses[c].overall = deepCopy(courseOverallReport);
            courses[c].overall.percentiles = findPercentile(courses[c].cats, resultingRank.depts[d].cats);
            courses[c].overall.courseSectionHighests = deepCopy(resultingRank.depts[d].courses[c].cats.max);
            courses[c].overall.uniSectionHighests = deepCopy(resultingRank.cats.sectionMax);
            courses[c].overall.uniCourseHighests = deepCopy(resultingRank.cats.courseMax);
            courses[c].overall.sectionCount = Object.keys(courses[c].sections).length;
            addSectionReport(courses[c].sections, d, c);
            addLabReport(courses[c].labs, d, c);
        }
    }

    const addSectionReport = (sections, d, c) => {
        for (let s in sections) {
            sections[s].overall = deepCopy(sectionReport);
            sections[s].overall.percentiles = findPercentile(sections[s].cats, resultingRank.depts[d].courses[c].cats);
            sections[s].overall.deptPercentiles = findPercentile(sections[s].cats, resultingRank.depts[d].deptSections);
            sections[s].overall.courseSectionHighests = deepCopy(resultingRank.depts[d].courses[c].cats.max);
            sections[s].overall.uniSectionHighests = deepCopy(resultingRank.cats.sectionMax);
            sections[s].overall.sectionCount = Object.keys(evaluationResults[d].courses[c].sections).length;
        }
    }

    const addLabReport = (labs, d, c) => {
        for (let l in labs) {
            labs[l].overall = deepCopy(labReport);
            labs[l].overall.percentiles = findPercentile(labs[l].cats, resultingRank.depts[d].courses[c].labs);
            labs[l].overall.deptPercentiles = findPercentile(labs[l].cats, resultingRank.depts[d].labSections);
            labs[l].overall.courseSectionHighests = findLabHighest(resultingRank.depts[d].courses[c].labs);
            labs[l].overall.deptHighest = findLabHighest(resultingRank.depts[d].labSections);
        }
    }

    const findLabHighest = cont => {
        let max = {};

        for (let cat in cont) {
            max[cat] = cont[cat][cont[cat].length - 1];
        }

        return max;
    }

    const findPercentile = (cont, store) => {
        let percentiles = {};

        for (let cat in cont) {
            percentiles[cat] = Math.round((store[cat].findIndex(el => el == cont[cat]) + 1) * 100 / store[cat].length);
        }

        return percentiles;
    }

    const findExtremeScoringCourses = () => {
        for (let d in resultingRank.depts) {
            let lowest = {}, highest = {};

            for (let cat in resultingRank.depts[d].cats) {
                if (cat != 'max' && cat != 'r' && resultingRank.depts[d].cats[cat] != NaN) {
                    if (!lowest.hasOwnProperty(cat)) { lowest[cat] = []; }
                    if (!highest.hasOwnProperty(cat)) { highest[cat] = []; }

                    resultingRank.depts[d].cats[cat] = resultingRank.depts[d].cats[cat].sort((a, b) => { return a - b; });
                    let lLim = resultingRank.depts[d].cats[cat][getLimIndex(true, resultingRank.depts[d].cats[cat])];
                    let hLim = resultingRank.depts[d].cats[cat][getLimIndex(false, resultingRank.depts[d].cats[cat])];

                    for (let c in evaluationResults[d].courses) {
                        if (evaluationResults[d].courses[c].cats[cat] <= lLim) {
                            lowest[cat].push(c);
                        }

                        if (evaluationResults[d].courses[c].cats[cat] >= hLim) {
                            highest[cat].push(c);
                        }
                    }
                    
                    lowest[cat] = lowest[cat].join(', ');
                    highest[cat] = highest[cat].join(', ');
                }
            }

            evaluationResults[d].lowest = lowest;
            evaluationResults[d].highest = highest;
        }
    }

    const findExtremeScoringSections = () => {
        for (let d in evaluationResults) {
            for (let c in evaluationResults[d].courses) {
                let lowest = {}, highest = {};

                for (let cat in resultingRank.depts[d].courses[c].cats) {
                    if (cat != 'max' && cat != 'courseMax' && cat != 'sectionMax' && cat != 'r' && resultingRank.depts[d].courses[c].cats[cat] != NaN) {
                        if (!lowest.hasOwnProperty(cat)) { lowest[cat] = []; }
                        if (!highest.hasOwnProperty(cat)) { highest[cat] = []; }

                        resultingRank.depts[d].courses[c].cats[cat] = resultingRank.depts[d].courses[c].cats[cat].sort((a, b) => { return a - b; });
                        let lLim = resultingRank.depts[d].courses[c].cats[cat][getLimIndex(true, resultingRank.depts[d].courses[c].cats[cat])];
                        let hLim = resultingRank.depts[d].courses[c].cats[cat][getLimIndex(false, resultingRank.depts[d].courses[c].cats[cat])];

                        for (let s in evaluationResults[d].courses[c].sections) {
                            if (evaluationResults[d].courses[c].sections[s].cats[cat] <= lLim) {
                                lowest[cat].push(s);
                            }

                            if (evaluationResults[d].courses[c].sections[s].cats[cat] >= hLim) {
                                highest[cat].push(s);
                            }
                        }

                        lowest[cat] = lowest[cat].join(', ');
                        highest[cat] = highest[cat].join(', ');
                    }
                }

                evaluationResults[d].courses[c].lowest = lowest;
                evaluationResults[d].courses[c].highest = highest;
            }
        }
    }

    const getLimIndex = (i, arr) => {
        if (i) {
            return arr.length < 5 ? arr.length - 1 : 4;
        } else {
            return arr.length < 5 ? 0 : arr.length - 5;
        }
    }

    const roundFigures = () => {
        for (let d in evaluationResults) {
            catsRounder(evaluationResults[d].cats);
            catsRounder(evaluationResults[d].overall.deptCourseHighests);
            catsRounder(evaluationResults[d].overall.uniCourseHighests);
            catsRounder(evaluationResults[d].overall.uniHighests);

            for (let c in evaluationResults[d].courses) {
                catsRounder(evaluationResults[d].courses[c].cats);
                catsRounder(evaluationResults[d].courses[c].overall.courseSectionHighests);
                catsRounder(evaluationResults[d].courses[c].overall.uniCourseHighests);
                catsRounder(evaluationResults[d].courses[c].overall.uniSectionHighests);

                for (let s in evaluationResults[d].courses[c].sections) {
                    catsRounder(evaluationResults[d].courses[c].sections[s].cats);
                    catsRounder(evaluationResults[d].courses[c].sections[s].overall.courseSectionHighests);
                    catsRounder(evaluationResults[d].courses[c].sections[s].overall.uniSectionHighests);
                }

                for (let l in evaluationResults[d].courses[c].labs) {
                    catsRounder(evaluationResults[d].courses[c].labs[l].cats)
                }
            }
        }
    }

    const catsRounder = cats => {
        for (let cat in cats) {
            cats[cat] = Math.round((cats[cat] + Number.EPSILON) * 100) / 100;
        }
    }
</script>