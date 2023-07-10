@if(!is_null($notes))
	@foreach($notes as $nk => $nv)
		<div class="grid-item notes_{{ $nv->id }}">
			<div class="grid-content">
				<h5>{{ \Illuminate\Support\Str::limit($nv->title, 35, $end='...')  }}</h5>
				<p>{{ \Illuminate\Support\Str::limit($nv->notes, 180, $end='...')  }}</p>
				<div class="grid-footer">
					<ul>
						<li> 
							<a href="javascript:void(0);" class="editNote editNoteForm" data-id="{{ $nv->id }}" title="Edit">Edit</a>
						</li>
						<li>
							<a href="javascript:void(0);" class="deleteNote" title="Delete" data-id="{{ $nv->id }}">Delete</a>
						</li>
					</ul>
					<span>{{ date('d-m-Y',strtotime($nv->created_at)) }}</span>
				</div>
			</div>
		</div>
	@endforeach
@endif