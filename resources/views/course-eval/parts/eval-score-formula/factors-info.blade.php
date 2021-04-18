<div class="row">
    <div class="col-md-12 text-right">
        <button type="button" class="btn btn-dark" id="modal-btn" data-toggle="modal" data-target="#factors-info-modal"><span class="material-icons-outlined">info</span></button>
    </div>
</div>


<div class="modal fade" id="factors-info-modal" tabindex="-1" aria-labelledby="modal-title" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" style="background: rgba(0,0,0,0)">
            <div class="modal-header bg-dark text-white">
                <h5 class="modal-title" id="modal-title">Factors Information</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body py-0" id="modal-body">
                <div class="row">
                    @foreach ($helper->formulaHelper->factors as $f => $factor)
                        <div class="col-md-6 card">
                            <div class="card-body">
                                <h5 class="border-bottom">{{ $factor['name'] . " ($f)" }}</h5>
                                <p>{{ ucfirst($factor['description']) }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>