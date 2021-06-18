<div class="my-2 py-2 border-top border-bottom" id="keywords-cont">
    @isset($announcement)
        @foreach ($announcement->keywords as $key => $keyword)
            <span class="badge d-inline-block badge-pill badge-secondary pl-3 py-0 pr-0 mb-1" id="keyword-{{ $key }}">
                <span class="d-inline-block text-left" id="keyword-{{ $key }}-val">{{ $keyword }}</span>

                <button class="btn btn-sm btn-dark d-inline-block ml-3" type="button" onclick="removeKeyword({{ $key }})" style="border-radius: 50%">
                    <i class="fas fa-times"></i>
                </button>
            </span>
        @endforeach
    @endisset
</div>
<div class="row">
    <div class="col-md-6 my-2">
        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text">Keyword</span>
            </div>
            <input type="text" name="keyword" id="keyword" class="form-control" placeholder="Keyword">
            <div class="input-group-append">
                <button class="btn btn-dark" type="button" onclick="addKeyword()"><i class="fas fa-plus"></i></button>
            </div>
        </div>
    </div>
    <div class="col-md-6 my-2">
        <button class="btn btn-dark w-100" type="button" onclick="postAnnouncement()">Post Announcement</button>
    </div>
</div>