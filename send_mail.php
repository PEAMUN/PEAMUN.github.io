<?php
/*
This first bit sets the email address that you want the form to be submitted to.
You will need to change this value to a valid email address that you can access.
*/
$webmaster_email = "hershkbhargava@gmail.com";
//$webmaster_email = "hirsh.agarwal@gmail.com";
/*
This bit sets the URLs of the supporting pages.
If you change the names of any of the pages, you will need to change the values here.
*/
$feedback_page = "index.html";
$error_page = "index.html";
$thankyou_page = "index.html";

/*
This next bit loads the form field data into variables.
If you add a form field, you will need to add it here.
*/
$school_name = $_POST['schoolName'];
$advisor_name = $_POST['advisorName'];
$advisor_email = $_POST['advisorEmail'];
$phone_number = $_POST['phoneNumber'];
$head_delegate_name = $_POST['headDelegate'];
$head_delegate_email = $_POST['headDelegateEmail'];
$number_of_delegates = $_POST['delegates'];

//$body = "Message: ".$comments. "\nPhone: " . $phone . "\nEmail: " . $email_address . "\nBest Time: " . $bestTime;
$body = "Alert: Form submission on PEAMUN registration page! \n" . "School Name: " . $school_name . "\nAdvisor Name: " . $advisor_name . "\nAdvisor Email: ". $advisor_email . "\nPhone Number: " . $phone_number . "\nHead Delegate: " . $head_delegate_name . "\nHead Delegate Email: " . $head_delegate_email . "\nApproximate Number of Delegates: " . $number_of_delegates; 
echo $body;
/*
The following function checks for email injection.
Specifically, it checks for carriage returns - typically used by spammers to inject a CC list.
*/


function isInjected($str) {
	$injections = array('(\n+)',
	'(\r+)',
	'(\t+)',
	'(%0A+)',
	'(%0D+)',
	'(%08+)',
	'(%09+)'
	);
	$inject = join('|', $injections);
	$inject = "/$inject/i";
	if(preg_match($inject,$str)) {
		return true;
	}
	else {
		return false;
	}
}

// If the user tries to access this script directly, redirect them to the feedback form,
if (!isset($_POST['advisorEmail'])) {
//header( "Location: $feedback_page" );
	echo "Email Address Not Posted";
}

// If the form fields are empty, redirect to the error page.
elseif (empty($phone_number) || empty($body) || empty($school_name) || empty($school_name)) {
//header( "Location: $error_page" );
	echo "Fields are empty";
}
// If email injection is detected, redirect to the error page.
elseif ( isInjected($advisor_email) ) {
//header( "Location: $error_page" );
	echo "Page has been injected";
}

// If we passed all previous tests, send the email then redirect to the thank you page.
else {

mail("peamun@gmail.com", "PEAMUN Registration", $body, "From: " . $school_name);
mail("hershkbhargava@gmail.com", "PEAMUN Registration", $body, "From: " . $school_name);

mail($advisor_email, "PEAMUN", "Congratulations on registering for PEAMUN VI! We will contact you promptly. \n --the PEAMUN Team", "From: peamun@gmail.com");
mail($head_delegate_email, "PEAMUN", "Congratulations on registering for PEAMUN VI! We will contact you promptly. \n --the PEAMUN Team", "From: peamun@gmail.com");
echo "Everything has just been sent";
//header( "Location: $thankyou_page" );

}
?>
