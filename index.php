<?php
session_start();



$servername = "localhost";
$username = "root";
$password = "";
$dbname = "testdatabase";


$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);

//dit stukje laat GEEN error messages meer zien, PAS OP.
error_reporting(0);


if(isset($_SESSION['loginid'])){
  header('Location: logged-in.php');
}



if(isset($_POST["loginbutton"])){

  
    if(empty($_POST['loginmail']) || empty($_POST['loginwachtwoord'])){

      $list="<center> vul uw email adress en/of wachtwoord in. <center>";
    }
    else{

      $loginmail = $_POST['loginmail'];
      $loginwachtwoord = $_POST['loginwachtwoord'];
      $loginwachtwoordhash = hash('sha256', $loginwachtwoord);

      $query = $conn->prepare("SELECT * FROM information WHERE mail=:email AND WW=:wachtwoord");

      $query->bindValue(":email", $loginmail, PDO::PARAM_STR);
      $query->bindValue(":wachtwoord", $loginwachtwoordhash, PDO::PARAM_STR);
      if($query->execute() == TRUE){

        

        
        
        $row = $query->fetch();




        if($row != NULL){
          
          $_SESSION["loginid"] = $row['id'];
          header('Location: logged-in.php');

        }
        else{
          $list="<center> Onjuiste email en/of wachtwoord, probeer het opnieuw.<center>"; 

          $list .=  "</a><br/>";
          
          
        }



        


      }
      else{
        echo"Error: er ging iets mis, probeer het opnieuw";
      }

    }

    

  

}






?>

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
            <img src="./img/logo1.png"width="40" height="40" class="d-inline-block align-top">  
            BlogBay</a>
            <form action="index.php" method="post" class="d-flex">
              <input class="form-control me-2" type="text" name="abc" placeholder="Search...">
              <button class="btn btn-outline-success" type="submit" value="Submit">Search</button>
            </form>
          <span class="navbar-text" id="login"  data-bs-toggle="modal" data-bs-target="#loginmodal">Login</span>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
              </button>
          </div>
      </nav>

      <style>
      .searchresult {
        margin: auto;
        margin-top: 1.5rem;
        border: 3px solid lightgrey;
        max-width: 100%;
        width: 40rem;
        height: 8rem;
        padding: 2rem;
        font-size: 1.5rem;
        font-weight: bold;
        border-radius: 10px;
        background-color: white;
      }

      .flex {
        display: flex;
      }
      </style>


      <?php
          $host = "localhost";
          $user = "root";
          $password = "";
          $database_name = "testdatabase";
          $pdo = new PDO("mysql:host=$host;dbname=$database_name", $user, $password, array(
          PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
          ));


      if(isset($_POST['abc'])){
        $search = $_POST['abc'];
        $query = $pdo->prepare("select * from information where gebruikersnaam LIKE '%$search%'  LIMIT 0 , 50");
        $query->bindValue(1, "%$search%", PDO::PARAM_STR);
        $query->execute();

        if($_POST['abc'] != ''){
          if (!$query->rowCount() == 0) {
            echo "<table class=''>";
            while ($results = $query->fetch()) {
              echo "<div class='flex'>";
              echo "<div class='searchresult'>";
                echo $results['gebruikersnaam'];
                echo "</div>";
                echo "</div>";
              }
              echo "</table>";
            }

            else {
              echo 'Geen resultaten gevonden';
            }
          }
          else{
            echo 'Geen resultaten gevonden';
          }
        }
      ?>  
  
      <!-- Login venster -->
      <div class="modal fade" id="loginmodal" tabindex="-1" aria-labelledby="Login" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="Login">Inloggen</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
             <form method="post" id="mdl">
            <div class="form-group">
              <input type="email" class="form-control" id="email"placeholder="email adres" name="loginmail">
            </div>
            <div class="form-group">
              <input type="password" class="form-control" id="password" placeholder="wachtwoord" name="loginwachtwoord">
            </div>
            <input id="button" type="submit" class="btn btn-info btn-block btn-round" name="loginbutton" id="loginbutton" placeholder="login"></input>
              </form>
            </div>
            <div class="errorcode">
              <?php echo($list); ?>
            </div>
            <span  id="forgotpw"  data-bs-toggle="modal" data-bs-target="#wwvergeten">wachtwoord vergeten?</span>
            <div class="modal-footer">
              <span  id="ngl"  data-bs-toggle="modal" data-bs-target="#registreermodal">Nog geen account? <a href="./registreren.php">Registreren</a></span>
            </div>
          </div>
        </div>
      </div>

      <!-- wachtwoord vergeten -->
      <div class="modal fade" id="wwvergeten" tabindex="-1" aria-labelledby="wwvergeten" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="wwvergeten">Wachtwoord vergeten?</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
             <form id="mdl" method="POST" action="send_link.php">
            <div class="form-group">
              Klik alstublieft op de 'stuur herstel code' knop om uw wachtwoord te herstellen.<br><br>
            </div>  Waneeer u niets in u mail ziet, bekijk ook de spam folder.<br> <br>
            <button type="submit" class="btn btn-info btn-block btn-round" name="reset-request-submit">Stuur herstel code</button><br><br>
            </div>
          </div>
        </div>
      </div>

      
</body>
</html>



<?php


include "blogFeed.php";

?>


