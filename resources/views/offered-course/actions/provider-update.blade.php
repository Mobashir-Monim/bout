@if (auth()->user()->hasRole('super-admin'))
    <div class="row">
        <div class="col-md-12 my-2">
            <div class="card">
                <div class="card-body">
                    <h5 class="border-bottom">Provider Update</h5>
                    <form action="{{ route('offered-courses.update.provider') }}" method="POST">
                        @csrf

                        @isset($helper)
                            <input type="hidden" name="semester" value="{{ $helper->semester }}">
                            <input type="hidden" name="year" value="{{ $helper->year }}">
                        @endisset

                        <div class="row">
                            <div class="col-md-5 my-2">
                                <input type="text" name="old_provider" class="form-control" placeholder="Old Provider">
                            </div>
                            <div class="col-md-5 my-2">
                                <select name="new_provider" class="form-control">
                                    <option value="">Please select new Provider</option>
                                    @foreach (App\Models\EnterprisePart::where('is_academic_part', true)->get() as $part)
                                        <option value="{{ $part->name }}">{{ $part->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2 my-2">
                                <button class="btn btn-dark w-100" type="submit"><span class="material-icons-outlined">check</span></button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endif