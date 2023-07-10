<div class="modal fade delete-confirmation-modal" id="deleteNoteModal" tabindex="-1" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered sm">
		<div class="modal-content">
			<a href="#" class="modal-close" title="Close" data-dismiss="modal"><img
					src="{{ asset('front/images/close.svg') }}" alt=""></a>
			<h5>Are you sure you want to delete this note?</h5>
			<ul>
				<li>
					<a href="javascript:void(0);" title="Cancel" class="pink-btn" data-dismiss="modal">Cancel</a>
				</li>
				<li>
					<a href="javascript:void(0);" title="Yes" class="pink-btn filled deleteNoteModal" data-id="">Yes</a>
				</li>
			</ul>
		</div>
	</div>
</div>

<div class="modal fade delete-confirmation-modal" id="leaveBatchModal" tabindex="-1" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered sm">
		<div class="modal-content">
			<a href="#" class="modal-close" title="Close" data-dismiss="modal">
				<img src="{{ asset('front/images/close.svg') }}" alt="">
			</a>
			<input type="hidden" name="workshop_id" value="" id="leaveWorkshopBatch" />
			<h5>Are you sure you want to leave this batch?</h5>
			<ul>
				<li>
					<a href="#" title="Cancel" class="pink-btn">Cancel</a>
				</li>
				<li>
					<a href="javascript:void(0);" title="Yes" class="pink-btn filled leaveWokshopBatch">Yes</a>
				</li>
			</ul>
		</div>
	</div>
</div>

<div class="modal fade add-notes-modal" id="addNoteModal" tabindex="-1" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered lg">
		<div class="modal-content">
			<div class="modal-heading">
				<h4 class="visible-xs title">Add New Note</h4>
				<a href="#" class="modal-close" title="Close" data-dismiss="modal">
					<svg xmlns="http://www.w3.org/2000/svg" width="17.138" height="17.142"
						viewBox="0 0 17.138 17.142">
						<path id="letter-x"
							d="M.243,1.43a.854.854,0,0,1,0-1.189.854.854,0,0,1,1.189,0L8.567,7.388,15.713.241A.836.836,0,1,1,16.89,1.43L9.756,8.566l7.135,7.147A.836.836,0,0,1,15.713,16.9L8.567,9.754,1.432,16.9a.854.854,0,0,1-1.189,0,.854.854,0,0,1,0-1.189L7.378,8.566Z"
							transform="translate(-0.002 0)" fill="#fff" />
					</svg>
				</a>
			</div>

			<div id="modalForm">
				<input type="hidden" class="workshop_id" value="">
				<input type="hidden" class="workshop_uuid" value="">
				<input type="hidden" class="id" value="">

				<div class="form-group">
					<label for="">Add Title<span> (50 letters)</span></label>
					<input type="text" class="form-control noteTitle" maxlength="50" required>
				</div>
				<div class="form-group has-textarea">
					<label>Write description<span>(1000 letters)</span></label>
					<textarea class="form-control description" maxlength="1000"></textarea>
				</div>
				<div class="btn-block">
					<button type="submit" class="submitNoteForm">
						<img src="{{ asset('front/images/check-ic-pink.svg') }}" alt="">
					</button>
				</div>
			</div>
		</div>
	</div>
</div>