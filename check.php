<?php

ini_set('display_errors','1');

require_once('config.php');

/*GLOBALLY DECLARING VARIABLES TO RECIEVE USER INPUT AND VARIABLES TO HOLD ERRORS GENERATED BY USER INPUT UPON VALIDATION*/

$name = $email =  $phone=' ';
 $email_error =  $phone_error= ' ';

//STORING USER SUBMITTED INPUT AND SANITIZING AND VALIDATING IT

if($_SERVER["REQUEST_METHOD"] == "POST") {

  $name =  sanitizeName($_POST['fn']);
 $email =sanitizeEmail($_POST['email']);
  $phone = sanitizePhone($_POST['phone']);

$mysqli->query("INSERT INTO detailsofuserss(`email`,`name`,`phone`)VALUES('$email','$name','$phone')") or
   die($mysqli->error);
 

 header("Location:display.php");


}

//TRIMMING AND REMOVING SPECIAL CHARACTERS IN USER INPUT
function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
//SANITIZING AND VALIDATING EMAIL

function sanitizeEmail($email)
{global $email_error;
  $email= filter_var($email, FILTER_SANITIZE_EMAIL); 
if (!filter_var($email, FILTER_VALIDATE_EMAIL) === false) { 
    return $email;
} else { 
    $email_error="$email is invalid"; 
  
} 
}
//VALIDATING PHONE USING PREG_MATCH

function sanitizePhone($phone)
{ global $phone_error;
$phone=test_input($phone);
  if(preg_match('/^(\+){0,1}91(\s){0,1}[0-9]{10}$/', $phone)) {
  return $phone;
}
$phone_error= "false";
}
//SANITIZING NAME TO PREVENT SQL INJECTION ATTACKS

function sanitizeName($name)
{ $name=test_input($name);
  $name=filter_var($name,FILTER_SANITIZE_STRING);
 return $name;
}

?>