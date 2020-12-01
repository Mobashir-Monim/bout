<script>
    const deptTemplate = {
        name: "",
        cats: {
            lq: 0,
            cq: 0,
            ca: 0,
            ae: 0,
            lx: 0,
            sp: 0,
            le: 0,
            sp: 0,
            ta: 0,
            cr: 0,
            lr: 0,
            ei: 0,
            ii: 0,
        },
        students: 0,
        respondents: 0,
        courses: {}
    }

    const courseTemplate = {
        name: "",
        cats: {
            lq: 0,
            cq: 0,
            ca: 0,
            ae: 0,
            lx: 0,
            sp: 0,
            le: 0,
            sp: 0,
            ta: 0,
            cr: 0,
            lr: 0,
            ei: 0,
            ii: 0,
        },
        students: 0,
        respondents: 0,
        sections: {},
        labs: {},
        qStat: {},
    };

    const sectionTemplate = {
        cats: {
            lq: 0,
            cq: 0,
            le: 0,
            ae: 0,
            lx: 0,
            sp: 0,
            ca: 0,
            fr: 0,
            rf: 0,
            ta: 0,
            cr: 0,
            dk: 0,
            ei: 0,
            ii: 0,
        },
        students: 0,
        respondents: 0,
        section: null,
        qStat: {},
        comments = {},
    };

    const labTemplate = {
        cats: {
            lr: 0,
            ldk: 0,
            lfe: 0,
            llx: 0,
        },
        section: null,
        respondents: 0,
        lfs: [],
        qStat: {},
        comments = {},
    };

    const sectionTempEvalTemplate = {
        lq: 0,
        cq: 0,
        le: 0,
        ae: 0,
        lx: 0,
        sp: 0,
        ca: 0,
        fr: 0,
        rf: 0,
        ta: 0,
        cr: 0,
        dk: 0,
        ei: 0,
        ii: 0,
        w: 0,
    };

    const courseTempEvalTemplate = {
        lq: 0,
        cq: 0,
        ca: 0,
        ae: 0,
        lx: 0,
        sp: 0,
        le: 0,
        sp: 0,
        ta: 0,
        cr: 0,
        lr: 0,
        ei: 0,
        ii: 0,
        r: 0,
    }

    const labFacultyTemplate = {
        ini: "",
        cats: {
            ldk: 0,
            lfe: 0,
            llx: 0,
        },
        respondents: 0,
    }
</script>