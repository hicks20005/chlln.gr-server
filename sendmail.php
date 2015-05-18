<?php
// Email Submit
// Note: filter_var() requires PHP >= 5.2.0

<<<<<<< HEAD
=======
/*
$filename = 'test.txt';
$somecontent = "asd";
$handle = fopen($filename, 'a');
fwrite($handle, $somecontent);
fclose($handle);
*/

>>>>>>> 6efe23e6e14fb0778c95d52173f3548a10bf3a80
if ( isset($_POST['email']) && isset($_POST['name']) && isset($_POST['subject']) && isset($_POST['message']) && filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) ) {
 
  // detect & prevent header injections
  $test = "/(content-type|bcc:|cc:|to:)/i";
  foreach ( $_POST as $key => $val ) {
    if ( preg_match( $test, $val ) ) {
      exit;
    }
  }
  
  //
  mail( "info@chlln.gr", $_POST['subject'], $_POST['message'], "From:" . $_POST['email'] );
  //mail( "hicks2005@mail.ru", $_POST['subject'], $_POST['message'], "From:" . $_POST['email'] );
 
}
?>