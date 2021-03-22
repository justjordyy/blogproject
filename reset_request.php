<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="mainpage.css">
    <title>Document</title>
</head>
<body>

<form method="post" target="_self">
  <div class="form-group">
    <label for="exampleInputPassword1">Password:</label>
    <input type="password" name="email" class="form-control" id="exampleInputPassword1" placeholder="Password">
  <br>
  <button type="submit" value="Reset Password" class="btn btn-primary">Submit</button>
</form>


<?php
 
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

 $result = "";
 if (isset($_GET['i']) && isset($_GET['h'])) {
   
   $stmt = $pdo->prepare("SELECT * FROM `gebruiker` WHERE `id`=?");
   $stmt->execute([$_GET['i']]);
   $request = $stmt->fetch(PDO::FETCH_ASSOC);
   if (is_array($request)) {
     if ($request['reset_hash'] != $_GET['h']) { $result = "er ging iets mis."; }
   } else { $result = "het ging fout, helaas."; }
  
   if ($result=="") {
     $now = strtotime("now");
     $expire = strtotime($request['reset_time']) + $prvalid;
     if ($now >= $expire) { $result = "het duurde te lang."; }
   }
  
   if ($result=="") {
     $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()-=+?";
     $password = substr(str_shuffle($chars),0 ,8); // 8 characters
  
     $stmt = $pdo->prepare("UPDATE `gebruiker` SET `wachtwoord`=? WHERE `id`=?");
     $stmt->execute([$password, $_GET['i']]);
     $stmt = $pdo->prepare("DELETE FROM `gebruiker` WHERE `id`=?");
     $stmt->execute([$_GET['i']]);
  
     $result = "Uw wacht woord is verranderd naar $password. log nogmaals een keer in om het te bevestigen.";
   }
 }
  
 else { $result = "het ging fout, sorry."; }
  
 echo "<div>$result</div>";

?>

</body>
</html>