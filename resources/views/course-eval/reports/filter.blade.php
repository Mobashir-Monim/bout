<div class="row">
    <div class="col-md-6 my-2">
        <h6 class="mb-0"><b>Department</b></h6>
        @if (sizeof($helper->data['depts']) > 1)
            <select name="dept" id="dept" class="form-control" onchange="showCourses()">
                <option value="">Please select a department</option>

                @foreach ($helper->data['depts'] as $dept)
                    <option value="{{ strtoupper($dept) }}">{{ $dept }}</option>
                @endforeach
            </select>
        @else
            <h5>{{ $depts[0] }}</h5>
        @endif
    </div>
    <div class="col-md-6 my-2 mt-auto">
        <a href="{{ sizeof($helper->data['depts']) > 1 ? '#/' : $helper->buildRoute($depts[0]) }}" {{ sizeof($helper->data['depts']) > 1 ? "onclick=openReport('dept')" : '' }} id="dept-btn" class="btn btn-dark w-100 {{ sizeof($helper->data['depts']) > 1 ? 'hidden' : '' }}">Generate Department Report</a>
    </div>
</div>

<div class="row hidden" id="course-row">
    <div class="col-md-6 my-2">
        <h6 class="mb-0"><b>Course</b></h6>
        <select name="course" id="course" class="form-control" onchange="showSections()"></select>
    </div>
    <div class="col-md-6 my-2 mt-auto">
        <a href="#/" id="dept-btn" class="btn btn-dark w-100" onclick="openReport('course')">Generate Course Report</a>
    </div>
</div>

<div class="row hidden" id="section-row">
    <div class="col-md-6 my-2">
        <h6 class="mb-0"><b>Section</b></h6>
        <select name="section" id="section" class="form-control"></select>
    </div>
    <div class="col-md-6 my-2 mt-auto">
        <a href="#/" id="section-btn" class="btn btn-dark w-100" onclick="openReport('section')">Generate Section Report</a>
    </div>
</div>

<div class="row hidden" id="lab-row">
    <div class="col-md-6 my-2">
        <h6 class="mb-0"><b>Lab</b></h6>
        <select name="lab" id="lab" class="form-control"></select>
    </div>
    <div class="col-md-6 my-2 mt-auto">
        <a href="#/" id="lab-btn" class="btn btn-dark w-100" onclick="openReport('lab')">Generate Lab Report</a>
    </div>
</div>

@include('course-eval.reports.scripts.filter')