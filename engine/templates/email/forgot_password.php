<?
$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset="UTF-8"' . "\r\n";
$headers .= 'From: The Challenger <info@chlln.gr>' . "\r\n" . 'Reply-To: info@chlln.gr' . "\r\n";

$subject = "Восстановление пароля";
$message = "<p>Новый пароль: $password_restore</p>";
mail ($email, $subject, $message, $headers, "-finfo@chlln.gr");
?>