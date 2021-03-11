@extends('faculty-info.layouts.app')

@section('faculty-info.content')
<div class="row">
    <div class="col-md-12">
        <div class="accordion" id="forms-accordion">
            <div class="card">
                <div class="card-header" id="code-of-conduct-on-sexual-harassment-heading">
                    <h2 class="mb-0">
                        <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#code-of-conduct-on-sexual-harassment" aria-expanded="true" aria-controls="code-of-conduct-on-sexual-harassment">
                            Code of Conduct on Sexual Harassment
                        </button>
                    </h2>
                </div>
        
                <div id="code-of-conduct-on-sexual-harassment" class="collapse show" aria-labelledby="code-of-conduct-on-sexual-harassment-heading" data-parent="#forms-accordion">
                    <div class="card-body">
                        <iframe src="https://www.bracu.ac.bd/sites/default/files/registrar/coc/Code-of-Conduct-Sexual-Harassment-bracu-web.pdf" frameborder="0" width="100%" height="600"></iframe>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header" id="code-of-conduct-faculty-heading">
                    <h2 class="mb-0">
                        <button class="btn btn-link btn-block text-left collapsed" type="button" data-toggle="collapse" data-target="#code-of-conduct-faculty" aria-expanded="false" aria-controls="code-of-conduct-faculty">
                            Code of Conduct (Faculty)
                        </button>
                    </h2>
                </div>
                <div id="code-of-conduct-faculty" class="collapse" aria-labelledby="code-of-conduct-faculty-heading" data-parent="#forms-accordion">
                    <div class="card-body">
                        <iframe src="https://drive.google.com/file/d/1F_18rSRygWv08uaIX4C18CT4EBTJDpxS/preview" frameborder="0" width="100%" height="600"></iframe>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header" id="bracu-annual-report-heading">
                    <h2 class="mb-0">
                        <button class="btn btn-link btn-block text-left collapsed" type="button" data-toggle="collapse" data-target="#bracu-annual-report" aria-expanded="false" aria-controls="bracu-annual-report">
                            Brac University Annual Report (2019)
                        </button>
                    </h2>
                </div>
                <div id="bracu-annual-report" class="collapse" aria-labelledby="bracu-annual-report-heading" data-parent="#forms-accordion">
                    <div class="card-body">
                        For past reports <a href="https://www.bracu.ac.bd/resources/publications/annual-report?fbclid=IwAR18kJdufQCinWcp0AUNeWXmCTtA2Jo-MpWEOZJHX-dgcmThY8VBacuocjw" target="_blank">click here</a>
                        <iframe src="https://www.bracu.ac.bd/sites/default/files/resources/ar/BRACU%20Annual%20Report%202019-%20Final.pdf" frameborder="0" width="100%" height="600"></iframe>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header" id="annual-club-report-heading">
                    <h2 class="mb-0">
                        <button class="btn btn-link btn-block text-left collapsed" type="button" data-toggle="collapse" data-target="#annual-club-report" aria-expanded="false" aria-controls="annual-club-report">
                            Annual Club Report (2019)
                        </button>
                    </h2>
                </div>
                <div id="annual-club-report" class="collapse" aria-labelledby="annual-club-report-heading" data-parent="#forms-accordion">
                    <div class="card-body">
                        To learn more about the clubs that run in the University <a href="https://www.bracu.ac.bd/campus-life/office-co-curricular-activities-oca" target="_blank">click here</a>
                        <iframe src="https://www.bracu.ac.bd/sites/default/files/OCA/OCA%20-%20Annual-Report%20RGB.pdf" frameborder="0" width="100%" height="600"></iframe>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection