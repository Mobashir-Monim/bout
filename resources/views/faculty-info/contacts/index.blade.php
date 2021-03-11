@extends('faculty-info.layouts.app')

@section('faculty-info.content')
<div class="row">
    <div class="col-md-12">
        <div class="accordion" id="contacts-accordion">
            <div class="card">
                <div class="card-header" id="dcos-heading">
                    <h2 class="mb-0">
                        <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#dcos" aria-expanded="true" aria-controls="dcos">
                            Department Coordinators (DCOs)
                        </button>
                    </h2>
                </div>
        
                <div id="dcos" class="collapse show" aria-labelledby="dcos-heading" data-parent="#contacts-accordion">
                    <div class="card-body p-0">
                        <div class="accordion rounded-0" id="dcos-accordion">
                            <div class="card border-0 rounded-0">
                                <div class="card-header py-1 bg-body rounded-0" id="dcos-bbs-heading">
                                    <h2 class="mb-0">
                                        <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#dcos-bbs" aria-expanded="true" aria-controls="dcos-bbs">
                                            Brac Business School (BBS)
                                        </button>
                                    </h2>
                                </div>
                                <div class="collapse show" id="dcos-bbs" aria-labelledby="dcos-bbs-heading" data-parent="#dcos-accordion">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6 my-2">
                                                <div class="card">
                                                    <div class="card-body">
                                                        <h5 class="border-bottom">Md Shahin Shaikh</h5>
                                                        <p class="mb-0">
                                                            <span class="material-icons-outlined">email</span>
                                                            shahin@bracu.ac.bd
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 my-2">
                                                <div class="card">
                                                    <div class="card-body">
                                                        <h5 class="border-bottom">Naznin Akter</h5>
                                                        <p class="mb-0">
                                                            <span class="material-icons-outlined">email</span>
                                                            naznin.akter@bracu.ac.bd
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 my-2">
                                                <div class="card">
                                                    <div class="card-body">
                                                        <h5 class="border-bottom">Md Fahmidur Hossen (EMBA)</h5>
                                                        <p class="mb-0">
                                                            <span class="material-icons-outlined">email</span>
                                                            fahmidur.hossen@bracu.ac.bd
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 my-2">
                                                <div class="card">
                                                    <div class="card-body">
                                                        <h5 class="border-bottom">Satyajit Kumar Modok (MBA)</h5>
                                                        <p class="mb-0">
                                                            <span class="material-icons-outlined">email</span>
                                                            satyajit@bracu.ac.bd
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card border-0 rounded-0">
                                <div class="card-header py-1 bg-body rounded-0" id="dcos-bied-heading">
                                    <h2 class="mb-0">
                                        <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#dcos-bied" aria-expanded="true" aria-controls="dcos-bied">
                                            BRAC Institute of Education and Development (BIED)
                                        </button>
                                    </h2>
                                </div>
                                <div class="collapse" id="dcos-bied" aria-labelledby="dcos-bied-heading" data-parent="#dcos-accordion">
                                    <div class="card-body">
                                        <div class="row">
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card border-0 rounded-0">
                                <div class="card-header py-1 bg-body rounded-0" id="dcos-bigd-heading">
                                    <h2 class="mb-0">
                                        <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#dcos-bigd" aria-expanded="true" aria-controls="dcos-bigd">
                                            BRAC Institute of Governance and Development (BIGD)
                                        </button>
                                    </h2>
                                </div>
                                <div class="collapse" id="dcos-bigd" aria-labelledby="dcos-bigd-heading" data-parent="#dcos-accordion">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6 my-2">
                                                <div class="card">
                                                    <div class="card-body">
                                                        <h5 class="border-bottom">Rajon Sharif</h5>
                                                        <p class="mb-0">
                                                            <span class="material-icons-outlined">email</span>
                                                            tarikul.alam@bracu.ac.bd
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card border-0 rounded-0">
                                <div class="card-header py-1 bg-body rounded-0" id="dcos-bil-heading">
                                    <h2 class="mb-0">
                                        <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#dcos-bil" aria-expanded="true" aria-controls="dcos-bil">
                                            Brac Institute of Languages (BIL)
                                        </button>
                                    </h2>
                                </div>
                                <div class="collapse" id="dcos-bil" aria-labelledby="dcos-bil-heading" data-parent="#dcos-accordion">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6 my-2">
                                                <div class="card">
                                                    <div class="card-body">
                                                        <h5 class="border-bottom">Mosammat Rokeya Begum</h5>
                                                        <p class="mb-0">
                                                            <span class="material-icons-outlined">email</span>
                                                            rokeya@bracu.ac.bd
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 my-2">
                                                <div class="card">
                                                    <div class="card-body">
                                                        <h5 class="border-bottom">Rukhsana Hasin Parag</h5>
                                                        <p class="mb-0">
                                                            <span class="material-icons-outlined">email</span>
                                                            rukhsana.hasin@bracu.ac.bd
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card border-0 rounded-0">
                                <div class="card-header py-1 bg-body rounded-0" id="dcos-c3er-heading">
                                    <h2 class="mb-0">
                                        <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#dcos-c3er" aria-expanded="true" aria-controls="dcos-c3er">
                                            Centre for Climate Change and Environmental Research (C3ER)
                                        </button>
                                    </h2>
                                </div>
                                <div class="collapse" id="dcos-c3er" aria-labelledby="dcos-c3er-heading" data-parent="#dcos-accordion">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6 my-2">
                                                <div class="card">
                                                    <div class="card-body">
                                                        <h5 class="border-bottom">Mohammad Hafizul Hossain</h5>
                                                        <p class="mb-0">
                                                            <span class="material-icons-outlined">email</span>
                                                            hafizul@bracu.ac.bd
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card border-0 rounded-0">
                                <div class="card-header py-1 bg-body rounded-0" id="dcos-arc-heading">
                                    <h2 class="mb-0">
                                        <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#dcos-arc" aria-expanded="true" aria-controls="dcos-arc">
                                            Department of Architecture (ARC)
                                        </button>
                                    </h2>
                                </div>
                                <div class="collapse" id="dcos-arc" aria-labelledby="dcos-arc-heading" data-parent="#dcos-accordion">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6 my-2">
                                                <div class="card">
                                                    <div class="card-body">
                                                        <h5 class="border-bottom">Saiduzzaman Shikder</h5>
                                                        <p class="mb-0">
                                                            <span class="material-icons-outlined">email</span>
                                                            saiduzzaman@bracu.ac.bd
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card border-0 rounded-0">
                                <div class="card-header py-1 bg-body rounded-0" id="dcos-cse-heading">
                                    <h2 class="mb-0">
                                        <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#dcos-cse" aria-expanded="true" aria-controls="dcos-cse">
                                            Department of Computer Science and Engineering (CSE)
                                        </button>
                                    </h2>
                                </div>
                                <div class="collapse" id="dcos-cse" aria-labelledby="dcos-cse-heading" data-parent="#dcos-accordion">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6 my-2">
                                                <div class="card">
                                                    <div class="card-body">
                                                        <h5 class="border-bottom">G.M. Zilani</h5>
                                                        <p class="mb-0">
                                                            <span class="material-icons-outlined">email</span>
                                                            gm.zilani@bracu.ac.bd
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 my-2">
                                                <div class="card">
                                                    <div class="card-body">
                                                        <h5 class="border-bottom">Anis Sharif</h5>
                                                        <p class="mb-0">
                                                            <span class="material-icons-outlined">email</span>
                                                            anis.sharif@bracu.ac.bd
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card border-0 rounded-0">
                                <div class="card-header py-1 bg-body rounded-0" id="dcos-ess-heading">
                                    <h2 class="mb-0">
                                        <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#dcos-ess" aria-expanded="true" aria-controls="dcos-ess">
                                            Department of Economics and Social Sciences (ESS)
                                        </button>
                                    </h2>
                                </div>
                                <div class="collapse" id="dcos-ess" aria-labelledby="dcos-ess-heading" data-parent="#dcos-accordion">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6 my-2">
                                                <div class="card">
                                                    <div class="card-body">
                                                        <h5 class="border-bottom">Chandan Roy</h5>
                                                        <p class="mb-0">
                                                            <span class="material-icons-outlined">email</span>
                                                            chroy@bracu.ac.bd
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card border-0 rounded-0">
                                <div class="card-header py-1 bg-body rounded-0" id="dcos-eee-heading">
                                    <h2 class="mb-0">
                                        <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#dcos-eee" aria-expanded="true" aria-controls="dcos-eee">
                                            Department of Electrical and Electronic Engineering (EEE)
                                        </button>
                                    </h2>
                                </div>
                                <div class="collapse" id="dcos-eee" aria-labelledby="dcos-eee-heading" data-parent="#dcos-accordion">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6 my-2">
                                                <div class="card">
                                                    <div class="card-body">
                                                        <h5 class="border-bottom">Afroza Begum</h5>
                                                        <p class="mb-0">
                                                            <span class="material-icons-outlined">email</span>
                                                            afroza@bracu.ac.bd
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card border-0 rounded-0">
                                <div class="card-header py-1 bg-body rounded-0" id="dcos-enh-heading">
                                    <h2 class="mb-0">
                                        <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#dcos-enh" aria-expanded="true" aria-controls="dcos-enh">
                                            Department of English and Humanities (ENH)
                                        </button>
                                    </h2>
                                </div>
                                <div class="collapse" id="dcos-enh" aria-labelledby="dcos-enh-heading" data-parent="#dcos-accordion">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6 my-2">
                                                <div class="card">
                                                    <div class="card-body">
                                                        <h5 class="border-bottom">Allfe Shahnoor Chowdhury</h5>
                                                        <p class="mb-0">
                                                            <span class="material-icons-outlined">email</span>
                                                            shahnoor@bracu.ac.bd
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card border-0 rounded-0">
                                <div class="card-header py-1 bg-body rounded-0" id="dcos-mns-heading">
                                    <h2 class="mb-0">
                                        <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#dcos-mns" aria-expanded="true" aria-controls="dcos-mns">
                                            Department of Mathematics and Natural Sciences (MNS)
                                        </button>
                                    </h2>
                                </div>
                                <div class="collapse" id="dcos-mns" aria-labelledby="dcos-mns-heading" data-parent="#dcos-accordion">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6 my-2">
                                                <div class="card">
                                                    <div class="card-body">
                                                        <h5 class="border-bottom">Mostak Ahmed</h5>
                                                        <p class="mb-0">
                                                            <span class="material-icons-outlined">email</span>
                                                            mostak@bracu.ac.bd
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 my-2">
                                                <div class="card">
                                                    <div class="card-body">
                                                        <h5 class="border-bottom">Md Rezwanur Rahman</h5>
                                                        <p class="mb-0">
                                                            <span class="material-icons-outlined">email</span>
                                                            rezwanur.rahman@bracu.ac.bd
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card border-0 rounded-0">
                                <div class="card-header py-1 bg-body rounded-0" id="dcos-phr-heading">
                                    <h2 class="mb-0">
                                        <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#dcos-phr" aria-expanded="true" aria-controls="dcos-phr">
                                            Department of Pharmacy (PHR)
                                        </button>
                                    </h2>
                                </div>
                                <div class="collapse" id="dcos-phr" aria-labelledby="dcos-phr-heading" data-parent="#dcos-accordion">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6 my-2">
                                                <div class="card">
                                                    <div class="card-body">
                                                        <h5 class="border-bottom">Asma Ahmed</h5>
                                                        <p class="mb-0">
                                                            <span class="material-icons-outlined">email</span>
                                                            asma_ahmed@bracu.ac.bd
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card border-0 rounded-0">
                                <div class="card-header py-1 bg-body rounded-0" id="dcos-gsm-heading">
                                    <h2 class="mb-0">
                                        <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#dcos-gsm" aria-expanded="true" aria-controls="dcos-gsm">
                                            Graduate School of Management (GSM)
                                        </button>
                                    </h2>
                                </div>
                                <div class="collapse" id="dcos-gsm" aria-labelledby="dcos-gsm-heading" data-parent="#dcos-accordion">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6 my-2">
                                                <div class="card">
                                                    <div class="card-body">
                                                        <h5 class="border-bottom">Satyajit Kumar Modak</h5>
                                                        <p class="mb-0">
                                                            <span class="material-icons-outlined">email</span>
                                                            satyajit@bracu.ac.bd
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card border-0 rounded-0">
                                <div class="card-header py-1 bg-body rounded-0" id="dcos-jpgsp-heading">
                                    <h2 class="mb-0">
                                        <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#dcos-jpgsp" aria-expanded="true" aria-controls="dcos-jpgsp">
                                            James P. Grant School of Public Health (JPGSP)
                                        </button>
                                    </h2>
                                </div>
                                <div class="collapse" id="dcos-jpgsp" aria-labelledby="dcos-jpgsp-heading" data-parent="#dcos-accordion">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6 my-2">
                                                <div class="card">
                                                    <div class="card-body">
                                                        <h5 class="border-bottom">Tahsin Madani Hossain (MPH)</h5>
                                                        <p class="mb-0">
                                                            <span class="material-icons-outlined">email</span>
                                                            tahsin.hossain@bracu.ac.bd
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card border-0 rounded-0">
                                <div class="card-header py-1 bg-body rounded-0" id="dcos-ged-heading">
                                    <h2 class="mb-0">
                                        <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#dcos-ged" aria-expanded="true" aria-controls="dcos-ged">
                                            School of General Education (GEd)
                                        </button>
                                    </h2>
                                </div>
                                <div class="collapse" id="dcos-ged" aria-labelledby="dcos-ged-heading" data-parent="#dcos-accordion">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6 my-2">
                                                <div class="card">
                                                    <div class="card-body">
                                                        <h5 class="border-bottom">Fahmida</h5>
                                                        <p class="mb-0">
                                                            <span class="material-icons-outlined">email</span>
                                                            N/A
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card border-0 rounded-0">
                                <div class="card-header py-1 bg-body rounded-0" id="dcos-sol-heading">
                                    <h2 class="mb-0">
                                        <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#dcos-sol" aria-expanded="true" aria-controls="dcos-sol">
                                            School of Law (SoL)
                                        </button>
                                    </h2>
                                </div>
                                <div class="collapse" id="dcos-sol" aria-labelledby="dcos-sol-heading" data-parent="#dcos-accordion">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6 my-2">
                                                <div class="card">
                                                    <div class="card-body">
                                                        <h5 class="border-bottom">Theophil Nokrek</h5>
                                                        <p class="mb-0">
                                                            <span class="material-icons-outlined">email</span>
                                                            tnokrek@bracu.ac.bd
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header" id="program-coordinators-heading">
                    <h2 class="mb-0">
                        <button class="btn btn-link btn-block text-left collapsed" type="button" data-toggle="collapse" data-target="#program-coordinators" aria-expanded="false" aria-controls="program-coordinators">
                            Program Coordinators
                        </button>
                    </h2>
                </div>
                <div id="program-coordinators" class="collapse" aria-labelledby="program-coordinators-heading" data-parent="#contacts-accordion">
                    <div class="card-body p-0">
                        <div class="accordion rounded-0" id="prog-coordinator-accordion">
                            <div class="card border-0 rounded-0">
                                <div class="card-header py-1 bg-body rounded-0" id="prog-coordinator-bbs-heading">
                                    <h2 class="mb-0">
                                        <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#prog-coordinator-bbs" aria-expanded="true" aria-controls="prog-coordinator-bbs">
                                            Brac Business School (BBS)
                                        </button>
                                    </h2>
                                </div>
                                <div class="collapse show" id="prog-coordinator-bbs" aria-labelledby="prog-coordinator-bbs-heading" data-parent="#prog-coordinator-accordion">
                                    <div class="card-body">
                                        <div class="row">
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card border-0 rounded-0">
                                <div class="card-header py-1 bg-body rounded-0" id="prog-coordinator-bied-heading">
                                    <h2 class="mb-0">
                                        <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#prog-coordinator-bied" aria-expanded="true" aria-controls="prog-coordinator-bied">
                                            BRAC Institute of Education and Development (BIED)
                                        </button>
                                    </h2>
                                </div>
                                <div class="collapse" id="prog-coordinator-bied" aria-labelledby="prog-coordinator-bied-heading" data-parent="#prog-coordinator-accordion">
                                    <div class="card-body">
                                        <div class="row">
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card border-0 rounded-0">
                                <div class="card-header py-1 bg-body rounded-0" id="prog-coordinator-bigd-heading">
                                    <h2 class="mb-0">
                                        <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#prog-coordinator-bigd" aria-expanded="true" aria-controls="prog-coordinator-bigd">
                                            BRAC Institute of Governance and Development (BIGD)
                                        </button>
                                    </h2>
                                </div>
                                <div class="collapse" id="prog-coordinator-bigd" aria-labelledby="prog-coordinator-bigd-heading" data-parent="#prog-coordinator-accordion">
                                    <div class="card-body">
                                        <div class="row">
                        
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card border-0 rounded-0">
                                <div class="card-header py-1 bg-body rounded-0" id="prog-coordinator-bil-heading">
                                    <h2 class="mb-0">
                                        <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#prog-coordinator-bil" aria-expanded="true" aria-controls="prog-coordinator-bil">
                                            Brac Institute of Languages (BIL)
                                        </button>
                                    </h2>
                                </div>
                                <div class="collapse" id="prog-coordinator-bil" aria-labelledby="prog-coordinator-bil-heading" data-parent="#prog-coordinator-accordion">
                                    <div class="card-body">
                                        <div class="row">
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card border-0 rounded-0">
                                <div class="card-header py-1 bg-body rounded-0" id="prog-coordinator-c3er-heading">
                                    <h2 class="mb-0">
                                        <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#prog-coordinator-c3er" aria-expanded="true" aria-controls="prog-coordinator-c3er">
                                            Centre for Climate Change and Environmental Research (C3ER)
                                        </button>
                                    </h2>
                                </div>
                                <div class="collapse" id="prog-coordinator-c3er" aria-labelledby="prog-coordinator-c3er-heading" data-parent="#prog-coordinator-accordion">
                                    <div class="card-body">
                                        <div class="row">
                        
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card border-0 rounded-0">
                                <div class="card-header py-1 bg-body rounded-0" id="prog-coordinator-arc-heading">
                                    <h2 class="mb-0">
                                        <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#prog-coordinator-arc" aria-expanded="true" aria-controls="prog-coordinator-arc">
                                            Department of Architecture (ARC)
                                        </button>
                                    </h2>
                                </div>
                                <div class="collapse" id="prog-coordinator-arc" aria-labelledby="prog-coordinator-arc-heading" data-parent="#prog-coordinator-accordion">
                                    <div class="card-body">
                                        <div class="row">
                        
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card border-0 rounded-0">
                                <div class="card-header py-1 bg-body rounded-0" id="prog-coordinator-cse-heading">
                                    <h2 class="mb-0">
                                        <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#prog-coordinator-cse" aria-expanded="true" aria-controls="prog-coordinator-cse">
                                            Department of Computer Science and Engineering (CSE)
                                        </button>
                                    </h2>
                                </div>
                                <div class="collapse" id="prog-coordinator-cse" aria-labelledby="prog-coordinator-cse-heading" data-parent="#prog-coordinator-accordion">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6 my-2">
                                                <div class="card">
                                                    <div class="card-body">
                                                        <h5 class="border-bottom">Annajiat Alim Rasel <b>(Undergraduate)</b></h5>
                                                        <p class="mb-0">
                                                            <span class="material-icons-outlined">email</span>
                                                            annajiat@bracu.ac.bd
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card border-0 rounded-0">
                                <div class="card-header py-1 bg-body rounded-0" id="prog-coordinator-ess-heading">
                                    <h2 class="mb-0">
                                        <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#prog-coordinator-ess" aria-expanded="true" aria-controls="prog-coordinator-ess">
                                            Department of Economics and Social Sciences (ESS)
                                        </button>
                                    </h2>
                                </div>
                                <div class="collapse" id="prog-coordinator-ess" aria-labelledby="prog-coordinator-ess-heading" data-parent="#prog-coordinator-accordion">
                                    <div class="card-body">
                                        <div class="row">
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card border-0 rounded-0">
                                <div class="card-header py-1 bg-body rounded-0" id="prog-coordinator-eee-heading">
                                    <h2 class="mb-0">
                                        <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#prog-coordinator-eee" aria-expanded="true" aria-controls="prog-coordinator-eee">
                                            Department of Electrical and Electronic Engineering (EEE)
                                        </button>
                                    </h2>
                                </div>
                                <div class="collapse" id="prog-coordinator-eee" aria-labelledby="prog-coordinator-eee-heading" data-parent="#prog-coordinator-accordion">
                                    <div class="card-body">
                                        <div class="row">
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card border-0 rounded-0">
                                <div class="card-header py-1 bg-body rounded-0" id="prog-coordinator-enh-heading">
                                    <h2 class="mb-0">
                                        <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#prog-coordinator-enh" aria-expanded="true" aria-controls="prog-coordinator-enh">
                                            Department of English and Humanities (ENH)
                                        </button>
                                    </h2>
                                </div>
                                <div class="collapse" id="prog-coordinator-enh" aria-labelledby="prog-coordinator-enh-heading" data-parent="#prog-coordinator-accordion">
                                    <div class="card-body">
                                        <div class="row">
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card border-0 rounded-0">
                                <div class="card-header py-1 bg-body rounded-0" id="prog-coordinator-mns-heading">
                                    <h2 class="mb-0">
                                        <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#prog-coordinator-mns" aria-expanded="true" aria-controls="prog-coordinator-mns">
                                            Department of Mathematics and Natural Sciences (MNS)
                                        </button>
                                    </h2>
                                </div>
                                <div class="collapse" id="prog-coordinator-mns" aria-labelledby="prog-coordinator-mns-heading" data-parent="#prog-coordinator-accordion">
                                    <div class="card-body">
                                        <div class="row">
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card border-0 rounded-0">
                                <div class="card-header py-1 bg-body rounded-0" id="prog-coordinator-phr-heading">
                                    <h2 class="mb-0">
                                        <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#prog-coordinator-phr" aria-expanded="true" aria-controls="prog-coordinator-phr">
                                            Department of Pharmacy (PHR)
                                        </button>
                                    </h2>
                                </div>
                                <div class="collapse" id="prog-coordinator-phr" aria-labelledby="prog-coordinator-phr-heading" data-parent="#prog-coordinator-accordion">
                                    <div class="card-body">
                                        <div class="row">
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card border-0 rounded-0">
                                <div class="card-header py-1 bg-body rounded-0" id="prog-coordinator-gsm-heading">
                                    <h2 class="mb-0">
                                        <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#prog-coordinator-gsm" aria-expanded="true" aria-controls="prog-coordinator-gsm">
                                            Graduate School of Management (GSM)
                                        </button>
                                    </h2>
                                </div>
                                <div class="collapse" id="prog-coordinator-gsm" aria-labelledby="prog-coordinator-gsm-heading" data-parent="#prog-coordinator-accordion">
                                    <div class="card-body">
                                        <div class="row">
                        
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card border-0 rounded-0">
                                <div class="card-header py-1 bg-body rounded-0" id="prog-coordinator-jpgsp-heading">
                                    <h2 class="mb-0">
                                        <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#prog-coordinator-jpgsp" aria-expanded="true" aria-controls="prog-coordinator-jpgsp">
                                            James P. Grant School of Public Health (JPGSP)
                                        </button>
                                    </h2>
                                </div>
                                <div class="collapse" id="prog-coordinator-jpgsp" aria-labelledby="prog-coordinator-jpgsp-heading" data-parent="#prog-coordinator-accordion">
                                    <div class="card-body">
                                        <div class="row">
                        
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card border-0 rounded-0">
                                <div class="card-header py-1 bg-body rounded-0" id="prog-coordinator-ged-heading">
                                    <h2 class="mb-0">
                                        <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#prog-coordinator-ged" aria-expanded="true" aria-controls="prog-coordinator-ged">
                                            School of General Education (GEd)
                                        </button>
                                    </h2>
                                </div>
                                <div class="collapse" id="prog-coordinator-ged" aria-labelledby="prog-coordinator-ged-heading" data-parent="#prog-coordinator-accordion">
                                    <div class="card-body">
                                        <div class="row">
                        
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card border-0 rounded-0">
                                <div class="card-header py-1 bg-body rounded-0" id="prog-coordinator-sol-heading">
                                    <h2 class="mb-0">
                                        <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#prog-coordinator-sol" aria-expanded="true" aria-controls="prog-coordinator-sol">
                                            School of Law (SoL)
                                        </button>
                                    </h2>
                                </div>
                                <div class="collapse" id="prog-coordinator-sol" aria-labelledby="prog-coordinator-sol-heading" data-parent="#prog-coordinator-accordion">
                                    <div class="card-body">
                                        <div class="row">
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header" id="other-important-contacts-heading">
                    <h2 class="mb-0">
                        <button class="btn btn-link btn-block text-left collapsed" type="button" data-toggle="collapse" data-target="#other-important-contacts" aria-expanded="false" aria-controls="other-important-contacts">
                            Other Important Contacts
                        </button>
                    </h2>
                </div>
                <div id="other-important-contacts" class="collapse" aria-labelledby="other-important-contacts-heading" data-parent="#contacts-accordion">
                    <div class="card-body">
                        <ul>
                            <li>Medical</li>
                            <li>Information Desk</li>
                            <li>Registrar's Office</li>
                            <li>Human Resources</li>
                            <li>Admin</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection