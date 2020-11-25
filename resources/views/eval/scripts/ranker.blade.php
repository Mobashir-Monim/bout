<script>
    let rankTemp = {
        lq: [],
        cq: [],
        le: [],
        ae: [],
        lx: [],
        sp: [],
        ca: [],
        ta: [],
        cr: [],
        lr: [],
    };

    let deptRank = {};
    let courseRank = {};
    let sectionRank = {};

    const sorter = (list, store) => {
        for (l in list) {
            for (c in list[l].cats) {
                store[c].push(list[l].cats[c]);
            }
        }

        for (c in store) {
            store[c].sort((a, b) => { return a - b }); });
        }
    }

    const findPercentile = (val, storeCat) => (storeCat.findIndex(el => el == val) + 1) * 100 / storeCat.length;
</script>