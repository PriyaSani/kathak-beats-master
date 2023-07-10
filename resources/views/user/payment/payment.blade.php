@extends('layouts.user')
@section('title','User Payment')
@section('content')
@section('wrapper-class','has-page-header fix-tabbing-wrapper-mble')
@if(!is_null($getInvoice) || !is_null($getTransactions) || !is_null($getPaidInvoice))
	<div class="right-detail">

		<div class="admin-page-header  fix-tabbing-mble">
			<div class="tabbing-link">
				<ul class="tabbing-list">
					@if(!is_null($getInvoice))
						<li><a href="#" class="active" title="Pending" data-link="pending">Pending</a></li>
					@endif
					<li><a href="#" title="Transactions" data-link="transaction">Transactions</a></li>
					@if(!is_null($getPaidInvoice))
						<li><a href="#" title="Invoices" data-link="invoice">Invoices</a></li>
					@endif
				</ul>
			</div>
		</div>

		<div class="admin-page-content tabbing-content">
			@if(!is_null($getInvoice))
				<div class="tabbing-outer active" data-content="pending">
					@foreach($getInvoice as $ik => $iv)
						<div class="pending-payment-wrapper border-block">
							<div class="container">
								<h5>{{ $iv->workshop->title }}</h5>
								<div class="payment-inner">
									<ul class="partcipant-badge-list">
										<!-- <li>
											<em><img src="{{ asset('front/images/users-gray.svg') }}" alt=""></em>
											{{ $iv->workshop->students }} Participants
										</li> -->

										<li>
											<em><img src="{{ asset('front/images/calendar-gray.svg') }}" alt=""></em>
											{{ date('d M',strtotime($iv->workshop->start_date)) }} - {{ date('d M',strtotime($iv->workshop->end_date)) }}
											
										</li>
										<li class="no-before">
											@if($iv->workshop->engagement_type == 1)
												@if($iv->workshop->engagement_mode == 1)
													<span class="tag green sm">Studio Batch</span>
												@else
													<span class="tag yellow sm">Online Batch</span>
												@endif
											@else
												@if($iv->workshop->engagement_mode == 1)
													<span class="tag green sm">Studio Workshop</span>
												@else
													<span class="tag yellow sm">Online Workshop</span>
												@endif
											@endif
										</li>
									</ul>

									<a href="javascript:void(0);" title="PAY NOW" class="pink-btn payNow filled" data-id="{{ base64_encode($iv->id) }}">PAY NOW</a>

									<span class="price">Amount Due <!-- For Feb 2021 -->: ₹ {{ $iv->amount }} <span style="font-size: 10px;color:#fc9898">(*Inclusive of taxes)</span></span>
								</div>
							</div>
						</div>
					@endforeach
				</div>
			@endif

			@if(!is_null($getPaidInvoice))
				<div class="tabbing-outer" data-content="transaction">
					<div class="date-group-outer border-block">
						<div class="form-group custom-date-picker secondary">
							<input type="text" class="form-control sm datepicker startDate" Value="{{ date('d-m-Y') }}" >
						</div>
						<div class="form-group custom-date-picker secondary">
							<input type="text" class="form-control sm datepicker endDate" placeholder="To">
						</div>
					</div>
					<div class="custom-table-outer">
						<div class="custom-table-heading border-block">
							<div class="container">
								<h5 class="number">No.</h5>
								<h5 class="large">Batch Name</h5>
								<h5 class="extra-small">Amount</h5>
								<h5>Date & Time</h5>
								<h5 class="small">Status</h5>
							</div>
						</div>
						<div class="paid-invoice-content">
							@foreach($getPaidInvoice as $ik => $iv)
								<div class="custom-table-content border-block">
									<div class="container">
										<span>{{ $loop->iteration }}</span>
										<h6>{{ $iv->workshop->title }}</h6>
										<p class="amount black-text">₹ {{ $iv->amount }}</p>
										<p class="gray-text date-time">{{ date('d-m-y',strtotime($iv->invoice_date)) }}</p>
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
						</div>
					</div>
				</div>
			@endif

			@if(!is_null($getPaidInvoice))
				<div class="tabbing-outer" data-content="invoice">
					<div class="date-group-outer border-block">
						<div class="form-group custom-date-picker secondary">
							<input type="text" class="form-control sm datepicker inStart" Value="{{ date('d-m-Y') }}">
						</div>
						<div class="form-group custom-date-picker secondary">
							<input type="text" class="form-control sm datepicker inEnd" placeholder="To">
						</div>
					</div>
					<div class="document-list">
						@foreach($getPaidInvoice as $ik => $iv)
							<div class="document-list-item border-block">
								<div class="container">
									<p><em><img src="{{ asset('front/images/pdf.svg') }}" alt=""></em>{{ $iv->workshop->title }} {{ $iv->file }}</p>
									<a href="{{ Config::get('constants.awsUrl') }}/invoice/{{ $iv->file }}" class="upload-link" target="_blank"><img src="{{ asset('front/images/download-ic.svg') }}"
											alt=""></a>
								</div>
							</div>
						@endforeach
					</div>
				</div>
			@endif
		</div>
		
	</div>
@else 
	<div class="right-detail">
		<div class="admin-page-content">
			<div class="container">
				<div class="empty-content">
					<em><img src="{{ asset('front/images/empty-3.svg') }}" alt=""></em>
					<p>You have zero payment transactions!</p>
				</div>
			</div>
		</div>
	</div>
@endif

@endsection
