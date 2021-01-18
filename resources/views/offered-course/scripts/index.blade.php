<script>
    let offeredCourses = {!! !is_null($helper->courses) ? str_replace("=", "", json_encode($helper->courses)) : '{}' !!};
</script>