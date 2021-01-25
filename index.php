<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>
    <link rel="stylesheet" type="text/css" href="./css/mainpage.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="./js/websiteloader.js"></script>
    <title>blog</title>
</head>
<body>
    <div class="loader">loading....</div> <!-- Website loader -->
    <!-- Navigatie bar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
          <a class="navbar-brand" id="brandcolor" href="#">
            <img src="./img/brand.png"width="40" height="40" class="d-inline-block align-top">  
            Placeholder</a>
            <form class="d-flex">
                <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                <button class="btn btn-outline-success" type="submit">Search</button>
              </form>
            <span class="navbar-text" id="login"  data-bs-toggle="modal" data-bs-target="#loginmodal">Login</span>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
              </button>
          </div>
      </nav>

      <!-- Login venster -->
      <div class="modal fade" id="loginmodal" tabindex="-1" aria-labelledby="Login" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="Login">Inloggen</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
             <form id="mdl">
            <div class="form-group">
              <input type="email" class="form-control" id="email"placeholder="email adres">
            </div>
            <div class="form-group">
              <input type="password" class="form-control" id="password" placeholder="wachtwoord">
            </div>
            <button type="button" class="btn btn-info btn-block btn-round">Login</button>
          </form>
            </div>
            <span  id="forgotpw"  data-bs-toggle="modal" data-bs-target="#wwvergeten">wachtwoord vergeten?</span>
            <div class="modal-footer">
              <span  id="ngl"  data-bs-toggle="modal" data-bs-target="#registreermodal">Nog geen account? Registreer</span>
            </div>
          </div>
        </div>
      </div>

      <!-- Registreer -->
      <div class="modal fade" id="registreermodal" tabindex="-1" aria-labelledby="registreer" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="registreer">Registreren</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
             <form id="mdl"  method="post">
              <div class="form-group">
                <input type="text" class="form-control" id="usernamereg"placeholder="gebruikersnaam" required name="gebruikersnaam">
              </div>
            <div class="form-group">
              <input type="email" class="form-control" id="emailreg"placeholder="Email adres" required name="email">
            </div>
            <div class="form-group">
              <input type="password" class="form-control" id="passwordreg" placeholder="wachtwoord" required name="wachtwoord">
            </div>
            <div class="form-group">
              <input type="password" class="form-control" id="passwordreg" placeholder="Voer uw wachtwoord nogmaals in" required name="wachtwoord2">
            </div>
            <input type="checkbox" id="regconfirm">
            <label for="regconfirm">Ik ga akkoord met de voorwaarden</label><br><br>
            <button type="submit" class="btn btn-info btn-block btn-round">Registreer</button>
          </form>
            </div>
          </div>
        </div>
      </div>
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
  echo "Kon geen verbinding maken.";
}
if($_SERVER["REQUEST_METHOD"] == "POST"){
  //verklaar alle vars
$username = htmlspecialchars($_POST['gebruikersnaam']);
$email = htmlspecialchars($_POST['email']);
$wachtwoord = htmlspecialchars($_POST['wachtwoord']);
$wachtwoord2 = htmlspecialchars($_POST['wachtwoord2']);
$wachtwoordhash = password_hash($wachtwoord, PASSWORD_DEFAULT);
//prepare 
$query = $conn->prepare("INSERT INTO information(gebruikersnaam, mail, WW) VALUES (:gebruikersnaam, :mail, :WW)");
//Check dubbele mail
$sql = "SELECT * FROM information WHERE mail = ?";
$stmt = $conn->prepare($sql);
$stmt->execute(array($email));
$result = $stmt->fetch(PDO::FETCH_ASSOC);
if($result){
  echo "Dubbele email";
}
else{
  // check dubbele gebruikersnaam
  $sql = "SELECT * FROM information WHERE gebruikersnaam = ?";
$stmt = $conn->prepare($sql);
$stmt->execute(array($username));
$result = $stmt->fetch(PDO::FETCH_ASSOC);
if($result){
  echo "Dubbele gebruikersnaam";
}
else{ 
  //wachtwoordcheck
  if($wachtwoord !== $wachtwoord2){
  echo "voer hetzelfde wachtwoord in";
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
}
}
}
}
?>

      <!-- wachtwoord vergeten -->
      <div class="modal fade" id="wwvergeten" tabindex="-1" aria-labelledby="wwvergeten" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="wwvergeten">Wachtwoord vergeten?</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
             <form id="mdl">
            <div class="form-group">
              Voer u email in en we sturen u een mail met een code om u wachtwoord te resetten.<br><br>
              <input type="email" class="form-control" id="email"placeholder="email">
            </div>  Waneeer u niets in u mail ziet, bekijk ook de spam folder.<br> <br>
            <button type="button" class="btn btn-info btn-block btn-round">Stuur herstel code</button><br><br>
            </div>
          </div>
        </div>
      </div>

      
</body>
</html>