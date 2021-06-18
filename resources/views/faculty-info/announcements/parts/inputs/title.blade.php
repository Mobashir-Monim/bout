<div class="col-md-12 my-2">
    <h3 class="border-bottom">{{ isset($announcement) ? 'Edit' : 'New' }} Announcement</h3>
    <div class="input-group mb-3">
        <div class="input-group-prepend">
        <span class="input-group-text">Title</span>
        </div>
        <input type="text" name="title" id="title" class="form-control" placeholder="Announcement Title" value="{{ isset($announcement) ? $announcement->title : '' }}">
    </div>
</div>