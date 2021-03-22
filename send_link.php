<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="mainpage.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>
    <title>Document</title>
</head>
<body>

<form method="post" target="_self">
  <div class="form-group">
    <label for="exampleInputEmail1">Email address:</label>
    <input type="email" name="emailadres" id="emailinput" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email">
  </div>
<br>
  <button type="submit" value="Reset Password" class="btn btn-primary">Submit</button>
</form>

<?php

use PHPMailer\PHPMailer\PHPMailer;
  require 'PHPMailer-master/src/PHPMailer.php';
  require 'PHPMailer-master/src/SMTP.php';
  require 'PHPMailer-master/src/Exception.php';

$dbhost = "localhost";
$dbname = "testdatabase";
$dbchar = "utf8";
$dbuser = "root";
$dbpass = "";
 
$prvalid = 300;
 
try {
  $pdo = new PDO(
    "mysql:host=$dbhost;dbname=$dbname;charset=$dbchar",
    $dbuser, $dbpass, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
  );
} catch (Exception $ex) {
  die($ex->getMessage());
}
 
if (isset($_POST['emailadres'])) {
 
  $stmt = $pdo->prepare("SELECT * FROM `gebruiker` WHERE `emailadres`=?");
  $stmt->execute([$_POST['emailadres']]);
  $user = $stmt->fetch(PDO::FETCH_ASSOC);
  $result = is_array($user)
          ? "" 
          : $_POST['emailadres'] . " bestaat niet." ;
 
  if ($result == "") {
    $stmt = $pdo->prepare("SELECT * FROM `gebruiker` WHERE `id`=?");
    $stmt->execute([$user['id']]);
    $request = $stmt->fetch(PDO::FETCH_ASSOC);
    $now = strtotime("now");
    if (is_array($request)) {
      $expire = strtotime($request['reset_time']) + $prvalid;
      if ($now < $expire) { $result = "Probeer het later opnieuw."; }
    }
  }
 
  if ($result == "") {
    $hash = md5($user['emailadres'] . $now);
 
    $stmt = $pdo->prepare("REPLACE INTO `password_reset` VALUES (?,?,?)");
    $stmt->execute([$user['id'], $hash, date("Y-m-d H:i:s")]);
 
    $subject = "Password reset";
    $link = "http://localhost/reset_request.php".$user['id']."&h=".$hash;
    $message = "<a href='$link'>Klik hier om uw wachtwoord te herstellen.</a>";
    if (mail($user['emailadres'], $subject, $message)) {
      $result = "E-mail kon niet verzonden worden.";
    }
  }

  ini_set("SMTP", "ssl:smtp.gmail.com");
  ini_set("sendmail_from", "hoedt574@gmail.com");
 
  if ($result=="") { $result = "E-mail is verstuurt - Klikt alstublieft op de link om het te bevestigen."; }
  echo "<div>$result</div>";
}


?>

</body>
</html>
