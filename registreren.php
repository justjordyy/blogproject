<?php 
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "testdatabase";
//connection
try {
  $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
//Error
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
  echo $e->getMessage();
  echo "<script type='text/javascript'>document.getElementById('dberr').style.display='block';</script>";
}
if($_SERVER["REQUEST_METHOD"] == "POST"){
  //verklaar alle vars
$username = htmlspecialchars($_POST['gebruikersnaam']);
$email = htmlspecialchars($_POST['email']);
$wachtwoord = htmlspecialchars($_POST['wachtwoord']);
$wachtwoord2 = htmlspecialchars($_POST['wachtwoord2']);
$wachtwoordhash = hash('sha256', $wachtwoord);
//prepare 
$query = $conn->prepare("INSERT INTO information(gebruikersnaam, mail, WW) VALUES (:gebruikersnaam, :mail, :WW)");
//Check dubbele mail
$sql = "SELECT * FROM information WHERE mail = ?";
$stmt = $conn->prepare($sql);
$stmt->execute(array($email));
$result = $stmt->fetch(PDO::FETCH_ASSOC);
if($result){
  echo "<script type='text/javascript'>document.getElementById('mailerr').style.display='block';</script>";
}
else{
  // check dubbele gebruikersnaam
  $sql = "SELECT * FROM information WHERE gebruikersnaam = ?";
$stmt = $conn->prepare($sql);
$stmt->execute(array($username));
$result = $stmt->fetch(PDO::FETCH_ASSOC);
if($result){
  // echo "<script src=./js/errors.js></script>";
  echo "<script type='text/javascript'>document.getElementById('gebrerr').style.display='block';</script>";
}
else{ 
  //wachtwoordcheck
  if($wachtwoord !== $wachtwoord2){
  echo "<script type='text/javascript'>document.getElementById('wwerr').style.display='block';</script>";
}
else{

$query->bindValue(":gebruikersnaam", $username, PDO::PARAM_STR);
$query->bindValue(":mail", $email, PDO::PARAM_STR);
$query->bindValue(":WW", $wachtwoordhash, PDO::PARAM_STR);

if(!$query->execute() == TRUE)
{
  $message = "something went wrong";
  echo "<script type='text/javascript'>alert('$message');</script>";
}
else {
  header('Location: index.php');
}

}
}
}
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.0.2/jquery.min.js"> </script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="./js/websiteloader.js"></script>
    <link rel="stylesheet" type="text/css" href="./css/loginback.css">
    <title>blog</title>    
</head>
<body>


<div class="loader">loading....</div> <!-- Website loader -->
<div class="toppit">
</div>
<div class="container">
<div class="regform">
<form id="frm" method="post">
<input type="text" class="reg" id="usernamereg"placeholder="gebruikersnaam" required name="gebruikersnaam">
<input type="email" class="reg" id="emailreg"placeholder="Email adres" required name="email">
<input type="password" class="reg" id="passwordreg" placeholder="wachtwoord" required name="wachtwoord">
<input type="password" class="reg" id="passwordreg" placeholder="Voer uw wachtwoord nogmaals in" required name="wachtwoord2"><br><br>
<input type="checkbox" required id="regconfirm">
            <label for="regconfirm">Ik ga akkoord met de voorwaarden</label><br><br>
              <p id="gebrerr">gebruikersnaam is al in gebruik</p>
              <p id="mailerr">er is al een account met deze mail</p>
              <p id="wwerr">wachtwoorden komen niet overeen</p>
              <p id="dberr">Kon geen verbinding maken met de database</p>
            <button type="submit" class="btn btn-info btn-block btn-round" >Registreer</button>
</form>
</div>
</div>
<div class="topdown"></div>




<script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r121/three.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/vanta@latest/dist/vanta.net.min.js"></script>
<script>
VANTA.NET({
  el: "html",
  mouseControls: true,
  touchControls: true,
  gyroControls: false,
  minHeight: 200.00,
  minWidth: 200.00,
  scale: 1.00,
  scaleMobile: 1.00,
})
</script>
</body>
</html>