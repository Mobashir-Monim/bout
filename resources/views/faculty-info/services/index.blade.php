@extends('faculty-info.layouts.app')

@section('faculty-info.content')
    <div class="row">
        <div class="col-md-12">
            <div class="accordion" id="services-accordion">
                <div class="card">
                    <div class="card-header" id="bracu-sites-heading">
                        <h2 class="mb-0">
                            <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#bracu-sites" aria-expanded="true" aria-controls="bracu-sites">
                                Brac University Sites
                            </button>
                        </h2>
                    </div>
            
                    <div id="bracu-sites" class="collapse show" aria-labelledby="bracu-sites-heading" data-parent="#services-accordion">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 my-3">
                                    <div class="card">
                                        <div class="card-body bg-body">
                                            <div class="row">
                                                <div class="col-4 card-left-img" style="background-image: url('https://www.bracu.ac.bd/sites/default/files/resources/media/bracu_logo.png');"></div>
                                                <div class="col-8">
                                                    <h5 class="border-bottom"><a href="https://docs.google.com/document/d/1iL74M_f51qpN_goszBxL6BUpaCYIUsMJyy_tDAHTNBs/view" target="_blank">Brac University Official Website</a></h5>
                                                    <p>The official website of Brac University</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 my-3">
                                    <div class="card">
                                        <div class="card-body bg-body">
                                            <div class="row">
                                                <div class="col-4 card-left-img" style="background-image: url('https://www.bracu.ac.bd/sites/default/files/resources/media/bracu_logo.png');"></div>
                                                <div class="col-8">
                                                    <h5 class="border-bottom"><a href="usis.bracu.ac.bd" target="_blank">USIS</a></h5>
                                                    <p>Student Management and administration system</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 my-3">
                                    <div class="card">
                                        <div class="card-body bg-body">
                                            <div class="row">
                                                <div class="col-4 card-left-img" style="background-image: url('https://www.bracu.ac.bd/sites/default/files/resources/media/bracu_logo.png');"></div>
                                                <div class="col-8">
                                                    <h5 class="border-bottom"><a href="usis.bracu.ac.bd" target="_blank">buX</a></h5>
                                                    <p>LMS platform for students</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 my-3">
                                    <div class="card">
                                        <div class="card-body bg-body">
                                            <div class="row">
                                                <div class="col-4 card-left-img" style="background-image: url('https://www.bracu.ac.bd/sites/default/files/resources/media/bracu_logo.png');"></div>
                                                <div class="col-8">
                                                    <h5 class="border-bottom"><a href="usis.bracu.ac.bd" target="_blank">buX Studio</a></h5>
                                                    <p>CMS platform for managing buX content</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 my-3">
                                    <div class="card">
                                        <div class="card-body bg-body">
                                            <div class="row">
                                                <div class="col-4 card-left-img" style="background-image: url('https://www.bracu.ac.bd/sites/default/files/resources/media/bracu_logo.png');"></div>
                                                <div class="col-8">
                                                    <h5 class="border-bottom"><a href="usis.bracu.ac.bd" target="_blank">Brac University Library</a></h5>
                                                    <p>Official website of Brac University Ayesha Abed Library</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 my-3">
                                    <div class="card">
                                        <div class="card-body bg-body">
                                            <div class="row">
                                                <div class="col-4 card-left-img" style="background-image: url('https://www.bracu.ac.bd/sites/default/files/resources/media/bracu_logo.png');"></div>
                                                <div class="col-8">
                                                    <h5 class="border-bottom"><a href="usis.bracu.ac.bd" target="_blank">Brac University Admissions</a></h5>
                                                    <p>Student admissions portal for both undergraduate and postgraduate programs</p>
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
                    <div class="card-header" id="gsuite-services-heading">
                        <h2 class="mb-0">
                            <button class="btn btn-link btn-block text-left collapsed" type="button" data-toggle="collapse" data-target="#gsuite-services" aria-expanded="false" aria-controls="gsuite-services">
                                G-suite (Google) Services
                            </button>
                        </h2>
                    </div>
                    <div id="gsuite-services" class="collapse" aria-labelledby="gsuite-services-heading" data-parent="#services-accordion">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 my-3">
                                    <div class="card">
                                        <div class="card-body bg-body">
                                            <div class="row">
                                                <div class="col-4 card-left-img" style="background-image: url('https://www.google.com/gmail/about/static/images/logo-gmail.png?cache=1adba63');"></div>
                                                <div class="col-8">
                                                    <h5 class="border-bottom"><a href="https://mail.google.com" target="_blank">Gmail</a></h5>
                                                    <p>For emails</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 my-3">
                                    <div class="card">
                                        <div class="card-body bg-body">
                                            <div class="row">
                                                <div class="col-4 card-left-img" style="background-image: url('https://upload.wikimedia.org/wikipedia/commons/thumb/1/12/Google_Drive_icon_%282020%29.svg/1200px-Google_Drive_icon_%282020%29.svg.png');"></div>
                                                <div class="col-8">
                                                    <h5 class="border-bottom"><a href="https://drive.google.com" target="_blank">Google Drive</a></h5>
                                                    <p>Google cloud storage</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 my-3">
                                    <div class="card">
                                        <div class="card-body bg-body">
                                            <div class="row">
                                                <div class="col-4 card-left-img" style="background-image: url('https://play-lh.googleusercontent.com/uFAlmfmhz9p4KSueKwT6FwwreGiDXSgNeo65oF4F5ynnJucMvAJfsb7A507gOABg4yY');"></div>
                                                <div class="col-8">
                                                    <h5 class="border-bottom"><a href="https://docs.google.com" target="_blank">Google Document</a></h5>
                                                    <p>To work with cloud based doc/docx files (replacement of Microsoft Word). Supports collaboration with team</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 my-3">
                                    <div class="card">
                                        <div class="card-body bg-body">
                                            <div class="row">
                                                <div class="col-4 card-left-img" style="background-image: url('https://lh5.googleusercontent.com/jQF6tc89MDdueyHK-L0MMCZo58XVlDhBrHcC-2qOELv43541gTZKec0FJZjndyv2sfQuFmD8GTgQHvu2m6T7a1E=w1280');"></div>
                                                <div class="col-8">
                                                    <h5 class="border-bottom"><a href="https://sheets.google.com" target="_blank">Google Sheets</a></h5>
                                                    <p>To work with cloud based xls/xlsx files (replacement of Microsoft Excel). Supports collaboration with team</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 my-3">
                                    <div class="card">
                                        <div class="card-body bg-body">
                                            <div class="row">
                                                <div class="col-4 card-left-img" style="background-image: url('https://3.bp.blogspot.com/-Xgy8k-BxOfg/WgW4jipZLsI/AAAAAAAAulA/kRs0H-cGFXkIsdql6TMunGY5fzY4ZP4NgCK4BGAYYCw/s1600/google_slides1600.png');"></div>
                                                <div class="col-8">
                                                    <h5 class="border-bottom"><a href="https://slides.google.com" target="_blank">Google Slides</a></h5>
                                                    <p>To work with cloud based ppt/pptx files (replacement of Microsoft PowerPoint). Supports collaboration with team</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 my-3">
                                    <div class="card">
                                        <div class="card-body bg-body">
                                            <div class="row">
                                                <div class="col-4 card-left-img" style="background-image: url('https://animal-mama.com/wp-content/uploads/2019/01/google-forms.png');"></div>
                                                <div class="col-8">
                                                    <h5 class="border-bottom"><a href="https://forms.google.com" target="_blank">Google Forms</a></h5>
                                                    <p>Simple online form maker. Supports quiz/marked assignments and collaboration with team</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 my-3">
                                    <div class="card">
                                        <div class="card-body bg-body">
                                            <div class="row">
                                                <div class="col-4 card-left-img" style="background-image: url('https://upload.wikimedia.org/wikipedia/commons/thumb/c/c0/Google_Jamboard_logomark.svg/1200px-Google_Jamboard_logomark.svg.png');"></div>
                                                <div class="col-8">
                                                    <h5 class="border-bottom"><a href="https://jamboard.google.com" target="_blank">Google Jamboard</a></h5>
                                                    <p>A whiteboard to jam ideas in team collaborations</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 my-3">
                                    <div class="card">
                                        <div class="card-body bg-body">
                                            <div class="row">
                                                <div class="col-4 card-left-img" style="background-image: url('https://images.g2crowd.com/uploads/product/image/large_detail/large_detail_9461f02c23e995e5d5e46e2676d110af/draw-io.png');"></div>
                                                <div class="col-8">
                                                    <h5 class="border-bottom"><a href="https://draw.io" target="_blank">Draw.io</a></h5>
                                                    <p>To draw flowcharts and other flow diagrams online</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 my-3">
                                    <div class="card">
                                        <div class="card-body bg-body">
                                            <div class="row">
                                                <div class="col-4 card-left-img" style="background-image: url('https://upload.wikimedia.org/wikipedia/commons/thumb/a/a5/Google_Calendar_icon_%282020%29.svg/1200px-Google_Calendar_icon_%282020%29.svg.png');"></div>
                                                <div class="col-8">
                                                    <h5 class="border-bottom"><a href="https://calendar.google.com" target="_blank">Google Calendar</a></h5>
                                                    <p>Google Calendar to track appointments/etc</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 my-3">
                                    <div class="card">
                                        <div class="card-body bg-body">
                                            <div class="row">
                                                <div class="col-4 card-left-img" style="background-image: url('https://fonts.gstatic.com/s/i/productlogos/meet_2020q4/v1/web-96dp/logo_meet_2020q4_color_2x_web_96dp.png');"></div>
                                                <div class="col-8">
                                                    <h5 class="border-bottom"><a href="https://meet.google.com" target="_blank">Google Meet</a></h5>
                                                    <p>To conduct meetings and classes</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 my-3">
                                    <div class="card">
                                        <div class="card-body bg-body">
                                            <div class="row">
                                                <div class="col-4 card-left-img" style="background-image: url('https://www.cloudwise.cool/wp-content/uploads/2020/04/Distance-learning-page-Google-Classroom-1.png');"></div>
                                                <div class="col-8">
                                                    <h5 class="border-bottom"><a href="https://classroom.google.com" target="_blank">Google Classroom</a></h5>
                                                    <p>
                                                        Class management platform. <br>
                                                        **Join as teacher when prompted <br>
                                                        **Contact IT if your account appears to be of a student
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 my-3">
                                    <div class="card">
                                        <div class="card-body bg-body">
                                            <div class="row">
                                                <div class="col-4 card-left-img" style="background-image: url('https://colab.research.google.com/img/colab_favicon_256px.png');"></div>
                                                <div class="col-8">
                                                    <h5 class="border-bottom"><a href="https://colab.research.google.com/" target="_blank">Google Colab</a></h5>
                                                    <p>Online coding platform. Supports team collaboration and snippet-wise code execution</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 my-3">
                                    <div class="card">
                                        <div class="card-body bg-body">
                                            <div class="row">
                                                <div class="col-4 card-left-img" style="background-image: url('https://upload.wikimedia.org/wikipedia/commons/thumb/e/ee/Google_Sites_2019.svg/1024px-Google_Sites_2019.svg.png');"></div>
                                                <div class="col-8">
                                                    <h5 class="border-bottom"><a href="https://sites.google.com/" target="_blank">Google Sites</a></h5>
                                                    <p>Simple platform to make websites for free</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 my-3">
                                    <div class="card">
                                        <div class="card-body bg-body">
                                            <div class="row">
                                                <div class="col-4 card-left-img" style="background-image: url('data:image/png;base64,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');"></div>
                                                <div class="col-8">
                                                    <h5 class="border-bottom"><a href="https://youtube.com/" target="_blank">YouTube</a></h5>
                                                    <p>To upload lectures online for students</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 my-3">
                                    <div class="card">
                                        <div class="card-body bg-body">
                                            <div class="row">
                                                <div class="col-4 card-left-img" style="background-image: url('https://is1-ssl.mzstatic.com/image/thumb/Purple114/v4/73/13/13/73131307-6c39-52f8-bc52-a8c1f63fe535/source/512x512bb.jpg');"></div>
                                                <div class="col-8">
                                                    <h5 class="border-bottom"><a href="https://keep.google.com/" target="_blank">Google Keep</a></h5>
                                                    <p>Other services that are available but not as widely used</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 my-3">
                                    <div class="card">
                                        <div class="card-body bg-body">
                                            <div class="row">
                                                <div class="col-4 card-left-img" style="background-image: url('/img/google-logo.svg');"></div>
                                                <div class="col-8">
                                                    <h5 class="border-bottom"><a href="#/" target="_blank">Other Google Services</a></h5>
                                                    <p>Other services that are available but not as widely used</p>
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
                    <div class="card-header" id="other-services-heading">
                        <h2 class="mb-0">
                            <button class="btn btn-link btn-block text-left collapsed" type="button" data-toggle="collapse" data-target="#other-services" aria-expanded="false" aria-controls="other-services">
                                Other Services
                            </button>
                        </h2>
                    </div>
                    <div id="other-services" class="collapse" aria-labelledby="other-services-heading" data-parent="#services-accordion">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 my-3">
                                    <div class="card">
                                        <div class="card-body bg-body">
                                            <div class="row">
                                                <div class="col-4 card-left-img" style="background-image: url('https://ga1.imgix.net/logo/o/9460-1571335057-234728?auto=format&q=50&fit=fill');"></div>
                                                <div class="col-8">
                                                    <h5 class="border-bottom"><a href="#/" target="_blank">Formstack</a></h5>
                                                    <p>Coming Soon...</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 my-3">
                                    <div class="card">
                                        <div class="card-body bg-body">
                                            <div class="row">
                                                <div class="col-4 card-left-img" style="background-image: url('https://res-5.cloudinary.com/crunchbase-production/image/upload/c_lpad,f_auto,q_auto:eco/v1479214482/dzu3jzthbfkiblk3lesv.png');"></div>
                                                <div class="col-8">
                                                    <h5 class="border-bottom"><a href="#/" target="_blank">ZenDesk</a></h5>
                                                    <p>Coming Soon...</p>
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
    </div>
    {{-- <div class="row">
        <div class="col-md-12">
            <h5 class="border-bottom text-secondary">Brac University Sites</h5>
        </div>
        
        <div class="col-md-12 mt-4">
            <h5 class="border-bottom text-secondary">G-suite (Google) Services</h5>
        </div>
        
        <div class="col-md-12 mt-4">
            <h5 class="border-bottom text-secondary">Others</h5>
        </div>
        
    </div> --}}
@endsection