$.ajaxSetup({
	headers: {
	    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	}
});

//open add new note modal
$(document).on('click','.addNewNote',function(){
	$('.title').text('Add New Note');
	$('.workshop_id').val($(this).data('id'))
	$('.workshop_uuid').val($(this).data('uuid'))
	$('#addNoteModal').modal('show')
})

//open delete note modal 
$(document).on('click','.deleteNote',function(){
	var id = $(this).data('id');
	$('#deleteNoteModal').modal('show')
	$('.deleteNoteModal').data('id',id)
});

//call delete not modal
$(document).on('click','.deleteNoteModal',function(){
	var id = $(this).data('id');
	$.ajax({
		url:'/user/delete-note',
		method:'post',
		data:{
			id : id
		},
		success: function(data){
			if(data){
				$('#deleteNoteModal').modal('hide')
				$('.notes_'+id).remove();
			}
		}
	});
})

$(document).on('click','.submitNoteForm',function(){

	var workshop_id = $('.workshop_id').val();
	var workshop_uuid = $('.workshop_uuid').val();
	var title = $('.noteTitle').val();
	var description = $('.description').val();
	var id = $('.id').val();

	$.ajax({
		url:'/user/save-workshop-note',
		method:'post',
		data:{
			workshop_id : workshop_id,
			title : title,
			description : description,
			id : id,
		},
		success: function(data){
			if(data){
				$('#addNoteModal').modal('hide')
				$('.notes-grid').html(data)
			}
		}
	});
});

$(document).on('click','.editNoteForm',function(){
	
	var id = $(this).data('id')

	$.ajax({
		url:'/user/edit-workshop-note',
		method:'post',
		data:{
			id : id,
		},
		success: function(data){
			if(data){
				$('#modalForm').empty();
				$('#modalForm').html(data);
				$('#addNoteModal').modal('show');
			}
		}
	});
})

