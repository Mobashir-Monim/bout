<div class="row">
    <div class="col-md-8">
        <div class="card my-2">
            <div class="card-body">
               
                @if (!auth()->user()->hasRole('super-admin'))
                    <form action="{{ route('enterprise-parts.update', ['part' => $part->id]) }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-12 my-2">
                                <input type="text" name="name" {!! !$is_super_admin ? 'class="form-control disabled" disabled' : 'class="form-control"' !!} value="{{ $part->name }}" placeholder="Enterprise Part Name">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 my-2">
                                <input type="text" name="acronym" value="{{ $part->acronym }}" {!! !$is_super_admin ? 'class="form-control disabled" disabled' : 'class="form-control"' !!} placeholder="Enterprise Part Acronym">
                            </div>
                            <div class="col-md-6 my-2">
                                <button class="btn btn-dark w-100">Save</button>
                            </div>
                        </div>
                    </form>
                @else
                    <div class="row">
                        <div class="col-md-8">
                            <h6>{{ $part->name }}(<b>{{ $part->acronym }}</b>)</h6>
                            <p class="mb-0">Headed By: {{ $part->head->name }} [{{ $part->head->email }}]</p>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>