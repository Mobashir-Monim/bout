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
                            @foreach ($dco_parts as $enterprise_part => $segments)
                                @include('faculty-info.contacts.parts.accordion-card', ['part' => 'dcos'])
                            @endforeach
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
                            @foreach ($pco_parts as $enterprise_part => $segments)
                                @include('faculty-info.contacts.parts.accordion-card', ['part' => 'prog-coordinator'])
                            @endforeach
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