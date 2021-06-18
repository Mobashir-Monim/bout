<div class="input-group mb-3">
    <div class="input-group-prepend">
      <span class="input-group-text">Valid Till</span>
    </div>
    <input type="date" name="valid_till" id="valid_till" class="form-control" placeholder="Valid Till" value="{{ isset($announcement) ? Carbon\Carbon::parse($announcement->valid_till)->format('Y-m-d') : '' }}">
</div>