
<?php
  session_start();

  $servername = "localhost";
  $username = "root";
  $password = "";
  $dbname = "testdatabase";

  $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);

  $userid = $_SESSION['loginid'];
  
  //dit stukje laat GEEN error messages meer zien, PAS OP.
  error_reporting(0);

  if(isset($_POST["uitloggen"])){
    session_destroy();

    header("location: index.php");
  }  


  $query = $conn->prepare("SELECT * FROM information WHERE id=:userid");
  $query->bindValue(":userid", $userid, PDO::PARAM_STR);


      if($query->execute() == TRUE){

        $row = $query->fetch();


        if($row != NULL){

          $gebruikersnaam1 = $row['gebruikersnaam'];
          
          $usermail = $row['mail'];
          
          if ($row['rol'] == 1){

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
    //update gegevens

    $gebruikersnaam = htmlspecialchars($_POST['Gebruikersnaam']);
    $email = htmlspecialchars($_POST['loginmail']);
    $loginwachtwoord = htmlspecialchars($_POST['Wachtwoord']);
    $loginwachtwoordbevestig = htmlspecialchars($_POST['Bevestigwachtwoord']);
    $loginwachtwoordhash = hash('sha256', $loginwachtwoord);




    //update gebruikersnaam
    if(isset($_POST["updateGebruikersnaamButton"])){

          
      if(empty($_POST['Gebruikersnaam'])){

        echo("vul uw nieuwe gebruikersnaam in");
      }
      else{


        $query = $conn->prepare("SELECT * FROM information where id=:userid");
        $query->bindValue(":userid", $userid, PDO::PARAM_INT);

        if($query->execute() == TRUE){
          
         
          $row = $query->fetch();

          if($gebruikersnaam == $row['gebruikersnaam']){

            echo("Gebruikersnaam bestaat al.");
          }
          else{

            $query = $conn->prepare("UPDATE information SET gebruikersnaam=:gebruikersnaam WHERE id=:userid");
            $query->bindValue(":gebruikersnaam", $gebruikersnaam, PDO::PARAM_STR);
            $query->bindValue(":userid", $userid, PDO::PARAM_STR);

            if($query->execute() == TRUE){
              

              $query = $conn->prepare("SELECT * FROM information where id=:userid");
              $query->bindValue(":userid", $userid, PDO::PARAM_INT);

              $row = $query->fetch();

              header("Location: eigenProfielPagina.php");

              echo("Gebruikersnaam aangepast");

            }
            else{
              echo"Error: er ging iets mis, probeer het opnieuw";
            }

          }




        }
      }

    }


    //update email
    if(isset($_POST["updateEmailButton"])){

          
      if(empty($_POST['updateEmail'])){

        echo("vul uw nieuwe email-adres in");
      }
      else{

        $email = $_POST['updateEmail'];

        $query = $conn->prepare("SELECT * FROM information where id=:userid");
        $query->bindValue(":userid", $userid, PDO::PARAM_INT);

        if($query->execute() == TRUE){
          
         
          $row = $query->fetch();

          if($email == $row['mail']){

            echo("Email-adres bestaat al.");
          }
          else{

            $query = $conn->prepare("UPDATE information SET mail=:email WHERE id=:userid");
            $query->bindValue(":email", $email, PDO::PARAM_STR);
            $query->bindValue(":userid", $userid, PDO::PARAM_STR);

            if($query->execute() == TRUE){
              
              

              $query = $conn->prepare("SELECT * FROM information where id=:userid");
              $query->bindValue(":userid", $userid, PDO::PARAM_INT);

              $row = $query->fetch();

              header("Location: eigenProfielPagina.php");

              echo("email aangepast");

            }
            else{
              echo"Error: er ging iets mis, probeer het opnieuw";
            }

          }




        }
      }

    }


    //update wachtwoord
    if(isset($_POST["updateWWButton"])){

          
      if(empty($_POST['Wachtwoord']) || empty($_POST['BevestigWachtwoord'])){

        echo("vul uw nieuwe wachtwoord in");
      }
      else{

        

        $query = $conn->prepare("SELECT * FROM information where id=:userid");
        $query->bindValue(":userid", $userid, PDO::PARAM_INT);

        if($query->execute() == TRUE){
          
         
          $row = $query->fetch();

          if($loginwachtwoord != $loginwachtwoordbevestig){

            echo("Wachtwoorden komen niet met elkaar overeen");
          }
          else{

            $query = $conn->prepare("UPDATE information SET WW=:loginwachtwoordhash WHERE id=:userid");
            $query->bindValue(":loginwachtwoordhash", $loginwachtwoordhash, PDO::PARAM_STR);
            $query->bindValue(":userid", $userid, PDO::PARAM_STR);

            if($query->execute() == TRUE){

              $query = $conn->prepare("SELECT * FROM information where id=:userid");
              $query->bindValue(":userid", $userid, PDO::PARAM_INT);

              $row = $query->fetch();

              header("Location: eigenProfielPagina.php");

              echo("wachtwoord aangepast");

            }
            else{
              echo"Error: er ging iets mis, probeer het opnieuw";
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
            <img src="./img/logo1.png"width="40" height="40" class="d-inline-block align-top">  
            BlogBay</a>
            <form class="d-flex" method="post" type="submit">
                <input class="form-control me-2" name="zoektermen" type="search" placeholder="Search" aria-label="Search">
                <button class="btn btn-outline-success" name="zoeken" type="submit">Search</button>
              </form>
            <span></span>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
              </button>
        </div>
    </nav>

    

    <div class="sidenav">
      <div>
        <button class="opmaakButton" type="button" id="btn1">Verander gegevens</button>
        <br><br><br>
        <button class="opmaakButton" type="button" id="btn2">Mijn Blog posts</button>
      </div>
      <br><br><br><br>

      <div class="userinformation">
        <br><br>
        <?php echo "<font color=\"#fffff\" size=\"4\"> $gebruikersnaam1</font>"; ?>
        <br><br>
        <p>Email-adress:</p>
        <?php echo "<font color=\"#fffff\" size=\"2\"> $usermail </font>"; ?>
        <br><br>
        <p>Rol:</p>
        <?php echo "<font color=\"#fffff\" size=\"4\"> $userrole </font>"; ?>
        <br><br><br><br>

        <form method="post" type="submit">
        <div class="logout-button">
          <input type="submit" id="uitloggen" name="uitloggen" class="btn btn-primary" value="Uitloggen" >
        </div>
      </form>  
      </div>
      <br>
      

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
                    <input type="text" class="form-control" id="gebruikersnaam" name="Gebruikersnaam" placeholder="Type hier uw nieuwe gebruikersnaam">
                    <input type="submit" id="updateGebruikersnaamButton" name="updateGebruikersnaamButton" class="btn btn-primary" value="Updaten"></input>
                  </div>
                </div>
                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                  <div class="form-group">
                    <label for="eMail">Email</label>
                    <input type="email" class="form-control" id="updateEmail" name="updateEmail" placeholder="Type hier uw nieuwe email-adress">
                    <input type="submit" id="updateEmailButton" name="updateEmailButton" class="btn btn-primary" value="Updaten"></input>
                  </div>
                </div>
                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                  <div class="form-group">
                    <label for="wachtwoord">Wachtwoord</label>
                    <input type="password" class="form-control" id="changePassword" name="Wachtwoord" placeholder="Type hier uw nieuwe wachtwoord">
                    <input type="submit" id="updatebutton" name="updatebutton" class="btn btn-primary" value="Updaten"></input>
                  </div>
                </div>
                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                  <div class="form-group">
                    <label for="wachtwoordbevestigen">Wachtwoord bevestigen</label>
                    <input type="password" class="form-control" id="changePasswordConfirm" name="BevestigWachtwoord" placeholder="Type hier uw nieuwe wachtwoord opnieuw">
                  </div>
                </div>
                <div class="mb-3">
                  <br>
                </div>                
              </div>
              <div class="row gutters">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                  <div class="text-right">
                    <br>
                    <button type="button" id="CancelUpdate" name="cancel" class="btn btn-secondary">Annuleren</button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      </div>
      </form>


      <div class="gegevens" id="blogpost" style=display:block>
      <?php


      //blog laten zien


      $query = $conn->prepare("SELECT * FROM blogposts WHERE userid=:userid ORDER BY datum DESC");
      $query->bindValue(":userid", $userid, PDO::PARAM_INT);


      if($query->execute() == TRUE){

        if($query->rowCount()>0){


          while($row = $query->fetch()){

            
            ?>
              <tr>
            <td>
            <div class="row">
              <div class="leftcolumn">
                <div class="card">
                  <h2><?php echo($row["blognaam"]); ?></h2>
                  <h5>Datum: <?php echo($row["datum"]); ?></h5>
                  <div class="blogimg">
                    <?php
                      if($row['foto'] == NULL){
                      
                      }else{
                        echo '<img src="upload' . $row['foto'] .'" alt="Foto" style="height:200px;" >' . "<br>"; 
                      }
                    ?>
                  </div>
                  <?php
                  $tekst = substr($row["blogtekst"], 0, 50);
                  echo $tekst . "...";
                  ?>
                  <?php
                    echo "<a href='blogpaginaView.php?blogid=" . $row["blogid"] . "'>" . "Lees verder" . "</a><br>";
                  ?>
                </div>
              </div>
            </div>
              <div class="container">
                <div class="col">
                </div>
              </div>

             
            </td>
            <td></td>
          </tr>
        <?php        
            }



        }
        else{
          echo("geen blogposts beschikbaar");
        }

      }

      

      //blog zoeken


  if(isset($_POST["zoeken"])){

    $zoekTermen = htmlspecialchars($_POST['zoekTermen']);

    $query = $conn->prepare("SELECT * FROM blogposts WHERE hastags=:zoektermen OR blognaam=:zoektermen");

    $query->bindValue(":zoektermen", $zoekTermen, PDO::PARAM_STR);


    if($query->execute() == TRUE){
  
      if($query->rowCount() != 0){
  
        ?>
          <h4>Zoekresultaat</h4>
        <?php
  
        while($row = $query->fetch()){
  
          
          ?>
            <tr>
              <td>
              <div class="row">
                <div class="leftcolumn">
                  <div class="card">
                    <h2><?php echo($row["blognaam"]); ?></h2>
                    <h5>Datum: <?php echo($row["datum"]); ?></h5>
                    <div class="blogimg">
                      <?php
                        if($row['foto'] == NULL){
                        }else{
                          echo '<img src="upload' . $row['foto'] .'" alt="Foto" style="height:200px;" >' . "<br>"; 
                        }
                      ?>
                    </div>
                    <?php
                    $tekst = substr($row["blogtekst"], 0, 100);
                    echo $tekst . "...";
                    ?>
                    <?php
                      echo "<a href='blogpaginaView.php?blogid=" . $row["blogid"] . "'>" . "Lees verder" . "</a><br>";
                      echo("Zoektermen: " . $row["hastags"]);
                    ?>
                  </div>
                </div>
              </div>
                <div class="container">
                  <div class="col">
                  </div>
                </div>
  
               
              </td>
              <td></td>
            </tr>
            <hr>
    <?php        
        }
  
  
  
    }
    else{
      echo("geen blogposts met die hastags" . "<br><br>");
    }
  
  }

  }



      ?>
    </div>





</body>
</html>