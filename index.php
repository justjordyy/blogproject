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
                <input type="text" class="form-control" id="usernamereg"placeholder="gebruikersnaam" name="gebruikersnaam">
              </div>
            <div class="form-group">
              <input type="email" class="form-control" id="emailreg"placeholder="Email adres" name="email">
            </div>
            <div class="form-group">
              <input type="password" class="form-control" id="passwordreg" placeholder="wachtwoord" name="wachtwoord">
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
$severname = "localhost"; //servername
$datab = ""; //database name
$dbusername = "root"; // db username
$dbpassword = "root"; // db password

$db = new PDO('msql:host=$severname;dbname=$datab', '$dbusername', '$dbpassword');

$username = htmlspecialchars($_POST['gebruikersnaam']);
$email = htmlspecialchars($_POST['emailadres']);
$wachtwoord = htmlspecialchars($_POST['wachtwoord']);
$query = $db->prepare("INSERT INTO gebruikers(gebruikersnaam, email, wachtwoord) VALUES (:gebruikersnaam, :email, :wachtwoord)");

$query->bindValue(":gebruikersnaam", "$username", PDO::PARAM_STR);
$query->bindValue(":email", "$email", PDO::PARAM_STR);
$query->bindValue(":wachtwoord", "$wachtwoord", PDO::PARAM_STR);

if($query->execute() == TRUE)
{
       echo "Het is goed gegaan";

}
else
{
    echo "Er gaat iets mis";
}


?>
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