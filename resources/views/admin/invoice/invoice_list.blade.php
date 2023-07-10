@extends('layouts.admin')
@section('title','Invoice List')
@section('content')
<!-- END: Top Bar -->
<h2 class="intro-y text-lg font-medium mt-10">
    Invoice List
</h2>

<div class="intro-y box col-span-12 lg:col-span-12">
    <div class="p-5">
        <form method="post" action="{{ route('admin.invoiceList') }}">  
            @csrf
            <div class="grid grid-cols-3 gap-2 mt-5">

                <div class="mt-3">
                    <label>Year</label>
                    <select class="form-control menulist col-span-3" name="year" id="year" data-msg="Select Status" >
                        @for($i = 0;$i <= 21; $i++)
                            @php $year = date('Y') - $i; @endphp
                            <option @if($financialYear == $year) selected @endif value="{{ $year }}" >
                                {{ $year }}
                            </option>
                        @endfor
                    </select>
                </div>
                
                <div class="mt-3">
                    <label>Payment Cycle</label>
                    <select class="form-control menulist col-span-3" name="payment_cycle" id="payment_cycle" data-msg="Select Status" >
                        <option value="">All</option>
                        <option @if($paymentCycle == 'MONTHLY') selected @endif value="MONTHLY">MONTHLY</option>
                        <option @if($paymentCycle == 'QUARTERLY') selected @endif value="QUARTERLY">QUARTERLY</option>
                    </select>
                </div>

                <div class="mt-3">
                    <label>Invoice Date Range</label>
                    <input data-daterange="true" class="datepicker form-control w-full block mx-auto col-span-3 daterange" name="invoice_date_range" value="{{ $invoiceDate }}">
                </div>
                
                <div class="mt-3">
                    <label>Student Name</label><br/>
                    <select name="student_name" data-search="true" class="form-control menulist col-span-3">
                        <option value="">Select Student Name</option>
                        @if(!is_null($getInvoice))
                            @foreach($getInvoice as $ik => $iv)
                                @if(!is_null($iv->user))
                                    <option @if($studentName == $iv->user->id) selected @endif value="{{ $iv->user->id }}">
                                        {{ $iv->user->name }}
                                    </option>
                                @endif
                            @endforeach
                        @endif
                    </select>
                </div>

                <div class="mt-3">
                    <label>Batch/Workshop Name</label><br/>
                    <select name="batch_name" data-search="true" class="tail-select w-full col-span-4 ml-auto" >
                        <option value="">Select Batch/Workshop Name</option>
                        @if(!is_null($getInvoice))
                            @foreach($getInvoice as $ik => $iv)
                                <option @if($batchName == $iv->workshop->id) selected @endif value="{{ $iv->workshop->id }}">
                                    {{ $iv->workshop->title }}
                                </option>
                            @endforeach
                        @endif
                    </select>
                </div>

                <div class="mt-3">
                    <label>Payment medium</label>
                    <select class="form-control menulist col-span-3" name="payment_medium" id="payment_medium" data-msg="Select Status" >
                        <option value="">All</option>
                        <option @if($paymentMedium == '0') selected @endif value="0">Online</option>
                        <option @if($paymentMedium == '2') selected @endif value="2">Offline</option>
                    </select>
                </div>
                
                <div class="mt-3">
                    <label>Payment Mode</label>
                    <select class="form-control menulist col-span-3" name="payment_mode" id="payment_mode" data-msg="Select Status" >
                        <option value="">All</option>
                        <option @if($paymentMode == '0') selected @endif value="0">Razor Pay</option>
                        <option @if($paymentMode == '1') selected @endif value="1">Cash</option>
                        <option @if($paymentMode == '2') selected @endif value="2">Online / UPI</option>
                        <option @if($paymentMode == '3') selected @endif value="1">Cheque</option>
                    </select>
                </div>

                <div class="mt-3">
                    <label>Linkage Status</label>
                    <select class="form-control menulist col-span-3" name="linkage_status" id="linkage_status" data-msg="Select Status" >
                        <option value="">All</option>
                        <option value="Unlinked">Unlinked</option>
                        <option value="Linked">Linked</option>
                    </select>
                </div>

            </div>
            <button type="submit" class="btn btn-primary w-30 mr-1 mb-2 mt-4" name="btn_submit" value="list">Filter</button>
            @if($filter == 1)
                <a href="{{ route('admin.invoiceList') }}" class="btn btn-danger w-30 mr-1 mb-2 mt-4" name="btn_submit" value="list">
                    Reset
                </a>
            @endif
        </form>
    </div>
</div>

<div class="grid grid-cols-12 gap-6 mt-5">
    
    <!-- BEGIN: Data List -->
    <div class="intro-y col-span-12 overflow-auto lg:overflow-hide">
        <table class="table table-report -mt-2" id="table_id">
            <thead>
                <tr>
                	<th class="whitespace-nowrap">Sr. No</th>
                    <th class="whitespace-nowrap">Invoice Number</th>
                    <th class="whitespace-nowrap">Order Number</th>
                    <th class="text-center whitespace-nowrap">Student Name</th>
                    <th class="text-center whitespace-nowrap">Batch/Workshop Name</th>
                    <th class="text-center whitespace-nowrap">Tenure </th>
                    <th class="text-center whitespace-nowrap">Payment Medium</th>
                    <th class="text-center whitespace-nowrap">Payment Mode</th>
                    <th class="text-center whitespace-nowrap">Invoice Date</th>
                    <th class="text-center whitespace-nowrap">Created on</th>
                    <th class="text-center whitespace-nowrap">Payment Remarks</th>
                    <th class="text-center whitespace-nowrap">Linkage Status</th>
                    <th class="text-center whitespace-nowrap">Payment Id</th>
                    <th class="text-center whitespace-nowrap">Action</th>
                </tr>
            </thead>
            <tbody>
            @if(!is_null($getInvoice))
            	@foreach($getInvoice as $ck => $sv)
	                <tr class="intro-x">
	                	<td class="text-center">{{ $loop->iteration }}</td>
	                    <td class="text-center"><a style="color: blue;" target="_blank" href="{{ route('admin.viewInvoice',base64_encode($sv->id)) }}">{{ $sv->invoice_number }}</a></td>
	                    <td class="text-center">{{ $sv->order_number }}</td>
	                    <td class="text-center">{{ !is_null($sv->user) ? $sv->user->name : "---------" }}</td>
	                    <td class="text-center">{{ $sv->workshop->title }}</td>

	                    <td class="text-center">{{ $sv->invoice_number }}</td>

                        @if($sv->medium == 2)
                            <td class="text-center">Offline</td>
                            <td class="text-center">
                                {{ $mode[$sv->mode] }}
                            </td>
                        @else 
                            <td class="text-center">Online</td>
                            <td class="text-center">Razor Pay</td>
                        @endif
                        <td class="text-center">{{ date('d/m/Y',strtotime($sv->invoice_date)) }}</td>

                        <td class="text-center">{{ date('d/m/Y',strtotime($sv->created_at)) }}</td>

                        <td class="text-center">{{ $sv->payment_remarks }}</td>

                        <td class="text-center">----</td>
                        <td class="text-center">{{ $sv->transaction_id }}</td>

	                    <td class="table-report__action w-56">
	                        <div class="flex justify-center items-center">
                                @if($sv->status != 'PENDING')
                                    <a href="{{ Config::get('constants.awsUrl') }}/invoice/{{ $sv->file }}" class="upload-link mr-3" target="_blank">
                                        Download 
                                    </a>
                                @endif
                                <!-- <a id="openModal" data-id="{{ $sv->id }}" class="mr-3" data-toggle="modal" data-target="#openProductItemModal" href="">
                                    Link
                                </a> -->
	                            <a class="flex items-center mr-3" href="{{ route('admin.editInvoice',$sv->id) }}"> <i data-feather="check-square" class="w-4 h-4 mr-1"></i> Edit </a>
	                            <a class="flex items-center text-theme-6" href="{{ route('admin.deleteInvoice',$sv->id) }}" onclick="return confirm('Do you want to delete this invoice ?')"> <i data-feather="trash-2" class="w-4 h-4 mr-1"></i> Delete </a>
	                        </div>
	                    </td>
	                </tr>
	            @endforeach
	        @endif
            </tbody>
        </table>
    </div>
    <!-- END: Data List -->
</div>
@endsection
@section('js')
<script type="text/javascript">
    $(document).ready(function(){
        $('.datepicker').val('');
    });
</script>
@endsection