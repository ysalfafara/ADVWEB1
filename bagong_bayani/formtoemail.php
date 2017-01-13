<?php
// FORM TO EMAIL
// http://www.webformdesigner.com

// ************************************************************
// NOTE: This script is set up to expect two fields within
// your form called 'name' and 'email'. (note lower case)
// Please ensure that these two fields are present or the
// script will not work
// ************************************************************


// The following variables can be changed to suit

// Change this to the email address where the message is to be sent
$your_email = "info@mgabagongbayani.net";

// This is the return URL after the form has been processed
$thankyou = "http://www.mgabagongbayani.net/thankyou.html";

// This is what is displayed in the email subject line
// Change it if you want
$subject = "Web Inquiry";

// Message to show if form is not completed properly
// Shouldn't need this if form validation in WFD is done
$empty_fields_message = "<p>Please go back and complete all the fields in the form.</p>";

// You shouldn't need to edit below this line
// ---------------------------------------------
$name = trim(stripslashes($_POST['name']));
$email = trim(stripslashes($_POST['email']));
$year = date("Y");
$month = date("m");
$day = date("d");
$hour = date("h");
$min = date("i");
$tod = date("a");

// first check that at least name & email are filled in
if (empty($name) || empty($email)) {
    echo $empty_fields_message;
    exit;
}

else {

    // This section checks the referring URL to make sure it's all coming
    // from our own site
    // Get the referring URL
    $referer = $_SERVER['HTTP_REFERER'];
    $referer_array = parse_url($referer);
    $referer = strtolower($referer_array['host']);

    // Get the URL of this page
    $this_url = strtolower($_SERVER['HTTP_HOST']);

    // If the referring URL and the URL of this page don't match then
    // display a message and don't do download or send the email.
    if ($referer != $this_url) {
        echo "ERROR: You do not have permission to use this script from another URL. \n";
        echo "Referer: " .$referer . "\n";
        echo "This URL: " .$this_url. "\n";
        exit;
    }

    // Timestamp this message
    $TimeOfMessage = date('d')."/".date('m')."/".date('y')."(".date('D').") @ ".date('H:i');

    // finally, send e-mail
    $ip=$_SERVER["REMOTE_ADDR"];
    $message = "The following was sent on " .$TimeOfMessage."\n";
    $message .= "---------------------------------------------------------\n";

    // send the complete set of variables as well
    while (@list($var,$val) = @each($_POST)) {
      $message .= "$var: $val\n";
	}

    // send the email
    mail($your_email, $subject, $message, "From: $name <$email>");

    // go to return URL
    if (isset($thankyou)) {
	header("Location: $thankyou");
	exit();
    }

}


?>