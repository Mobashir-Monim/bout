<script>
    const csq = Object.filter(questionMatrix, 'calc', 'course-section ');
    const clq = Object.filter(questionMatrix, 'calc', 'lab-section ');
    const clfq = Object.filter(questionMatrix, 'calc', 'lab-ini');
    const cfq = [Object.filter(questionMatrix, 'calc', 'lf1'), Object.filter(questionMatrix, 'calc', 'lf2')];
    const csc = Object.filter(questionMatrix, 'calc', 'course-section-comment');
    const lsc = Object.filter(questionMatrix, 'calc', 'lab-section-comment');

    const analyzeCourseSection = () => {
        console.log('Analyzing data with given factors and matrix');
        evals.forEach(row => {
            let temp = cst(), q, templ = null, cs = gcs(row["Course Code"], row["Theory Section"]), cl = null;
            evalCSRow(q, temp, row, cs);
            aggregateSectionComments(cs, row, csc);

            if (labCourses.includes(row["Course Code"]) && !isNaN(parseInt(row["Lab Section"]))) {
                cl = gcl(row["Course Code"], findLabSection(row));
                templ = evalCLRow(q, row, cl);
                aggregateSectionComments(cl, row, lsc);
            }

            addToCourse(temp, templ, cs, cl);
        })

        compileDeptCourses();
        aggregateDeptCourseScores();
    }

    const evalCSRow = (q, temp, row, cs) => {
        for (let q in csq) {
            if (csq[q].type.includes('radio')) {
                optionValsAdd(temp, csq[q].options[row[q]]);
                
                if (questionMatrix[q].calc.includes('qAg')) {
                    qStatAg(cs, q, row[q]);
                }
            } else {
                evalCheckbox(csq, q, row, temp, cs);
            }
        }
    }

    const evalCLRow = (q, row, cl) => {
        let templ = clt(), pointer = 0;
        templ.section = findLabSection(row);

        for (let q in clq) {
            if (row[q] != "NADA BADA") {
                if (clq[q].type.includes('radio')) {
                    optionValsAdd(templ.cats, clq[q].options[row[q]]);
                    
                    if (clq[q].calc.includes('qAg')) {
                        qStatAg(cl, q, row[q]);
                    }
                } else {
                    evalCheckbox(clq, q, row, templ.cats, cl);
                }
            }
        }

        Object.keys(clfq).forEach(fac => {
            evalCLFRow(templ, row, pointer, row[fac]);
            pointer += 1;
        })

        return templ;
    }

    const evalCLFRow = (templ, row, pointer, fac) => {
        if (fac != 'NADA BADA' && fac != '' && fac != undefined) {
            templf = clft();
            templf.ini = fac.split(",")[0];

            Object.keys(cfq[pointer]).forEach(q => {
                if (row[q] != 'NADA BADA' && row[q] != '' && row[q] != undefined) {
                    if (cfq[pointer][q].type.includes('radio')) {
                        optionValsAdd(templf.cats, cfq[pointer][q].options[row[q]]);
                    } else {
                        evalCheckbox(cfq[pointer], q, row, templf.cats);
                    }
                }
            })

            templf.respondents += 1;
            templ.lfs.push(templf);
        }
    }

    const findLabSection = (row) => {
        let section = undefined, flag = false;

        if (!Object.keys(row).includes('Lab Section')) {
            Object.keys(clfq).forEach(key => {
                if (row[key] != 'NADA BADA' && row[key] != '' && row[key] != undefined && (section == undefined || isNaN(section))) {
                    section = parseInt(row[key].split(',')[1]);
                    flag = true;
                }
            })

            if (flag) {
                section = row["Section Number"];
            }

            return isNaN(parseInt(section)) ? "undefined" : section;
        } else {
            return row["Lab Section"];
        }
    }

    const evalCheckbox = (qbank, q, row, temp, cont = null) => {
        Object.keys(qbank[q].options).forEach(opt => {
            if (row[q].includes(opt)) {
                optionValsAdd(temp, qbank[q].options[opt]);
                
                if (cont != null && qbank[q].calc.includes('qAg')) {
                    qStatAg(cont, q, opt);
                }
            }
        })
    }

    const optionValsAdd = (temp, vals) => {
        for (let key in vals) {
            temp[key] += vals[key];
        }
    }

    const factorWeight = (temp, templ) => {
        temp.w = temp.w.toFixed(2);

        Object.keys(temp).forEach(key => {
            if (key != 'w'  && typeof(temp[key]) == 'number' && key != 'rf' && key != 'fr') {
                temp[key] *= temp.w;
            }
        })

        if (templ != null) {
            Object.keys(templ.cats).forEach(cat => {
                templ.cats[cat] *= temp.w; })

            templ.lfs.forEach(fac => {
                Object.keys(fac.cats).forEach(cat => {
                    fac.cats[cat] *= temp.w;
                })
            })
        }
    }

    const compileDeptCourses = () => {
        for (let c in courseList) {
            if (!fractions.hasOwnProperty(c)) {
                console.log(c)
                fractions[c] = [{frac: courseMap[c.slice(0,3)], sections: ""}]
            }

            if (fractions[c].length > 1) {
                fractions[c].forEach(f => {
                    let tempC = createCourse(c), secs = f.sections.split(',');
                    let dept = gd(f.frac);
                    secs.forEach(sec => {
                        if (courseList[c].sections.hasOwnProperty(sec)) {
                            tempC.sections[sec] = deepCopy(courseList[c].sections[sec]); }});
                    
                    tempC.labs = deepCopy(courseList[c].labs);
                    dept.courses[c] = tempC;
                });
            } else {
                let dept = gd(fractions[c][0].frac);
                dept.courses[c] = deepCopy(courseList[c]);
            }
        }
    }
</script>