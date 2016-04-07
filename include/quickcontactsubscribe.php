<?php

require_once('phpmailer/class.phpmailer.php');

$mail = new PHPMailer();

if( $_SERVER['REQUEST_METHOD'] == 'POST' ) {
	if( $_POST['quick-contact-form-name'] != '' AND $_POST['quick-contact-form-email'] != '' AND $_POST['quick-contact-form-message'] != '' ) {

		$name = $_POST['quick-contact-form-name'];
		$email = $_POST['quick-contact-form-email'];
		$message = $_POST['quick-contact-form-message'];

		$subject = 'New Message From Quick Contact Form';

		$botcheck = $_POST['quick-contact-form-botcheck'];

		$toemail = ''; // Your Email Address
		$toname = ''; // Your Name

		$apiKey = ''; // Your MailChimp API Key
		$listId = ''; // Your MailChimp List ID
		if( isset( $_GET['list'] ) AND $_GET['list'] != '' ) {
			$listId = $_GET['list'];
		}
		$double_optin=false;
		$send_welcome=false;
		$email_type = 'html';
		$datacenter = explode( '-', $apiKey );
		$submit_url = "http://" . $datacenter[1] . ".api.mailchimp.com/1.3/?method=listSubscribe";

		if( $botcheck == '' ) {

			$mail->SetFrom( $email , $name );
			$mail->AddReplyTo( $toemail , $toname );
			$mail->AddAddress( $toemail , $toname );
			$mail->Subject = $subject;

			$name = isset($name) ? "Name: $name<br><br>" : '';
			$email = isset($email) ? "Email: $email<br><br>" : '';
			$message = isset($message) ? "Message: $message<br><br>" : '';

			$referrer = $_SERVER['HTTP_REFERER'] ? '<br><br><br>This Form was submitted from: ' . $_SERVER['HTTP_REFERER'] : '';

			$body = "$name $email $message $referrer";

			$mail->MsgHTML( $body );
			$sendEmail = $mail->Send();

			$data = array(
				'email_address'=>$email,
				'apikey'=>$apiKey,
				'id' => $listId,
				'double_optin' => $double_optin,
				'send_welcome' => $send_welcome,
				'email_type' => $email_type
			);

			$payload = json_encode($data);

			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $submit_url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_POST, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, urlencode($payload));

			$result = curl_exec($ch);
			curl_close ($ch);
			$data = json_decode($result);

			if( $sendEmail == true ):
				echo 'We have <strong>successfully</strong> received your Message and will get Back to you as soon as possible.';
			else:
				echo 'Email <strong>could not</strong> be sent due to some Unexpected Error. Please Try Again later.<br /><br /><strong>Reason:</strong><br />' . $mail->ErrorInfo . '';
			endif;
		} else {
			echo 'Bot <strong>Detected</strong>.! Clean yourself Botster.!';
		}
	} else {
		echo 'Please <strong>Fill up</strong> all the Fields and Try Again.';
	}
} else {
	echo 'An <strong>unexpected error</strong> occured. Please Try Again later.';
}

?>