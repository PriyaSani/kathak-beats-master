<script src="{{ asset('dist/js/app.js') }}"></script>
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.12.0/jquery-ui.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="{{ asset('dist/js/jquery.validate.min.js') }}"></script>
<script src="{{ asset('dist/js/validation.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script src="{{ asset('dist/libs/dropify/js/dropify.min.js') }}"></script>
<script src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.5/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.print.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.colVis.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/litepicker/dist/litepicker.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.5.1/chart.min.js" ></script>
<script src="{{ asset('dist/libs/dropzone/dropzone.js')}}"></script>

<script src="{{ asset('templateEditor/ckeditor/ckeditor.js') }}"></script>

@if(route::is('admin.dashboard'))
	<script src="{{ asset('dist/js/dashboard.js')}}"></script>
@endif


<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="{{ asset('dist/js/developer.js') }}"></script>
<script>
	

	

	var drEvent = $('.dropify').dropify();

	drEvent.on('dropify.afterClear', function(event, element){
		$('#'+element.element.id).attr('required',true);
		$('#'+element.element.id).data('msg','Upload profile picture');
	});

	$(document).ready( function () {
	    $('#table_id').DataTable({
	        dom: 'Bfrtip',
	        buttons: [
	            'colvis',
	            {
	                extend: 'csv',
	                exportOptions: {
	                    columns: ':visible'
	                }
	            },
	        ]
	    });

	    $('#table_id_001').DataTable();

	    $('#table_id_002').DataTable();

	    $('#table_id_003').DataTable();

	    $('#table_id_004').DataTable();

	    $('#userAttendance').DataTable({
	        "pageLength": 50
	    });

	});

	
	$('.select2').select2({
		placeholder: "Select Instructor",
		maximumSelectionLength:3,
		language: {
	        // You can find all of the options in the language files provided in the
	        // build. They all must be functions that return the string that should be
	        // displayed.
	        maximumSelected: function (e) {
	            var t = "You can select maximum of " + e.maximum + " instructor";
	            e.maximum != 1 && (t += "s");
	            return t;
	        }
	    }
	})

	$('.filterSelect2').select2({
		placeholder: "Select Instructor",
		maximumSelectionLength:1
	})

	$('.ndatepicker').datepicker({
		dateFormat: 'dd/mm/yy'
	});

	const picker = new Litepicker({ 
    	element: document.getElementById('litepicker_start'),
    	singleMode: false,
  	});

  	const pickerEnd = new Litepicker({ 
    	element: document.getElementById('litepicker_end'),
    	singleMode: false,
  	});

	$(document).on('select2:select', function (e) {
    	var data = e.params.data;
    	if(data.length !== ''){
    		$('#instuctor').next().hide();
		}
	})

	$(document).on('change','#start_date',function(){
		if($(this).val() !== ''){
			$('#start_date-error').hide();
			$(this).removeClass('error');
		}

		if($(this).val() !== ''){
			$('#end_date-error').hide();
			$('#end_date').removeClass('error');
		}

		checkDate()
	});

	$(document).on('change','#end_date',function(){
		if($(this).val() !== ''){
			$('#start_date-error').hide();
			$('#start_date').removeClass('error');
		}

		if($(this).val() !== ''){
			$('#end_date-error').hide();
			$(this).removeClass('error');
		}

		checkDate()
		
	});

	function checkDate(){

		var start_date = $('#start_date').val();
		var end_date = $('#end_date').val();

		if(start_date !== '' && end_date != ''){
			var start_date = splitDate(start_date);
			var end_date = splitDate(end_date);

			if ((Date.parse(end_date) <= Date.parse(start_date))) {
		      alert("End date should be greater than Start date");
		      $('#end_date').val("");
		  	}
	    }
	}

	function splitDate(date){
		d = date.split('/');
		return d[2]+'-'+d[1]+'-'+d[0];
	}

</script>