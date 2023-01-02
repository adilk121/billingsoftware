<?php
ob_start();
require_once("includes/dbsmain.inc.php");
date_default_timezone_set("Asia/Kolkata"); 
include("site-main-query.php");
$site_url=$compDATA['admin_website_url'];
$curr_date=date("Y-m-d");



      /*   $to = "rehantki@gmail.com";
         $subject = "This is subject";
         
         $message = "testing";

         $header = "From:rehantki@gmail.com; \r\n";
         $header .= "MIME-Version: 1.0\r\n";
         $header .= "Content-type: text/html\r\n";
         
         $retval = mail ($to,$subject,$message,$header);
         
         if( $retval == true ) {
            echo "Message sent successfully...";
         }else {
            echo "Message could not be sent...";
         }*/
         
    function get_domain($url){
    $charge = explode('/', $url);
    $charge = $charge[2]; 
    return $charge;
    }


function mail_send_function($to,$from,$sub,$msg){
    
//$toEmail = "rehantki@gmail.com";
$toEmail="$to";
$subject = "$sub";
		        $from="$from";
				$Headers1 = "From: <$from>\n";
				$Headers1 .= "X-Mailer: PHP/". phpversion();
				$Headers1 .= "X-Priority: 3 \n";
				$Headers1 .= "MIME-version: 1.0\n";
				$Headers1 .= "Content-Type: text/html; charset=iso-8859-1\n"; 
				@mail("$toEmail", "$subject", "$msg","$Headers1","-fenquiry@tradekeyindia.com");
				//@mail("amitabh.tradekeyindia@gmail.com", "Subject", "Msg1","$Headers1","-fenquiry@tradekeyindia.com");
				 $toEmail."<br>";
}



$invoice_sql=db_query("select * from tbl_invoice where invoice_status='Unpaid'");
if(mysqli_num_rows($invoice_sql)>0)
{
while($invoice_res=mysqli_fetch_array($invoice_sql))
{
$order_sql=db_query("select * from tbl_invoice_order where invoice_order_id='$invoice_res[order_id]' and  invoice_order_status='Active' ");
while($order_res=mysqli_fetch_array($order_sql))
{
  
//////////// Billing company section start ////////////////   
 

$title_invoice="Proforma Invoice";
$a="a";  


$inv_title_lower=strtolower($title_invoice);

$billing_comp_sql_mail=db_query("select billing_company_email,billing_company_name,billing_company_website,billing_company_phone_no from tbl_billing_company where billing_company_id='$invoice_res[invoice_billing_company_id]'");
$billing_comp_res_mail=mysqli_fetch_array($billing_comp_sql_mail);


$client_sql_mail=db_query("select client_company_name,client_name,client_email from tbl_clients where client_id='$invoice_res[invoice_client_id]'");
$client_res_mail=mysqli_fetch_array($client_sql_mail);
$client_comp_name="";
if($client_res_mail['client_company_name']!="")
{$client_comp_name=" (".$client_res_mail['client_company_name'].")";}


$mailtextComp='
<html>
<head>
<title>'.$title_invoice.'</title>
</head>

<body>
<div style="font-family:arial;">
<center>

<div style=" width:70%; height: auto; background-color: #00509a; background-image: linear-gradient(to right, #00509a, #017eb8, #00509a); padding:30px;">

    <div style="background-color:white; border-radius:16px; height:auto; padding:20px; width:80%;">  
<h3>'.$title_invoice.' Sent</h3>

<p style="font-size:16px; color:#777777;">We have sent your '.$inv_title_lower.' to '.$client_res_mail["client_name"].''.$client_comp_name.' of Rs.'.$invoice_res["invoice_grand_total"].'.</p>
<br>
<p><a href="'.$compDATA["admin_website_url"].'/view-mail-invoice.php?invoice_id='.$invoice_res["invoice_id"].'" style="text-decoration:none; padding:15px; background-color:#0070ba; color:white; border-radius:30px;">View customer invoice</a></p>
<br>
<hr>';



if($invoice_res['invoice_recipient_note']!="")
{
$mailtextComp.='
<p style="font-size:17px; color:#009cde;">Note to</p>
<p style="font-size:17px;">'.$invoice_res["invoice_recipient_note"].'</p>';
}

$mailtextComp.='
</div>
</div>


</center>
</div>
</body>
</html>';

////////////////// Billing company section end ////////////////////
  
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////  
  
  
   //////////// Mail to Client section start ////////////////   
 

 $billing_comp_website=get_domain($billing_comp_res_mail["billing_company_website"]);
 
$mailtextClient='
<html>
<head>
<title>'.$title_invoice.'</title>
</head>

<body>
<div style="font-family:arial;">
<center>
<div style="width:75%;">
<p style="color:#777777; padding:40px; background-color:#f5f5f5; font-size:13px;">
Dear '.$client_res_mail["client_name"].''.$client_comp_name.',
</p>
</div>

<div style=" width:70%; height: auto; background-color: #00509a; background-image: linear-gradient(to right, #00509a, #017eb8, #00509a); padding:30px;">

    <div style="background-color:white; border-radius:16px; height:auto; padding:20px; width:80%;">  
<h3>You have received '.$a.' '.$inv_title_lower.'.</h3>

<br>
<p style="font-size:16px; color:#777777;">'.$billing_comp_res_mail["billing_company_name"].' sent you '.$a.' '.$inv_title_lower.' Rs.'.$invoice_res["invoice_grand_total"].'.</p>
<br>
<p><a href="'.$compDATA["admin_website_url"].'/view-mail-invoice.php?invoice_id='.$invoice_res["invoice_id"].'" style="text-decoration:none; padding:15px; background-color:#0070ba; color:white; border-radius:30px;">View and pay invoice</a></p>
';

$du_date=date("d M Y",strtotime($invoice_res['invoice_due_date']));
$mailtextClient.='<p style="padding:20px; font-size:16px;"><a style="text-decoration:none; color:#15c;">Due date: '.$du_date.'</a></p>';


$mailtextClient.='<hr>';

if($invoice_res['invoice_recipient_note']!="")
{
$mailtextComp.='
<p style="font-size:17px; color:#009cde;">Note to</p>
<p style="font-size:17px;">'.$invoice_res["invoice_recipient_note"].'</p>';
}

$mailtextClient.='

</div>

</div>




<div style="width:75%; text-align:left; padding:10px;">
<p>
It is recommended that you have to pay your invoice amount before the due date, so that your services can run smoothly without any disturbance. 
</p>
<p>In case you have any queries, please visit us at '.$billing_comp_website.' or call us  on '.$billing_comp_res_mail["billing_company_phone_no"].'.</p>

<p>
Best Regards,
<br>
Billing Team
<br>
'.$billing_comp_res_mail["billing_company_name"].'
<br>
</p>
</div>

</center>


</div>
</body>
</html>';

////////////////// Mail to Client section end ////////////////////
  
  
  
   if($order_res['invoice_order_invoice_frequency']=="Monthly")
    {
      $due_date=$invoice_res['invoice_due_date']; 
      $before_due_date=date('Y-m-d', strtotime('-5 day', strtotime($due_date)));
      $mail_send_date=db_scalar("select invoice_order_mail_send_date from tbl_invoice_order where invoice_order_id='$order_res[invoice_order_id]'");
         
      if($due_date>=$curr_date)
      {
          if($curr_date>=$before_due_date)
          {
               // SENDING MAIL DAILY TILL DUE DATE 
                if($mail_send_date=="0000-00-00")
                {
                    
              
// Send to billing company
$sub="We've sent your $inv_title_lower ($invoice_res[invoice_no]) for Rs.$invoice_res[invoice_grand_total]";
mail_send_function($billing_comp_res_mail['billing_company_email'],$client_res_mail['client_email'],$sub,$mailtextComp);


// Send to client
$sub="$title_invoice From $billing_comp_res_mail[billing_company_name] ($invoice_res[invoice_no])";
mail_send_function($client_res_mail['client_email'],$billing_comp_res_mail['billing_company_email'],$sub,$mailtextClient);

			 
				 
				 
		//	echo "date nhi hai or mail sent bhi kar diya !";	 
                    
                   db_query("update tbl_invoice_order set invoice_order_mail_send_date='$curr_date' where invoice_order_id='$order_res[invoice_order_id]'  ");
                }else{
                   
                    $next_mail_send_date=date('Y-m-d', strtotime('+1 day', strtotime($mail_send_date)));
                     if($curr_date==$next_mail_send_date)
                     {
// Send to billing company
$sub="We've sent your $inv_title_lower ($invoice_res[invoice_no]) for Rs.$invoice_res[invoice_grand_total]";
mail_send_function($billing_comp_res_mail['billing_company_email'],$client_res_mail['client_email'],$sub,$mailtextComp);


// Send to client
$sub="$title_invoice From $billing_comp_res_mail[billing_company_name] ($invoice_res[invoice_no])";
mail_send_function($client_res_mail['client_email'],$billing_comp_res_mail['billing_company_email'],$sub,$mailtextClient);


                         
                       //  echo "mail sent";
                         db_query("update tbl_invoice_order set invoice_order_mail_send_date='$curr_date' where invoice_order_id='$order_res[invoice_order_id]'  ");
                     }
                    
                    
                }
               
                
          }
     
      }else{
      
$next_mail_send_date=date('Y-m-d', strtotime('+7 day', strtotime($mail_send_date)));

if($curr_date==$next_mail_send_date)
{
    
// Send to billing company
$sub="We've sent your over due $inv_title_lower ($invoice_res[invoice_no]) for Rs.$invoice_res[invoice_grand_total]";
mail_send_function($billing_comp_res_mail['billing_company_email'],$client_res_mail['client_email'],$sub,$mailtextComp);


// Send to client
$sub="Over due $inv_title_lower From $billing_comp_res_mail[billing_company_name] ($invoice_res[invoice_no])";
mail_send_function($client_res_mail['client_email'],$billing_comp_res_mail['billing_company_email'],$sub,$mailtextClient);


  
    
//echo "current date badi hai (send weekly mail)";
  db_query("update tbl_invoice_order set invoice_order_mail_send_date='$curr_date' where invoice_order_id='$order_res[invoice_order_id]'  ");
}

         
      }
      
    }
   
    
    

    
  
 if($order_res['invoice_order_invoice_frequency']=="Quarterly")
    {
      $due_date=$invoice_res['invoice_due_date']; 
      $before_due_date=date('Y-m-d', strtotime('-10 day', strtotime($due_date)));
      $mail_send_date=db_scalar("select invoice_order_mail_send_date from tbl_invoice_order where invoice_order_id='$order_res[invoice_order_id]'");
         
      if($due_date>=$curr_date)
      {
          if($curr_date>=$before_due_date)
          {
               // SENDING MAIL DAILY TILL DUE DATE 
                if($mail_send_date=="0000-00-00")
                {
                                  
// Send to billing company
$sub="We've sent your $inv_title_lower ($invoice_res[invoice_no]) for Rs.$invoice_res[invoice_grand_total]";
mail_send_function($billing_comp_res_mail['billing_company_email'],$client_res_mail['client_email'],$sub,$mailtextComp);


// Send to client
$sub="$title_invoice From $billing_comp_res_mail[billing_company_name] ($invoice_res[invoice_no])";
mail_send_function($client_res_mail['client_email'],$billing_comp_res_mail['billing_company_email'],$sub,$mailtextClient);

			 
                   // echo "date nhi hai or mail sent bhi kar diya !";
                     db_query("update tbl_invoice_order set invoice_order_mail_send_date='$curr_date' where invoice_order_id='$order_res[invoice_order_id]'  ");
                }else{
                    
                    $next_mail_send_date=date('Y-m-d', strtotime('+2 day', strtotime($mail_send_date)));
                     if($curr_date==$next_mail_send_date)
                     {
                     // Send to billing company
$sub="We've sent your $inv_title_lower ($invoice_res[invoice_no]) for Rs.$invoice_res[invoice_grand_total]";
mail_send_function($billing_comp_res_mail['billing_company_email'],$client_res_mail['client_email'],$sub,$mailtextComp);


// Send to client
$sub="$title_invoice From $billing_comp_res_mail[billing_company_name] ($invoice_res[invoice_no])";
mail_send_function($client_res_mail['client_email'],$billing_comp_res_mail['billing_company_email'],$sub,$mailtextClient);


                      //   echo "mail sent";
                        db_query("update tbl_invoice_order set invoice_order_mail_send_date='$curr_date' where invoice_order_id='$order_res[invoice_order_id]'  ");
                     }
                    
                    
                }
               
                
          }
     
      }else{
      
$next_mail_send_date=date('Y-m-d', strtotime('+7 day', strtotime($mail_send_date)));

if($curr_date==$next_mail_send_date)
{
    
    // Send to billing company
$sub="We've sent your over due $inv_title_lower ($invoice_res[invoice_no]) for Rs.$invoice_res[invoice_grand_total]";
mail_send_function($billing_comp_res_mail['billing_company_email'],$client_res_mail['client_email'],$sub,$mailtextComp);


// Send to client
$sub="Over due $inv_title_lower From $billing_comp_res_mail[billing_company_name] ($invoice_res[invoice_no])";
mail_send_function($client_res_mail['client_email'],$billing_comp_res_mail['billing_company_email'],$sub,$mailtextClient);


//echo "current date badi hai (send weekly mail)";
  db_query("update tbl_invoice_order set invoice_order_mail_send_date='$curr_date' where invoice_order_id='$order_res[invoice_order_id]'  ");
}


      }
      
    }
    
    
    
    
    if($order_res['invoice_order_invoice_frequency']=="Half Yearly")
    {
      $due_date=$invoice_res['invoice_due_date']; 
      $before_due_date=date('Y-m-d', strtotime('-15 day', strtotime($due_date)));
      $mail_send_date=db_scalar("select invoice_order_mail_send_date from tbl_invoice_order where invoice_order_id='$order_res[invoice_order_id]'");
         
      if($due_date>=$curr_date)
      {
          if($curr_date>=$before_due_date)
          {
               // SENDING MAIL DAILY TILL DUE DATE 
                if($mail_send_date=="0000-00-00")
                {

// Send to billing company
$sub="We've sent your $inv_title_lower ($invoice_res[invoice_no]) for Rs.$invoice_res[invoice_grand_total]";
mail_send_function($billing_comp_res_mail['billing_company_email'],$client_res_mail['client_email'],$sub,$mailtextComp);


// Send to client
$sub="$title_invoice From $billing_comp_res_mail[billing_company_name] ($invoice_res[invoice_no])";
mail_send_function($client_res_mail['client_email'],$billing_comp_res_mail['billing_company_email'],$sub,$mailtextClient);


                    
                   // echo "date nhi hai or mail sent bhi kar diya !";
                    db_query("update tbl_invoice_order set invoice_order_mail_send_date='$curr_date' where invoice_order_id='$order_res[invoice_order_id]'  ");
                }else{
                    
                    $next_mail_send_date=date('Y-m-d', strtotime('+3 day', strtotime($mail_send_date)));
                     if($curr_date==$next_mail_send_date)
                     {
                         
// Send to billing company
$sub="We've sent your $inv_title_lower ($invoice_res[invoice_no]) for Rs.$invoice_res[invoice_grand_total]";
mail_send_function($billing_comp_res_mail['billing_company_email'],$client_res_mail['client_email'],$sub,$mailtextComp);


// Send to client
$sub="$title_invoice From $billing_comp_res_mail[billing_company_name] ($invoice_res[invoice_no])";
mail_send_function($client_res_mail['client_email'],$billing_comp_res_mail['billing_company_email'],$sub,$mailtextClient);


                         
                       //  echo "mail sent";
                          db_query("update tbl_invoice_order set invoice_order_mail_send_date='$curr_date' where invoice_order_id='$order_res[invoice_order_id]'  ");
                     }
                    
                    
                }
               
                
          }
     
      }else{
      
$next_mail_send_date=date('Y-m-d', strtotime('+7 day', strtotime($mail_send_date)));

if($curr_date==$next_mail_send_date)
{
    
// Send to billing company
$sub="We've sent your over due $inv_title_lower ($invoice_res[invoice_no]) for Rs.$invoice_res[invoice_grand_total]";
mail_send_function($billing_comp_res_mail['billing_company_email'],$client_res_mail['client_email'],$sub,$mailtextComp);


// Send to client
$sub="Over due $inv_title_lower From $billing_comp_res_mail[billing_company_name] ($invoice_res[invoice_no])";
mail_send_function($client_res_mail['client_email'],$billing_comp_res_mail['billing_company_email'],$sub,$mailtextClient);


//echo "current date badi hai (send weekly mail)";
  db_query("update tbl_invoice_order set invoice_order_mail_send_date='$curr_date' where invoice_order_id='$order_res[invoice_order_id]'  ");
  
}

         


      }
      
    }
    
    
    
      if($order_res['invoice_order_invoice_frequency']=="Yearly")
    {
      $due_date=$invoice_res['invoice_due_date']; 
      $before_due_date=date('Y-m-d', strtotime('-20 day', strtotime($due_date)));
      $mail_send_date=db_scalar("select invoice_order_mail_send_date from tbl_invoice_order where invoice_order_id='$order_res[invoice_order_id]'");
         
      if($due_date>=$curr_date)
      {
          if($curr_date>=$before_due_date)
          {
               // SENDING MAIL DAILY TILL DUE DATE 
                if($mail_send_date=="0000-00-00")
                {
                    
// Send to billing company
$sub="We've sent your $inv_title_lower ($invoice_res[invoice_no]) for Rs.$invoice_res[invoice_grand_total]";
mail_send_function($billing_comp_res_mail['billing_company_email'],$client_res_mail['client_email'],$sub,$mailtextComp);


// Send to client
$sub="$title_invoice From $billing_comp_res_mail[billing_company_name] ($invoice_res[invoice_no])";
mail_send_function($client_res_mail['client_email'],$billing_comp_res_mail['billing_company_email'],$sub,$mailtextClient);

                    
                   // echo "date nhi hai or mail sent bhi kar diya !";
                     db_query("update tbl_invoice_order set invoice_order_mail_send_date='$curr_date' where invoice_order_id='$order_res[invoice_order_id]'  ");
                }else{
                    
                    $next_mail_send_date=date('Y-m-d', strtotime('+5 day', strtotime($mail_send_date)));
                     if($curr_date==$next_mail_send_date)
                     {
// Send to billing company
$sub="We've sent your $inv_title_lower ($invoice_res[invoice_no]) for Rs.$invoice_res[invoice_grand_total]";
mail_send_function($billing_comp_res_mail['billing_company_email'],$client_res_mail['client_email'],$sub,$mailtextComp);


// Send to client
$sub="$title_invoice From $billing_comp_res_mail[billing_company_name] ($invoice_res[invoice_no])";
mail_send_function($client_res_mail['client_email'],$billing_comp_res_mail['billing_company_email'],$sub,$mailtextClient);

                         
                        // echo "mail sent";
                          db_query("update tbl_invoice_order set invoice_order_mail_send_date='$curr_date' where invoice_order_id='$order_res[invoice_order_id]'  ");
                     }
                    
                    
                }
               
                
          }
     
      }else{
      
$next_mail_send_date=date('Y-m-d', strtotime('+7 day', strtotime($mail_send_date)));

if($curr_date==$next_mail_send_date)
{
// Send to billing company
$sub="We've sent your over due $inv_title_lower ($invoice_res[invoice_no]) for Rs.$invoice_res[invoice_grand_total]";
mail_send_function($billing_comp_res_mail['billing_company_email'],$client_res_mail['client_email'],$sub,$mailtextComp);


// Send to client
$sub="Over due $inv_title_lower From $billing_comp_res_mail[billing_company_name] ($invoice_res[invoice_no])";
mail_send_function($client_res_mail['client_email'],$billing_comp_res_mail['billing_company_email'],$sub,$mailtextClient);


//echo "current date badi hai (send weekly mail)";
db_query("update tbl_invoice_order set invoice_order_mail_send_date='$curr_date' where invoice_order_id='$order_res[invoice_order_id]'  ");
}

         


      }
      
    }
    
    
      if($order_res['invoice_order_invoice_frequency']=="Two Yearly" || $order_res['invoice_order_invoice_frequency']=="Three Yearly" || $order_res['invoice_order_invoice_frequency']=="Four Yearly" || $order_res['invoice_order_invoice_frequency']=="Five Yearly")
    {
      $due_date=$invoice_res['invoice_due_date']; 
      $before_due_date=date('Y-m-d', strtotime('-30 day', strtotime($due_date)));
      $mail_send_date=db_scalar("select invoice_order_mail_send_date from tbl_invoice_order where invoice_order_id='$order_res[invoice_order_id]'");
         
      if($due_date>=$curr_date)
      {
          if($curr_date>=$before_due_date)
          {
               // SENDING MAIL DAILY TILL DUE DATE 
                if($mail_send_date=="0000-00-00")
                {
// Send to billing company
$sub="We've sent your $inv_title_lower ($invoice_res[invoice_no]) for Rs.$invoice_res[invoice_grand_total]";
mail_send_function($billing_comp_res_mail['billing_company_email'],$client_res_mail['client_email'],$sub,$mailtextComp);


// Send to client
$sub="$title_invoice From $billing_comp_res_mail[billing_company_name] ($invoice_res[invoice_no])";
mail_send_function($client_res_mail['client_email'],$billing_comp_res_mail['billing_company_email'],$sub,$mailtextClient);

                    
                   // echo "date nhi hai or mail sent bhi kar diya !";
                    db_query("update tbl_invoice_order set invoice_order_mail_send_date='$curr_date' where invoice_order_id='$order_res[invoice_order_id]'  ");
                }else{
                    
                    $next_mail_send_date=date('Y-m-d', strtotime('+5 day', strtotime($mail_send_date)));
                     if($curr_date==$next_mail_send_date)
                     {
// Send to billing company
$sub="We've sent your $inv_title_lower ($invoice_res[invoice_no]) for Rs.$invoice_res[invoice_grand_total]";
mail_send_function($billing_comp_res_mail['billing_company_email'],$client_res_mail['client_email'],$sub,$mailtextComp);


// Send to client
$sub="$title_invoice From $billing_comp_res_mail[billing_company_name] ($invoice_res[invoice_no])";
mail_send_function($client_res_mail['client_email'],$billing_comp_res_mail['billing_company_email'],$sub,$mailtextClient);

                         
                        // echo "mail sent";
                          db_query("update tbl_invoice_order set invoice_order_mail_send_date='$curr_date' where invoice_order_id='$order_res[invoice_order_id]'  ");
                     }
                    
                    
                }
               
                
          }
     
      }else{
      
$next_mail_send_date=date('Y-m-d', strtotime('+7 day', strtotime($mail_send_date)));

if($curr_date==$next_mail_send_date)
{
    // Send to billing company
$sub="We've sent your over due $inv_title_lower ($invoice_res[invoice_no]) for Rs.$invoice_res[invoice_grand_total]";
mail_send_function($billing_comp_res_mail['billing_company_email'],$client_res_mail['client_email'],$sub,$mailtextComp);


// Send to client
$sub="Over due $inv_title_lower From $billing_comp_res_mail[billing_company_name] ($invoice_res[invoice_no])";
mail_send_function($client_res_mail['client_email'],$billing_comp_res_mail['billing_company_email'],$sub,$mailtextClient);


//echo "current date badi hai (send weekly mail)";
  db_query("update tbl_invoice_order set invoice_order_mail_send_date='$curr_date' where invoice_order_id='$order_res[invoice_order_id]'  ");
}



      }
      
    }
 
    
    
    
    
    
}

    
    
}




}





?>
