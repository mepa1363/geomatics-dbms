<?php
if (isset($_POST['submit'])) {

    $email_to = $_POST['email'];

    $email_subject = "SIN expiry date notice";

    $name = 'ali'; //$_POST['name'];
    $expiry_date = '12'; //$_POST['sin_expiry_date'];
    $email_from = 'geomatic@ucalgary.ca';

    $email_message = "Dear " . $name . "\n\n";
    $email_message .= "Your SIN expiry date is approaching very soon. Please try to renew that before " . $expiry_date . "\n\n";
    $email_message .= "This message is from Department of Geomatics Engineering.\n\n";
    $email_message .= "Ms. Marcia Rempel\n";
    $email_message .= "Administrative Manager\n";
    $email_message .= "Geomatics Engineering\n";
    $email_message .= "Schulich School of Engineering\n";
    $email_message .= "University of Calgary\n";
    $email_message .= "2500 University Drive NW\n";
    $email_message .= "Calgary, Alberta  T2N 1N4\n";
    $email_message .= "Telephone:  (403) 220-4982\n";


// create email headers
    $headers = 'From: ' . $email_from . "\r\n" .
        'Reply-To: ' . $email_from . "\r\n" .
        'X-Mailer: PHP/' . phpversion();
    @mail($email_to, $email_subject, $email_message, $headers);

    $server_name = "http://" . $_SERVER['SERVER_NAME'];
    $current_dir = dirname($_SERVER['REQUEST_URI']) . "/";
    $url = $server_name . $current_dir . "sin_expiry_report.php";
    $header = "Location: " . $url;
    header($header);

}


