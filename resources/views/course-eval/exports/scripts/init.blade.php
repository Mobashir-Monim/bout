<script>
    const stats = {
        holders: {
            target: {
                department: document.getElementById("target-departments"),
                course: document.getElementById("target-courses"),
                section: document.getElementById("target-sections")
            },
            progress: {
                department: document.getElementById("progress-departments"),
                course: document.getElementById("progress-courses"),
                section: document.getElementById("progress-sections")
            }
        },
        values: {
            target: {
                department: null,
                course: null,
                section: null
            },
            progress: {
                department: [],
                course: [],
                section: []
            },
            errors: {
                department: [],
                course: [],
                section: []
            }
        }
    }

    const inputs = {
        semester: document.getElementById("semester"),
        year: document.getElementById("year")
    }

    const exportEval = () => {
        initStats();
        getStats();
    }

    const initStats = () => {
        stats.holders.progress.department.value = 0;
        stats.holders.progress.course.value = 0;
        stats.holders.progress.section.value = 0;
        stats.values = {
            target: {
                department: null,
                course: null,
                section: null
            },
            progress: {
                department: [],
                course: [],
                section: []
            },
            errors: {
                department: [],
                course: [],
                section: []
            }
        };
    }
</script>