<button type="button" class="hidden" style="display: none" id="details-modal-btn" data-toggle="modal" data-target="#details-modal">show modal</button>
<div class="modal fade" id="details-modal" tabindex="-1" aria-labelledby="modal-title" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="details-modal-body">
                
            </div>
        </div>
    </div>
</div>

@include('offered-course.parts.scripts.show-details')
@include('offered-course.parts.scripts.view-builder')
@include('offered-course.parts.scripts.list-updator')