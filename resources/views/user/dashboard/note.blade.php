<input type="hidden" class="workshop_id" value="{{ $getNoteData->workshop_id }}">
<input type="hidden" class="id" value="{{ $getNoteData->id }}">

<div class="form-group @if($getNoteData->title != '') hide-label @endif">
	<label for="">Add Title<span> (50 letters)</span></label>
	<input type="text" class="form-control noteTitle" maxlength="50" value="{{ $getNoteData->title }}" required>
</div>
<div class="form-group has-textarea @if($getNoteData->notes != '') hide-label @endif">
	<label>Write description<span>(1000 letters)</span></label>
	<textarea class="form-control description" maxlength="1000">{{ $getNoteData->notes }}</textarea>
</div>
<div class="btn-block">
	<button type="submit" class="submitNoteForm">
		<img src="{{ asset('front/images/check-ic-pink.svg') }}" alt="">
	</button>
</div>