<?php
session_start();
require_once("inputfilter/class.inputfilter_clean.php");
include_once('phpmailer/class.phpmailer.php');
if(isset($_POST["submit"]))
{
	$myFilter = new InputFilter();
	$result = $myFilter->process($_POST);

	if($result)
	{
		$mail = new PHPMailer(true); // the true param means it will throw exceptions on errors, which we need to catch
		//$mail->IsSendmail(); // telling the class to use SendMail transport


		
			unset($_POST["submit"]);
			
			$body = "";
			
			foreach($_POST as $key=>$value)
			{
				$body .= $key." : <strong>".$value."</strong><br/></br>";
			}
			
			$email = $_POST["Email"];
			$name = $_POST["Name"];
			
			
			try {
			  $mail->AddReplyTo($email, $name);
			  $mail->AddAddress("yorktour@sltnet.lk", "Contact - York Tour");
			  $mail->AddAddress("yorktour1@sltnet.lk", "Contact - York Tour");
			  $mail->AddBCC("charitharanasingha@gmail.com","Charitha Ranasingha");
			  $mail->AddBCC("shashika.iassolutions@gmail.com","Shashika Premabandu");
			  $mail->SetFrom($email, $name);
			  $mail->Subject = 'Enquiry Through The York Tour Web Site';
			  $mail->AltBody = 'To view the message, please use an HTML compatible email viewer!'; // optional - MsgHTML will create an alternate automatically
			  $mail->MsgHTML($body);
			  //$mail->AddAttachment('images/phpmailer.gif');      // attachment
			  //$mail->AddAttachment('images/phpmailer_mini.gif'); // attachment
			  $mail->Send();
			  
			  	header("location:contactform.php?mail=ok");
				exit();
			  
				
			  
			} catch (phpmailerException $e) {
			  echo $e->errorMessage(); //Pretty error messages from PHPMailer
			} catch (Exception $e) {
			  echo $e->getMessage(); //Boring error messages from anything else!
			}
			
			
		
		}
		else
		{
	
			
			header("location:index.php?captcha=wrong#captcha");
			exit();
		}



	
	}
	else
	{
		header("location:index.php?secure=no");
		exit();
	}


?>