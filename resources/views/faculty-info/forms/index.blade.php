@extends('faculty-info.layouts.app')

@section('faculty-info.content')
    <div class="row">
        <div class="col-md-12">
            <div class="accordion" id="forms-accordion">
                <div class="card">
                    <div class="card-header" id="accounts-forms-heading">
                        <h2 class="mb-0">
                            <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#accounts-forms" aria-expanded="true" aria-controls="accounts-forms">
                                Accounts Forms
                            </button>
                        </h2>
                    </div>
            
                    <div id="accounts-forms" class="collapse show" aria-labelledby="accounts-forms-heading" data-parent="#forms-accordion">
                        <div class="card-body">
                            <ul>
                                <li class="text-secondary">Fixed Asset Transfer From (Not available)</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header" id="ocoe-forms-heading">
                        <h2 class="mb-0">
                            <button class="btn btn-link btn-block text-left collapsed" type="button" data-toggle="collapse" data-target="#ocoe-forms" aria-expanded="false" aria-controls="ocoe-forms">
                                Office of Controller of Examinations Forms
                            </button>
                        </h2>
                    </div>
                    <div id="ocoe-forms" class="collapse" aria-labelledby="ocoe-forms-heading" data-parent="#forms-accordion">
                        <div class="card-body">
                            <ul>
                                <li>
                                    Grade Change Form
                                    <ul>
                                        <li class="text-secondary">Formstack (Not available yet)</li>
                                        <li><a href="https://drive.google.com/file/d/19UAUjXJWxWlASH1SPThpB9jn95hPlYn-/view" target="_blank">PDF</a></li>
                                    </ul>
                                </li>
                                <li class="text-secondary">
                                    Grade Submission Form (Not available yet)
                                </li>
                                <li class="text-secondary">
                                    Makeup Grade Submission Form (Not available yet)
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header" id="hr-forms-heading">
                        <h2 class="mb-0">
                            <button class="btn btn-link btn-block text-left collapsed" type="button" data-toggle="collapse" data-target="#hr-forms" aria-expanded="false" aria-controls="ocoe-forms">
                                Human Resources Forms
                            </button>
                        </h2>
                    </div>
                    <div id="hr-forms" class="collapse" aria-labelledby="hr-forms-heading" data-parent="#forms-accordion">
                        <div class="card-body">
                            <ol>
                                <li><a href="https://drive.google.com/file/d/1gr9TBHcGXBZPznp68biF6GvljBYEWj9D/view" target="_blank">Computer Login & Email ID Requisition Form</a></li>
                                <li>
                                    CV
                                    <ul>
                                        <li><a href="https://drive.google.com/file/d/1jDXY0mYteBQui3iJv5KFFmPIdopuhbRy/view" target="_blank">Bangla Version</a></li>
                                        <li><a href="https://drive.google.com/file/d/1ZY0ckByuvicRPi16IYyX_OilqzaGA-2_/view" target="_blank">English Version</a></li>
                                    </ul>
                                </li>
                                <li><a href="https://drive.google.com/file/d/1g4UzzpTtI78d1A1Ehw3qtU67in_1yoRJ/view?usp=sharing" target="_blank">Employee ID Card Application Form</a></li>
                                <li>
                                    Employee Requisition Forms <span class="text-danger">[For use by the department heads <b>only</b>]</span>
                                    <ul>
                                        <li>
                                            Non-Doctoral
                                            <ul>
                                                <li class="text-secondary">Formstack (Not available yet)</li>
                                                <li>
                                                    <a href="https://drive.google.com/file/d/1q1-vSJFfCKHu_bBAB8upIxMqEjnB8uNh/view" target="_blank">PDF (Deprecated)</a>
                                                </li>
                                            </ul>
                                        </li>
                                        <li>
                                            Doctoral
                                            <ul>
                                                <li class="text-secondary">Formstack (Not available yet)</li>
                                                <li>
                                                    <a href="https://drive.google.com/file/d/1q1-vSJFfCKHu_bBAB8upIxMqEjnB8uNh/view" target="_blank">PDF (Deprecated)</a>
                                                </li>
                                            </ul>
                                        </li>
                                    </ul>
                                </li>
                                <li><a href="https://drive.google.com/file/d/1asSFRg3cNYnrcLcqFTuzMt0e8yX2xhmj/view?usp=sharing" target="_blank">Financial Support (Employee)</a></li>
                                <li><a href="https://drive.google.com/file/d/1VzNbj5xcBo4tf5crspeCD6-rkGSYqP9v/view?usp=sharing" target="_blank">Nominee Form</a></li>
                                <li>Promotion Form <span class="text-danger">[Link to be emailed by the Department head when required]</span></li>
                                <li><a href="https://drive.google.com/file/d/1IJQXdN9VEI2mfUhrQGMt9sR0-zrz7b16/view?usp=sharing" target="_blank">Provident Fund Form</a></li>
                                <li>
                                    Release Forms
                                    <ul>
                                        <li>
                                            Final Release Form
                                            <ul>
                                                <li><a href="https://drive.google.com/file/d/1YmqdrohZ_u9VEYRKiKdZSrWbhyQCl7Jm/view?usp=sharing" target="_blank">Main Campus</a></li>
                                                <li><a href="https://drive.google.com/file/d/14Sh_HFGiVh7I_k9VAy9dOtEaNR2OALj8/view?usp=sharing" target="_blank">Savar Campus</a></li>
                                            </ul>
                                        </li>
                                        <li><a href="https://drive.google.com/file/d/1lKw7euS2AxkBc1I5qiGS5leaVdbmTDVR/view?usp=sharing" target="_blank">IT Release Form</a></li>
                                    </ul>
                                </li>
                                <li>
                                    Related to leaves
                                    <ul>
                                        <li><a href="https://drive.google.com/file/d/1-cVWERFLGVsDcxEWAc8anIFqwqNR-dFi/view?usp=sharing" target="_blank">Clearance Form Before Leave</a></li>
                                        <li><a href="https://drive.google.com/file/d/1deOOYEENCLHXqduAOJ15ZFkSgexEQl10/view?usp=sharing" target="_blank">Basic Leave Application Form</a></li>
                                        <li><a href="https://drive.google.com/file/d/1lTUacXMEcOvkloY91zI6nyoSiG5G3gh1/view?usp=sharing" target="_blank">Maternity/Parernity Leave Form</a></li>
                                        <li>
                                            Study Leave Forms
                                            <ul>
                                                <li><a href="https://drive.google.com/file/d/1XlQZgvTvXrg7vfc1TBHj6-iM-vGgzEJA/view?usp=sharing" target="_blank">Masters</a></li>
                                                <li><a href="https://drive.google.com/file/d/1-e2BYAlzCYFlA-KKbs_MQeaJ4Ptz_Q2n/view?usp=sharing" target="_blank">PhD</a></li>
                                            </ul>
                                        </li>
                                    </ul>
                                </li>
                                <li><a href="https://drive.google.com/file/d/1B_yQG9MlazCjSR8hrd6CRSMVuPCRvNJZ/view?usp=sharing" target="_blank">Staff Tuition Fee Waiver Form</a></li>
                                <li>
                                    Travelling Authorization Form
                                    <ul>
                                        <li><a href="https://drive.google.com/file/d/1l7EGSUnt-8J1lE02IeUFGMhdVv4GKsSp/view?usp=sharing" target="_blank">Domestic</a></li>
                                        <li><a href="https://drive.google.com/file/d/1PvDxpuzcrQJogo87txzqP8J0PcCYD-wl/view?usp=sharing" target="_blank">International</a></li>
                                    </ul>
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header" id="registrars-forms-heading">
                        <h2 class="mb-0">
                            <button class="btn btn-link btn-block text-left collapsed" type="button" data-toggle="collapse" data-target="#registrars-forms" aria-expanded="false" aria-controls="ocoe-forms">
                                Registrar's Office Forms
                            </button>
                        </h2>
                    </div>
                    <div id="registrars-forms" class="collapse" aria-labelledby="registrars-forms-heading" data-parent="#forms-accordion">
                        <div class="card-body">
                            <ul>
                                <li class="text-secondary">Room Booking (Not available yet)</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection