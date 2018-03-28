<?php
 
if(isset($_POST['email'])) {
 
     
 
    // EDIT THE 2 LINES BELOW AS REQUIRED
 
    $email_to = "debslarocque@gmail.com"; // Change to shooters
 
 
     
 
     
 
    function died($error) {
 
        // your error code can go here
 
        echo "We are very sorry, but there were error(s) found with the form you submitted. ";
 
        echo "These errors appear below.<br /><br />";
 
        echo $error."<br /><br />";
 
        echo "Please go back and fix these errors.<br /><br />";
 
        die();
 
    }
 
     
 
    // validation expected data exists
 
    if(!isset($_POST['name']) || !isset($_POST['email']) || !isset($_POST['message']))
    {
        died('We are sorry, but there appears to be a problem with the form you submitted.');       
 
    }
 
     
    $hnpt = filter_input(INPUT_POST,"hnpt", FILTER_SANITIZE_STRING); // required 
    
    $name = filter_input(INPUT_POST,"name", FILTER_SANITIZE_STRING); // required
    
    $email_subject = filter_input(INPUT_POST,"subject", FILTER_SANITIZE_STRING); // required
 
    $email_from = filter_input(INPUT_POST,"email", FILTER_SANITIZE_EMAIL); // required
    
    $noreply_from = "no-reply@shootersbarltd.com";
 
    $message = $_POST['message']; // required
 
     
 
    $error_message = "";
 
    $email_exp = '/^[A-Za-z0-9._%-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}$/';
 
  if($email_from== false || $email_from == "") {
 
    $error_message .= 'The Email Address you entered does not appear to be valid.<br />';
 
  }
 
    $string_exp = "/^[A-Za-z .'-]+$/";
 
  if(!preg_match($string_exp,$name) || strlen($name) < 3) {
 
    $error_message .= 'The Name you entered does not appear to be valid.<br />';
 
  }

 
  if(strlen($message) < 2) {
 
    $error_message .= 'The message you entered does not appear to be valid (too short).<br />';
 
  }
  
   if($hnpt || strlen($hnpt) > 0 ) {
 
    $error_message .= 'BOT detected.<br />';
 
  }
 
  if(strlen($error_message) > 0) {
 
    died($error_message);
 
  }
 
    $email_message = "Form details below.\n\n";
 
     
 
    function clean_string($string) {
 
      $bad = array("content-type","bcc:","to:","cc:","href");
 
      return str_replace($bad,"",$string);
 
    }
 
     
 
    $email_message .= "Name: ".clean_string($name)."\n";
 
    $email_message .= "Email: ".clean_string($email_from)."\n";
 
    $email_message .= "Comments: ".clean_string($message)."\n";
 
     
 
     
 
// create email headers
 
$headers = 'From: '.$noreply_from."\r\n".
 
'Reply-To: '.$noreply_from."\r\n" .
 
'X-Mailer: PHP/' . phpversion();
 
@mail($email_to, $email_subject, $email_message, $headers);  
 
?>
 
 
 
<!-- include your own success html here -->
 

 
Thank you for contacting us. We will be in touch with you very soon.

<a title="Back to website" href='/'>Click here to go back to the website.</a>
 
 
 
<?php
 
}
 
?>