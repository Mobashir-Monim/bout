<div class="row">
    <div class="col-md-12 my-2">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-8 offset-md-2">
                        <canvas id="dept-comparison" width="400" height="400"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    let deptComparison = new Chart(document.getElementById('dept-comparison'), {!! $helper->getChartConfig() !!});
</script>