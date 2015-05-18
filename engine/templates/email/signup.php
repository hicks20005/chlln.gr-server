<?
$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset="UTF-8"' . "\r\n";
$headers .= 'From: The Challenger <info@chlln.gr>' . "\r\n" . 'Reply-To: info@chlln.gr' . "\r\n";

$subject = "Уведомление о регистрации";
$message = "<p>Благодарим Вас за регистрацию. Мы рады приветствовать Вас в нашем приложении The Challenger.</p>
<p>Ваши регистрационные данные:</p>
<ul>
  <li>Имя пользователя: $username</li>
</ul>
";
mail ($email, $subject, $message, $headers, "-finfo@chlln.gr");
?>