<!DOCTYPE html>
<html lang="en">
<head>
  <title>Invoice Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
<style>
    body{margin-top:20px;
background:#eee;
}

/*Invoice*/

/*.invoice .top-left {
    font-size:65px;
	color:#3ba0ff;
}*/

.invoice .top-left {
	text-align:left;
	padding-right:20px;
}

.invoice .table-row {
	margin-left:-15px;
	margin-right:-15px;
	margin-top:25px;
}

.invoice .payment-info {
	font-weight:500;
}

.invoice .table-row .table>thead {
	border-top:1px solid #ddd;
}

.invoice .table-row .table>thead>tr>th {
	border-bottom:none;
}

.invoice .table>tbody>tr>td {
	padding:8px 20px;
}

.invoice .invoice-total {
	margin-right:-10px;
	font-size:16px;
}

.invoice .last-row {
	border-bottom:1px solid #ddd;
}

.invoice-ribbon {
	width:85px;
	height:88px;
	overflow:hidden;
	position:absolute;
	top:-1px;
	right:14px;
}

.ribbon-inner {
	text-align:center;
	-webkit-transform:rotate(45deg);
	-moz-transform:rotate(45deg);
	-ms-transform:rotate(45deg);
	-o-transform:rotate(45deg);
	position:relative;
	padding:7px 0;
	left:-5px;
	top:11px;
	width:120px;
	background-color:#66c591;
	font-size:15px;
	color:#fff;
}

.ribbon-inner:before,.ribbon-inner:after {
	content:"";
	position:absolute;
}

.ribbon-inner:before {
	left:0;
}

.ribbon-inner:after {
	right:0;
}

@media(max-width:575px) {
	.invoice .top-left,.invoice .top-right,.invoice .payment-details {
		text-align:center;
	}
	.pay_btn{
	    text-align:center;
	}
	
	.ali-left{
	    text-align:left !important;
	}
	
		.ali-right{
	    text-align:right !important;
	}

	.invoice .from,.invoice .to,.invoice .payment-details {
		float:none;
		width:100%;
		text-align:center;
		margin-bottom:25px;
	}

	.invoice p.lead,.invoice .from p.lead,.invoice .to p.lead,.invoice .payment-details p.lead {
		font-size:22px;
	}

	.invoice .btn {
		margin-top:10px;
	}
}

@media print {
	.invoice {
		width:900px;
		height:800px;
	}
}
    
</style>
</head>
<body>
<div class="container bootstrap snippets bootdeys">
<div class="row">
  <div class="col-sm-12">
	  	<div class="panel panel-default invoice" id="invoice">
		  <div class="panel-body">
			<div class="invoice-ribbon"><div class="ribbon-inner">PAID</div></div>
		    <div class="row">

				<!--<div class="col-sm-6 top-left">
					<i class="fa fa-rocket"></i>
				</div>-->

				<div class="col-sm-12 top-left">
						<h3 class="marginright text-center">PROFORMA INVOICE</h3>
						<span class="marginright">14 April 2020</span>
			    </div>
			<div class="col-xs-12 margintop pay_btn">
			    <br>
				<button class="btn btn-success" id="invoice-print"><i class="fa fa-print"></i> Print Invoice</button>
				<button class="btn btn-danger"><i class="fa fa-envelope-o"></i> Pay Online</button>
			</div>
		

			</div>
			<hr>
			<div class="row">
			    
			    	<div class="col-xs-6 from ali-left">
					<p class="lead marginbottom payment-info">Bill To : Rohtash</p>
					<p>Uttam Nagar
					<br>
					rohatash@gmail.com / 9654220520
					<br>
					GST No: 12345678
				    <br>
				    Due Date: 20-11-2020
				    <br>
				    Invoice No. :WKI2020071603
				    </p>
				<!--	<p>Email: john@doe.com</p>-->

			    </div>
			    

				<div class="col-xs-6 text-right payment-details ali-right">
					<p class="lead marginbottom payment-info">Astech Media (P) Limited</p>
					<p>WZ-197 IInd Floor, Main Najafgarh Road, Near Metro Pilor No. 649, Uttam Nagar, New Delhi-110059
					 <br>
					 Phone: 9958276296
					 <br>Email: billing@astechmedia.in
					 <br>GST No. :GST@123
					 <br>CIN No. :CIN@123</p>
					
					
				</div>

			

			   <!-- <div class="col-xs-4 text-right payment-details">
					<p class="lead marginbottom payment-info">Payment details</p>
					<p>Date: 14 April 2014</p>
					<p>VAT: DK888-777 </p>
					<p>Total Amount: $1019</p>
					<p>Account Name: Flatter</p>
			    </div>-->

			</div>

			<div class="row table-row">
				<table class="table table-striped ">
			      <thead>
			        <tr>
			          <th class="text-center" style="width:5%">#</th>
			          <th style="width:50%">Item</th>
			 <!--         <th class="text-right" style="width:15%">Quantity</th>
			          <th class="text-right" style="width:15%">Unit Price</th>-->
			          <th class="text-right" style="width:15%">Total Price</th>
			        </tr>
			      </thead>
			      <tbody>
			        <tr>
			          <td class="text-center">1</td>
			          <td>Dynamic Website (Dynamic Website For 1 Year)</td>
<!--			          <td class="text-right">10</td>
			          <td class="text-right">$18</td>-->
			          <td class="text-right">15000.00</td>
			        </tr>
			        <tr>
			          <td class="text-center">2</td>
			          <td>Domain Renewal (Domain Renewal For 2 Years)</td>
			  <!--        <td class="text-right">6</td>
			          <td class="text-right">$59</td>-->
			          <td class="text-right">1200.00</td>
			        </tr>
			        
			       </tbody>
			    </table>

			</div>
	
			<div class="row">
			<div class="col-xs-6 margintop">
			

			<!--	<button class="btn btn-success" id="invoice-print"><i class="fa fa-print"></i> Print Invoice</button>
				<button class="btn btn-danger"><i class="fa fa-envelope-o"></i> Pay Online</button>-->
			</div>
			<div class="col-xs-6 text-right pull-right invoice-total">
					  <p>Subtotal : 16200.00</p>
			          <p>Discount : 200.00 </p>
			          <p>Amount	: 16000.00 </p>
			          
			          <p>IGST@18% : 2880.00 </p>
			          <p style="color:darkblue; font-weight:bold; font-size:20px;">Total : 18880.00 </p>
			</div>
			
			</div>
					<hr>
			<p>Rupees Eightteen Thousand Eight Hundred and Eigthy Only</p>
<hr>

	<div class="row">
			    
			    	<div class="col-xs-6 from ali-left">
					<p class="lead marginbottom ">Note</p>
					<p>Thanks for your order.</p>
			 </div>
			 
			 	<div class="col-xs-6 from ali-left">
					<p class="lead marginbottom ">Terms and Conditions</p>
					<ul>
					    <li>Tenure of service and payment terms for this invoice would be governed as per the agreement between the Customer and  Web Key India.</li>
					    <li>Above information is not an invoice and only an estimate of services described above. If you have any concerns regarding services mentioned or cost please feel free to contact at  billing@webkeyindia.com</li>
					    <li>All cheques and Demand Draft to be made on the name of  "Web Key India" Send Payment at M/s Web Key India Add:44 A-B, WZ-197, Main Najafgarh Road, UTTAM NAGAR West Delhi, Delhi, 110059 Ph No:  +91-9958276296 or pay online:  https://www.webkeyindia.com/ccard/</li>
					   
					    
					</ul>
					
					
			 </div>
		
			</div>
			
				<div class="col-xs-12 margintop pay_btn">
			    <br>
				<button class="btn btn-success" id="invoice-print"><i class="fa fa-print"></i> Print Invoice</button>
				<button class="btn btn-danger"><i class="fa fa-envelope-o"></i> Pay Online</button>
			</div>

		  </div>
		</div>
	</div>
</div>
</div>

</body>
</html>
