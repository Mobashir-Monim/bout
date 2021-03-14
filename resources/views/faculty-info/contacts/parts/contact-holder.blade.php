<div class="col-md-6 my-2">
    <div class="card">
        <div class="card-body">
            <h5 class="border-bottom mb-0">{{ $item['user']['name'] }}</h5>
            <h5><b>{{ $segment_name }}</b></h5>
            <p class="mb-0">
                <span class="material-icons-outlined">email</span>
                {{ $item['user']['email'] }}
            </p>
            <p class="mb-0">
                <span class="material-icons-outlined input-icon">smartphone</span>
                @if ($item['user']['show_phone'])
                    {{ $item['user']['phone'] }}
                @else
                    <i>Restricted Discoverability</i>
                @endif
            </p>
        </div>
    </div>
</div>