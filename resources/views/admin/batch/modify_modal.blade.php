<div class="col-span-12 sm:col-span-12">
    <input type="hidden" name="id" value="{{ $getAttendanceDetail->id }}" />
    <input type="hidden" name="uuid" value="{{ $getAttendanceDetail->workshop->uuid }}" />
</div>
<div class="col-span-12 sm:col-span-12">
    <label for="modal-form-1" class="form-label">Title</label>
    <input type="text" class="form-control" id="modal-form-1" placeholder="Title" value="{{ $getAttendanceDetail->workshop->title }}">
</div>
<div class="col-span-12 sm:col-span-12">
    <label for="modal-form-mode" class="form-label">Mode</label>
    <input type="text" class="form-control" id="modal-form-mode" placeholder="example@gmail.com" value="{{ $getAttendanceDetail->workshop->engagement_mode == 1 ? 'Studio' : 'Online' }}">
</div>
<div class="col-span-12 sm:col-span-12">
    <label for="modal-form-date" class="form-label">Date</label>
    <input type="text" class="form-control" id="modal-form-date" placeholder="Date" value="{{ $getAttendanceDetail->date }}" disabled>
</div>
<div class="col-span-12 sm:col-span-6">
    <label for="modal-form-day" class="form-label">Day</label>
    <input type="text" class="form-control" id="modal-form-day" placeholder="Day" value="{{ date('l',strtotime($getAttendanceDetail->date)) }}" disabled>
</div>
<div class="col-span-12 sm:col-span-6">
    <label for="modal-form-time" class="form-label">Time</label>
    <input type="text" class="form-control" id="modal-form-time" placeholder="Time" value="{{ $getAttendanceDetail->start_time }} - {{ $getAttendanceDetail->end_time }}" disabled>
</div>

<div class="col-span-12 sm:col-span-12">
    <label for="modal-form-shifted_date" class="form-label">Shifted Date</label>
    <input type="text" class="form-control sdapicker" name="shifted_date" id="modal-form-shifted_date" placeholder="Shifted Date" required autocomplete="off">
</div>

<div class="col-span-12 sm:col-span-6">
    <label for="modal-form-start_time" class="form-label">Start Time</label>
    <input type="time" class="form-control" name="start_time" id="modal-form-start_time" placeholder="Start Time" required>
</div>

<div class="col-span-12 sm:col-span-6">
    <label for="modal-form-end_time" class="form-label">End Time</label>
    <input type="time" class="form-control" name="end_time" id="modal-form-end_time" placeholder="End Time" >
</div>


