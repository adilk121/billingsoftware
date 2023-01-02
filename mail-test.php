<?php 
$mailtext='
<html>
<head>
<title>Invoice</title>
</head>

<body>
<div style="font-family:arial;">
<center>

<div style=" width:70%; height: auto; background-color: #00509a; background-image: linear-gradient(to right, #00509a, #017eb8, #00509a); padding:30px;">

    <div style="background-color:white; border-radius:16px; height:auto; padding:20px; width:80%;">  
<h3>Invoice sent</h3>

<p style="font-size:16px; color:#777777;">We have  sent your invoice to TradeKeyIndia. Com for product/service name of Rs.15,526.44.</p>
<br>
<p><a href="#" style="text-decoration:none; padding:15px; background-color:#0070ba; color:white; border-radius:30px;">View Your Invoice</a></p>
<p style="padding:20px; font-size:16px;"><a href="#" style="text-decoration:none; color:#15c;">View as customer.</a></p>
<hr>
<p style="font-size:17px; color:#009cde;">Note to</p>

<p style="font-size:17px;">Gold Membership with Dynamic Website</p>

</div>

</div>


</center>
</div>
</body>
</html>';

echo $mailtext;



$hostName = $_SERVER['HTTP_HOST'];	 
//Send to admin
//$toEmail = $compDATA['admin_email'];
$toEmail="astechmedia.in@gmail.com";
$subject = "Order Received From $hostName";
		        $from="rehantki@gmail.com";
				$Headers1 = "From: test<$from>\n";
				$Headers1 .= "X-Mailer: PHP/". phpversion();
				$Headers1 .= "X-Priority: 3 \n";
				$Headers1 .= "MIME-version: 1.0\n";
				$Headers1 .= "Content-Type: text/html; charset=iso-8859-1\n"; 
			//	@mail("$toEmail", "$subject", "$mailtext","$Headers1","-fenquiry@tradekeyindia.com");
				//@mail("amitabh.tradekeyindia@gmail.com", "Subject", "Msg1","$Headers1","-fenquiry@tradekeyindia.com");
				 $toEmail."<br>";
				 
				 echo "sent....";
				 
				 
				 
				 
/*				 
	// Send to client OR user			 
$toEmail="$reg_email";
$subject = "Order Confirmation From $hostName";
		       $from="$compDATA[admin_email]";
		       //$from="rehantki@gmail.com";
				$Headers1 = "From: $compDATA[admin_company_name]<$from>\n";
				$Headers1 .= "X-Mailer: PHP/". phpversion();
				$Headers1 .= "X-Priority: 3 \n";
				$Headers1 .= "MIME-version: 1.0\n";
				$Headers1 .= "Content-Type: text/html; charset=iso-8859-1\n"; 
				@mail("$toEmail", "$subject", "$mailtext","$Headers1","-fenquiry@tradekeyindia.com");
				//@mail("amitabh.tradekeyindia@gmail.com", "Subject", "Msg1","$Headers1","-fenquiry@tradekeyindia.com");
				 $toEmail."<br>";
				 
/////////////////////  Mailer to client end here ///////////////////////////////////////
///////////////// Mail To Admin //////////////////////////////////

$mail_to_admin="client_enquiry@tradekeyindia.com";
$sub_admin="Business Enquiry From $hostName";
$mail_admin_body = "$mailtext";	
$sender_admin =$reg_email;		
$headers_admin  = "MIME-Version: 1.0" . "\r\n";
$headers_admin .= "Content-type: text/html; charset=iso-8859-1" . "\r\n";
$headers_admin .= "from: ".$sender_admin."\n";
if($reg_email){
@mail($mail_to_admin,$sub_admin,$mail_admin_body,$headers_admin);

}
*/
