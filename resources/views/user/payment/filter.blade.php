@if($type == 'transaction')
	@if(!is_null($getInvoice))
		@foreach($getInvoice as $ik => $iv)
			<div class="custom-table-content border-block">
				<div class="container">
					<span>{{ $loop->iteration }}</span>
					<h6>{{ $iv->workshop->title }}</h5>
					<p class="amount black-text">₹ {{ $iv->amount }}</p>
					<p class="gray-text date-time">{{ date('d-m-y, h:i A',strtotime($iv->created_at)) }}</p>
					@if($iv->status == 'PAID')
						<em>{{ $iv->status }}</em>
					@elseif($iv->status == 'PENDING')
						<em class="yellow">{{ $iv->status }}</em>
					@else
						<em class="red">{{ $iv->status }}</em>
					@endif
				</div>
			</div>
		@endforeach
	@endif
@endif

@if($type == 'invoice')
	@if(!is_null($getInvoice))
		@foreach($getInvoice as $ik => $iv)
			<div class="document-list-item border-block">
				<div class="container">
					<p><em><img src="{{ asset('front/images/pdf.svg') }}" alt=""></em>{{ $iv->workshop->title }} {{ $iv->file }}</p>
					<a href="{{ asset('invoice') }}/{{ $iv->file }}" class="upload-link" target="_blank">
						<img src="{{ asset('front/images/download-ic.svg') }}" alt="">
					</a>
				</div>
			</div>
		@endforeach
	@endif
@endif