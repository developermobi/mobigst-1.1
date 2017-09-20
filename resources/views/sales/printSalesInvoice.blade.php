<head>
	<title>Print Invoice</title>
	<style>
	table td{
		padding:10px;
		font-size:12px;
	}
	.table-bordered{
		width:100%;
	}
	table{
		margin-bottom:10px;
	}
	table td span {
		color:blue;
	}
</style>
</head>

<body>
	<!-- <table  border="1"  cellspacing="10" width="100%">
		<tr>
			<td align="center" colspan="3"><strong>INVOICE COPY _______________</strong></td>
		</tr>
		<tr>
			<td width="50%" rowspan="2">
				<strong><h3>{{$data['data']['business_details'][0]->name}}</h3></strong>
				{{$data['data']['business_details'][0]->address}}, {{$data['data']['business_details'][0]->city}}, {{$data['data']['business_details'][0]->state}} - {{$data['data']['business_details'][0]->pincode}}<br>
				<strong>GSTIN</strong>: {{$data['gstin']}}<br>
				<strong>PAN</strong> : {{$data['data']['business_details'][0]->pan}}<br>
				<strong>CIN No</strong>.: U74900MH2011PTC216001
			</td>
			
			<td colspan="2">
				<strong>Billing Address:</strong><br>
				{{$data['data']['invoice_data'][0]->bill_address}}, {{$data['data']['invoice_data'][0]->bill_city}}, {{$data['data']['invoice_data'][0]->bill_state}} - {{$data['data']['invoice_data'][0]->bill_pincode}}
			</td>
		</tr>
		<tr>
			<td colspan="2">
				<strong>Shipping Address:</strong><br>  
				{{$data['data']['invoice_data'][0]->sh_address}}, {{$data['data']['invoice_data'][0]->sh_city}}, {{$data['data']['invoice_data'][0]->sh_state}} - {{$data['data']['invoice_data'][0]->sh_pincode}}
			</td>
		</tr>
		
		<tr>
			<td>
				<strong><p>Invoice No : {{$data['data']['invoice_data'][0]->invoice_no}}</p></strong>
				<strong><p>Invoice Date : {{$data['data']['invoice_data'][0]->invoice_date}}</p></strong>
				<strong><p>Ref Po:</p></strong>
			</td>
			
			<td style="border-bottom:1px solid #000;">
				<p><strong>Due Date : {{$data['data']['invoice_data'][0]->due_date}} </strong></p>
				<p><strong>Place of Supply : </strong> {{$data['data']['invoice_data'][0]->place_of_supply}} </p>
			</td>
			
			<td ><strong>CUSTOMER</strong> <br>
				<strong> GSTIN : </strong> {{$data['data']['invoice_data'][0]->contact_gstin}} <br>
				<?php
				$abc = substr($data['data']['invoice_data'][0]->contact_gstin, 2);
				$pin = substr($abc, 0, -3);
				?>
				<strong> PAN : </strong> {{$pin}} <br>
			</td>
		</tr>    
	</table>
	
	<table border="1" cellspacing="0" width="100%" >
		<tr>
			<td colspan="8" style="font-size:20px; color:#F00; font-weight:bold;" align="center">SALES INVOICE</td>
		</tr>
		<tr>
			<td width="5%">Sr. No.</td>
			<td>Description</td>
			<td>HSN</td>
			<td>Qty</td>
			<td>UOM</td>
			<td>Rate</td>
			<td>Discount</td>
			<td>Taxable value</td>
		</tr>
		@if(!empty($data['data']['invoice_details']))
		@foreach($data['data']['invoice_details'] as $key => $value)
		<tr>
			<td>{{ $key + 1}}</td>
			<td>{{ $value-> item_name }}</td>
			<td>{{ $value-> hsn_sac_no }}</td>
			<td>{{ $value-> quantity }}</td>
			<td>{{ $value-> unit }}</td>
			<td>{{ $value-> item_value }}</td>
			<td>{{ $value-> discount }}</td>
			<td>{{ $value-> rate }}</td>
		</tr>
		@endforeach
		@endif

		@if($data['data']['invoice_data'][0]->total_cgst_amount > 0)
		<tr>
			<td colspan="7" align="right">CGST <span>@{{$data['data']['invoice_details'][0]->cgst_percentage}}%</span></td>
			<td>{{$data['data']['invoice_data'][0]->total_cgst_amount}}</td>
		</tr>
		@endif

		@if($data['data']['invoice_data'][0]->total_sgst_amount > 0)
		<tr>
			<td colspan="7" align="right">SGST <span>@{{$data['data']['invoice_details'][0]->sgst_percentage}}%</span></td>
			<td>{{$data['data']['invoice_data'][0]->total_sgst_amount}}</td>
		</tr>
		@endif

		@if($data['data']['invoice_data'][0]->total_igst_amount > 0)
		<tr>
			<td colspan="7" align="right">IGST <span>@ {{$data['data']['invoice_details'][0]->igst_percentage}} %</span></td>
			<td>{{$data['data']['invoice_data'][0]->total_igst_amount}}</td>
		</tr>
		@endif

		@if($data['data']['invoice_data'][0]->total_cess_amount > 0)
		<tr>
			<td colspan="7" align="right">CESS <span>@{{$data['data']['invoice_details'][0]->cess_percentage}}%</span></td>
			<td>{{$data['data']['invoice_data'][0]->total_cess_amount}}</td>
		</tr>
		@endif

		@if($data['data']['invoice_data'][0]->is_freight_charge == 1)
		<tr>
			<td colspan="7" align="right">Freight Charges</td>
			<td>{{$data['data']['invoice_data'][0]->freight_charg}}</td>
		</tr>
		@endif

		@if($data['data']['invoice_data'][0]->is_lp_charge == 1)
		<tr>
			<td colspan="7" align="right">Loading and Packing Charges</td>
			<td>{{$data['data']['invoice_data'][0]->lp_charge}}</td>
		</tr>
		@endif

		@if($data['data']['invoice_data'][0]->is_insurance_charge == 1)
		<tr>
			<td colspan="7" align="right">Insurance Charges</td>
			<td>{{$data['data']['invoice_data'][0]->insurance_charge}}</td>
		</tr>
		@endif
		
		@if($data['data']['invoice_data'][0]->is_other_charge == 1)
		<tr>
			<td colspan="7" align="right">Other Charges</td>
			<td>{{$data['data']['invoice_data'][0]->other_charge}}</td>
		</tr>
		@endif
		
		<tr>
			<td colspan="7" align="right">Invoice Total</td>
			<td>{{$data['data']['invoice_data'][0]->grand_total}}</td>
		</tr>
		<tr>
			<td colspan="8"><strong>Total in words:</strong> {{$data['data']['invoice_data'][0]->total_in_words}}</td>
		</tr>

	</table>

	<table border="1" cellspacing="0" width="100%" >
		<tr>
			
			<td>
				Notes:<br>
				__________________________________<br>
				__________________________________<br>
				__________________________________
			</td>
			
			<td align="right">
				For {{$data['data']['business_details'][0]->name}}<br><br><br><br>
				Authorised Signatory
			</td>
		</tr>
	</table> -->
	
</body>
</html>