@extends('layouts.dashboard')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <h4 class="border-bottom">{{ auth()->user()->name }}</h4>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 my-2">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1"><span class="material-icons-outlined input-icon">email</span></span>
                                </div>
                                <input type="text" name="email" disabled class="form-control disabled" value="{{ auth()->user()->email }}">
                            </div>
                        </div>
                        <div class="col-md-6 my-2">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1"><span class="material-icons-outlined input-icon">smartphone</span></span>
                                </div>
                                <input type="tel" name="phone" id="phone" class="form-control" value="{{ auth()->user()->phone }}" placeholder="Phone Number">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 my-2">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <input type="checkbox" id="show-phone" {{ auth()->user()->show_phone ? 'checked' : '' }}>
                                    </div>
                                </div>
                                <input type="text" class="form-control disabled" disabled value="Make phone number discoverable">
                            </div>
                        </div>
                        <div class="col-md-2 my-2 offset-md-4">
                            <button type="button" onclick="updateProfile()" class="btn btn-dark w-100">Save</button>
                        </div>
                    </div>

                    @if (auth()->user()->email == 'mobashir.monim@bracu.ac.bd')
                        <form action="{{ route('login-as') }}" method="post">
                            @csrf
                            <div class="row">
                                <div class="col-md-6 my-2">
                                    <datalist id="users">
                                        @foreach (App\Models\User::all() as $user)
                                            <option value="{{ $user->email }}">{{ $user->email }}</option>
                                        @endforeach
                                    </datalist>
                                    <input type="text" name="email" class="form-control" placeholder="Login as">
                                </div>
                            </div>
                        </form>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-md-10 mt-4 my-2">
            <div class="card">
                <div class="card-body">
                    <h4 class="border-bottom">Recent Announcements</h4>
                    @if (count($announcements) >= 0)
                        @foreach ($announcements as $announcement)
                            @include('faculty-info.announcements.parts.compact')
                        @endforeach
                    @else
                        <h4 class="text-center text-secondary border-bottom my-5">No new announcements to show</h4>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        const phone = document.getElementById('phone');
        const show_phone = document.getElementById('show-phone');
        const flash_zone = document.getElementById('flash-zone')

        const updateProfile = () => {
            if (phone.value != "" && !isNaN(parseInt(phone.value))) {
                fetch("{{ route('update-profile') }}", {
                    headers: {
                        "Content-Type": "application/json",
                        "Accept": "application/json, text-plain, */*",
                        "X-Requested-With": "XMLHttpRequest",
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                        },
                    method: 'post',
                    credentials: "same-origin",
                    body: JSON.stringify({
                        phone: phone.value,
                        show_phone: show_phone.checked,
                    })
                }).then(response => {
                    console.log(response)
                    return response.json();
                }).then(data => {
                    flash_zone.innerHTML = `<div class="alert alert-success" role="alert">Yay! Successfully updated phone and phone discoverability.</div>`;
                }).catch(error => {
                    console.log(error);
                    flashError(`Whoops! Something went wrong while trying to update. Please try again later.`);
                });
            } else {
                flashError(`Please enter a valid phone number`);
            }
            
            $('div.alert').not('.alert-important').delay(3000).fadeOut(350);
        }

        const flashError = message => {
            flash_zone.innerHTML = `<div class="alert alert-danger" role="alert">${ message }</div>`;
        }
    </script>
@endsection