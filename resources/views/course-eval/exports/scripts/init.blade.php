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
                department: 0,
                course: 0,
                section: 0
            },
            progress: {
                department: 0,
                course: 0,
                section: 0
            }
        }
    }

    const inputs = {
        semester: document.getElementById("semester"),
        year: document.getElementById("year")
    }

    const exportEval = () => {
        getStats();
        initProgressValues();
    }

    const initProgressValues = () => {
        stats.holders.progress.department.value = 0;
        stats.holders.progress.course.value = 0;
        stats.holders.progress.section.value = 0;
    }

    const initFetchIndex = () => {
        fetchIndexer.department = 0;
        fetchIndexer.course = 0;
        fetchIndexer.section = 0;
    }
</script>