
<?php
  session_start();

  $conn = new PDO('mysql:host=localhost;dbname=test', 'hoofdadmin', 'hoofdadmin123');

  $username = $_SESSION['loginid'];
  
  //dit stukje laat GEEN error messages meer zien, PAS OP.
  error_reporting(0);


  $query = $conn->prepare("SELECT * FROM userdata WHERE gebruikersnaam='$username'");



      if($query->execute() == TRUE){

        $row = $query->fetch();


        if($row != NULL){
          
          $username = $row['gebruikersnaam'];
          $usermail = $row['email'];
          
          if ($row['role'] == 1){

            $userrole = "Admin";
          }
          else{
            $userrole = "Editor";
          }

        }
        else{
          
          echo"Error: er ging iets mis, probeer het opnieuw 1";
          
        }


      }
      else{
        echo"Error: er ging iets mis, probeer het opnieuw 2";
      }




  if(!isset($_SESSION['loginid'])){
    //LET OP hij redirect nog naar de copy pagina. 
    header('Location: index copy.php');
  }




    
    
    
    



    





?>

<?php

  $conn = new PDO('mysql:host=localhost;dbname=test', 'hoofdadmin', 'hoofdadmin123');

  $username = $_SESSION['loginid'];


  $query = $conn->prepare("SELECT * FROM userdata WHERE gebruikersnaam='$username'");



      if($query->execute() == TRUE){

        $row = $query->fetch();


        if($row != NULL){
          
          $username2 = $row['gebruikersnaam'];
          $usermail2 = $row['email'];
          $userpassword2 = $row['wachtwoord'];
          

        }


      }



    $gebruikersnaam = htmlspecialchars($_POST['Gebruikersnaam']);
    $loginmail = htmlspecialchars($_POST['loginmail']);
    $loginwachtwoord = htmlspecialchars($_POST['Wachtwoord']);
    $loginwachtwoordbevestig = htmlspecialchars($_POST['Bevestigwachtwoord']);
    $loginwachtwoordhash = hash('sha256', $loginwachtwoord);


  
  if(isset($_POST["updatebutton"]) && $gebruikersnaam != NULL && $gebruikersnaam != NULL && $loginwachtwoord != NULL && $loginwachtwoordhash != NULL){




    if($gebruikersnaam == NULL){

      $username1 = $username2;



    }
    else{

      $username1 = $gebruikersnaam;
    }


    if($loginmail == NULL){

      $usermail1 = $usermail2;

      

    }
    else{

      $usermail1 = $loginmail;

    }

    if($loginwachtwoord == NULL || $loginwachtwoord != $loginwachtwoordbevestig){

      $userpassword1 = $userpassword2;

      

    }
    else{

      $userpassword1 = $loginwachtwoordhash;

    }


    $query = $conn->prepare("UPDATE userdata SET gebruikersnaam=:gebruikersnaam, email=:email, wachtwoord=:wachtwoord WHERE gebruikersnaam='$username'");

    $query->bindValue(":gebruikersnaam", $username1, PDO::PARAM_STR);
    $query->bindValue(":email", $usermail1, PDO::PARAM_STR);
    $query->bindValue(":wachtwoord", $userpassword1, PDO::PARAM_STR);
    

    if($query->execute() == TRUE){

      echo("Gegevens bijgewerkt. <br>");

      session_destroy();
      


      header('Location: index copy.php');



    }
    else{
      echo"Error: er ging iets mis, probeer het opnieuw 2 <br>";
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
    <script src="./js/ProfielPagina.js" defer></script>
    <title>blog</title>
</head>
<body>
    <div class="loader">loading....</div> <!-- Website loader -->
    <!-- Navigatie bar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
          <a class="navbar-brand" id="brandcolor" href="logged-in.php">
            <img src="./img/brand.png"width="40" height="40" class="d-inline-block align-top">  
            Placeholder</a>
            <form class="d-flex">
                <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                <button class="btn btn-outline-success" type="submit">Search</button>
              </form>
            <span></span>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
              </button>
        </div>
    </nav>

    <div class="gegevens">
      
    </div>
    

    <div class="sidenav">
      <div>
        <button class="opmaakButton" type="button" id="btn1">Verander gegevens</button>
        <br><br><br>
        <button class="opmaakButton" type="button" id="btn2">Mijn Blog posts</button>
      </div>
      <br><br><br><br>

      <div class="userinformation">
        <img src="./img/brand.png" alt="profiel foto">
        <br><br>
        <?php echo "<font color=\"#fffff\" size=\"4\"> $username </font>"; ?>
        <br><br>
        <p>Email-adress:</p>
        <?php echo "<font color=\"#fffff\" size=\"2\"> $usermail </font>"; ?>
        <br><br>
        <p>Role:</p>
        <?php echo "<font color=\"#fffff\" size=\"4\"> $userrole </font>"; ?>
      </div>

    </div>

    <br><br><br>

    <form method="post" action="" type="submit" >
    <div class="container" id="EditProfilePage" style="display:none;">
        <div class="col-xl-9 col-lg-9 col-md-12 col-sm-12 col-12">
          <div class="card h-100">
            <div class="card-body">
              <div class="row gutters">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                  <h6 class="mb-3 text-primary">Persoonlijke gegevens</h6>
                </div>
                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                  <div class="form-group">
                    <label for="fullName">Gebruikersnaam</label>
                    <input type="text" class="form-control" id="Gebruikersnaam" name="Gebruikersnaam" placeholder="Type hier uw nieuwe gebruikersnaam">
                  </div>
                </div>
                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                  <div class="form-group">
                    <label for="eMail">Email</label>
                    <input type="email" class="form-control" id="ChangeUserMail" name="loginmail" placeholder="Type hier uw nieuwe email-adress">
                  </div>
                </div>
                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                  <div class="form-group">
                    <label for="wachtwoord">Wachtwoord</label>
                    <input type="password" class="form-control" id="changePassword" name="Wachtwoord" placeholder="Type hier uw nieuwe wachtwoord">
                  </div>
                </div>
                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                  <div class="form-group">
                    <label for="wachtwoordbevestigen">Wachtwoord bevestigen</label>
                    <input type="password" class="form-control" id="changePasswordConfirm" name="Bevestigwachtwoord" placeholder="Type hier uw nieuwe wachtwoord opnieuw">
                  </div>
                </div>
                <div class="mb-3">
                  <br>
                  <label for="formFile" class="form-label">Upload hier uw profiel foto</label>
                  <input class="form-control" type="file" id="formFile">
                </div>                
                <h5>Als u uw gegevens update moet u opnieuw inloggen!</h5>
              </div>
              <div class="row gutters">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                  <div class="text-right">
                    <br>
                    <button type="button" id="CancelUpdate" name="cancel" class="btn btn-secondary">Annuleren</button>
                    <input type="submit" id="updatebutton" name="updatebutton" class="btn btn-primary" placeholdername="Updaten"></input>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      </div>
      </form>

      

</body>
</html>