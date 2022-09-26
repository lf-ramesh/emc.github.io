<?php

$allowedExts = array("doc","pdf","docx","sql");
$temp = explode(".", $_FILES["carrer_data"]["name"]);
$extension = end($temp);
$maxsize = 2097152;

if( in_array($extension, $allowedExts) && ($_FILES["carrer_data"]["size"] < $maxsize ) )
{
        //Deal with the email
        $to = 'tsramesh5@gmail.com';
        $subject = 'a file for you';

        //$body = strip_tags($_POST['message']);

		$body = "You have new message from contact form\n=============================\n";
		$fields = array('name' => 'Firstname', 'surname' => 'Lastname', 'email' => 'Email', 'message' => 'Message','carrer_phone'=>'Phone','carrer_data'=>'Attachment'); // array variable name => Text to appear in email
		foreach ($_POST as $key => $value) {

			if (isset($fields[$key])) {
				$body .= "$fields[$key]: $value\n";
			}
		}
		$body .= "Attachment: ".$_FILES['carrer_data']['name']."\n";
		
        $attachment = chunk_split(base64_encode(file_get_contents($_FILES['carrer_data']['tmp_name'])));
        $filename = $_FILES['carrer_data']['name'];

        $boundary =md5(date('r', time())); 

        $headers = "From: tsramesh5@gmail.com\r\nReply-To: tsramesh5@gmail.com";
        $headers .= "\r\nMIME-Version: 1.0\r\nContent-Type: multipart/mixed; boundary=\"_1_$boundary\"";

        $message="This is a multi-part message in MIME format.

--_1_$boundary
Content-Type: multipart/alternative; boundary=\"_2_$boundary\"

--_2_$boundary
Content-Type: text/plain; charset=\"iso-8859-1\"
Content-Transfer-Encoding: 7bit

$body

--_2_$boundary--
--_1_$boundary
Content-Type: application/octet-stream; name=\"$filename\" 
Content-Transfer-Encoding: base64 
Content-Disposition: attachment 

$attachment
--_1_$boundary--";

$okMessage = 'Contact form successfully submitted. Thank you, I will get back to you soon!';
$errorMessage = 'There was an error while submitting the form. Please try again later';

try
{
    mail($to, $subject, $message, $headers);
    $responseArray = array('type' => 'success', 'message' => $okMessage);
}
catch (\Exception $e)
{
    $responseArray = array('type' => 'danger', 'message' => $errorMessage);
}

if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
    $encoded = json_encode($responseArray);
    
    header('Content-Type: application/json');
    
    echo $encoded;
}
else {
    echo $responseArray['message'];
}
}
else{
	$errorMessage = 'Upload file either .pdf / .doc only. Max allowed size is 2MB';
	$responseArray = array('type' => 'danger', 'message' => $errorMessage);
	
    $encoded = json_encode($responseArray);
    header('Content-Type: application/json');
    echo $encoded;
}
?>

<?php
/*
// configure
$from = '<'.$_POST['email'].'>'; 
$sendTo = 'Contact form <tsramesh5@gmail.com>';
$subject = 'New message from contact form';
$fields = array('name' => 'Firstname', 'surname' => 'Lastname', 'email' => 'Email', 'message' => 'Message','carrer_phone'=>'Phone','carrer_data'=>'Attachment'); // array variable name => Text to appear in email
$okMessage = 'Contact form successfully submitted. Thank you, I will get back to you soon!';
$errorMessage = 'There was an error while submitting the form. Please try again later';

// let's do the sending

try
{
    $emailText = "You have new message from contact form\n=============================\n";

    foreach ($_POST as $key => $value) {

        if (isset($fields[$key])) {
            $emailText .= "$fields[$key]: $value\n";
        }
    }

    mail($sendTo, $subject, $emailText, "From: " . $from);

    $responseArray = array('type' => 'success', 'message' => $okMessage);
}
catch (\Exception $e)
{
    $responseArray = array('type' => 'danger', 'message' => $errorMessage);
}

if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
    $encoded = json_encode($responseArray);
    
    header('Content-Type: application/json');
    
    echo $encoded;
}
else {
    echo $responseArray['message'];
}
*/

?>