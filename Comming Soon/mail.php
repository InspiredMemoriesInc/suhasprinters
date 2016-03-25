<?php

    // EDIT THE 2 LINES BELOW AS REQUIRED
    $email_to = "info@suhasprinters.com";
    $email_subject = "Member Visited";

    function died($error) {
        // your error code can go here
        echo "I  am very sorry, but there were error(s) found with the form you submitted. ";
        echo "These errors appear below.<br /><br />";
        echo $error."<br /><br />";
        echo "Please go back and fix these errors.<br /><br />";
        die();

    }
    // validation expected data exists

    if(!isset($_POST['Email']))  {
        died('I am sorry, but there appears to be a problem with the form you submitted.');
        }
    // required
    $email_from = $_POST['Email']; // required
    // not required

    $error_message = "";

    $email_exp = '/^[A-Za-z0-9._%-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}$/';
  if(!preg_match($email_exp,$email_from)) {
    $error_message .= 'The Email Address you entered does not appear to be valid.<br />';
  }

    $email_message = "Form details below.\n\n";

    function clean_string($string) {
      $bad = array("content-type","bcc:","to:","cc:","href");
      return str_replace($bad,"",$string);
    }
    
    $email_message .= "Email: ".clean_string($email_from)."\n";
  





// create email headers

$headers = 'From: '.$email_from."\r\n".
'Reply-To: '.$email_from."\r\n" .
'X-Mailer: PHP/' . phpversion();
@mail($email_to, $email_subject, $email_message, $headers);
?>

<!-- include your own success html here -->
<!DOCTYPE html>
<html>
 <head>
   <meta http-equiv='refresh' content ='5; url= index.html'>
 </head>
 <body>
<center>
  <h1>Welcome to Your World</h2>
  <p>It is my Extreme Pleasure to work for you dear</p>
  <p style="color: blue">The Movement we get back always Special</p>

  <h3> Your Mail Has been Sent Successfully. You will be Notified on your B'day</h3>
  <h4>Happy to Have You</h4>
  <h5> Goto Home Page <a href="index.html">Here</a></h5>
</center>
</body>
</html>


<?php
?>
