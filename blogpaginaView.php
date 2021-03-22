<?php

  $servername = "localhost";
  $username = "root";
  $password = "";
  $dbname = "testdatabase";


  $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);

  //verwijder blog
  if(isset($_GET["deleteid"])){

    $blogid = $_GET["blogid"];

    $query = $conn->prepare("DELETE FROM blogposts WHERE blogid=:blogid");
    $query->bindValue(":blogid", $blogid, PDO::PARAM_INT);
    
    if($query->execute() == TRUE){

      header("location: logged-in.php");
    }

  }

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="./css/mainpage.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>
    <link rel="stylesheet" type="text/css" href="./css/mainpage.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="./js/websiteloader.js"></script>
    <title>BlogBay</title>
</head>


<?php
    session_start();

    //dit stukje laat GEEN error messages meer zien, PAS OP.
    error_reporting(0);

    $loginid = $_SESSION['loginid'];


  if(!isset($_SESSION['loginid'])){
    $gebruikersnaam = "";
    $loginid = "";
  }


  $query = $conn->prepare("SELECT * FROM information WHERE id=:loginid");

  $query->bindValue(":loginid", $loginid, PDO::PARAM_INT);




      if($query->execute() == TRUE){

        $row = $query->fetch();


        if($row != NULL){

          $gebruikersnaam = $row['gebruikersnaam'];

          $rol = $row['rol'];

          if($rol == NULL){
            $rol = "";
          }
        }



      }

?>

<div class="loader">loading....</div> <!-- Website loader -->
    <!-- Navigatie bar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
      <div class="container-fluid">
        <a class="navbar-brand" id="brandcolor" href="logged-in.php">
          <img src="./img/logo1.png"width="40" height="40" class="d-inline-block align-top">
          BlogBay</a>

          <span></span>

        </div>

        <?php echo "<a style='padding-right:10px' href=\"eigenProfielPagina.php\"><font color=\"#fffff\" size=\"5\"> $gebruikersnaam </font></a>"; ?>
      </nav>
</div>






<?php

    //blog laten zien
    $blogid = $_GET["blogid"];

    $query = $conn->prepare("SELECT * FROM blogposts where blogid=:blogid");

    $query->bindValue(":blogid", $blogid, PDO::PARAM_INT);


    if($query->execute() == TRUE){

        $blog = $query->fetch();

        if($rol == 1){

          //admin van de website


          $query = $conn->prepare("SELECT * FROM blogposts WHERE blogid=:blogid");
          $query->bindValue(":blogid", $blogid, PDO::PARAM_INT);

          if($query->execute() == TRUE){
            
            $row = $query->fetch();


          }

          ?>

            <div class="blogpost">

              <?php  
              
                echo "<h3 style='text-align:center; font-size:70px'>" . $blog['blognaam'] . "</h3><br>"; 

                if($row['foto'] == NULL){

                }else{
                  echo '<img src="upload' . $row['foto'] .'" alt="Foto" style="max-height:500px; text-align:center; display:block; margin:auto;" >' . "<br>";
                }

                

              ?>

              <div class="blogtekst">
                <?php
                  $userid = $blog["userid"];

                  echo "<p style='float:center; text-align:center;'>" . $blog['blogtekst'] . "<br><br></p>";

                  echo "<p style='text-align:center;'>" . "Zoektermen: " . $blog['hastags'] . "<br><br></p>";
        
                  echo "<p style='text-align:center;'>" . "Datum: " . $blog['datum'] . "<br><br></p>";


                  $query = $conn->prepare("SELECT * FROM information WHERE id=:userid");
                  $query->bindValue(":userid", $userid, PDO::PARAM_INT);

                  if($query->execute() == TRUE){
                    
                    $row = $query->fetch();

                    echo "<p style='text-align:center;'>"  . "Auteur: " . $row["gebruikersnaam"] . "</p><br>";
                  }  



                ?>
                <!--bewerk blogpost-->
                <div class="modal fade" id="modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                    <div class="modal-dialog">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="staticBackdropLabel">Maak een blogpost</h5>
                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form method="post" Type="submit">
                        <div class="modal-body">
                        <div class="mb-3">
                    <label for="exampleFormControlTextarea1" class="form-label">Titel</label>
                    <textarea class="form-control" id="exampleFormControlTextarea1" maxlength="40" name="updateNaam" rows="1"></textarea>
                    <input type="submit" name="updateNaamButton" value="Bewerken" class="btn btn-primary"></input>
                    <br><br>
                    <label for="exampleFormControlTextarea1" class="form-label">Blog Tekst</label>
                    <textarea class="form-control" id="exampleFormControlTextarea1" maxlength="1000" name="updateTekst" rows="8"></textarea>
                    <input type="submit" name="updateTekstButton" value="Bewerken" class="btn btn-primary"></input>
                    <br><br>
                    <td><a href="blogpaginaView.php?blogid=<?php echo $blogid; ?>&deleteid=<?php echo $blog['blogid'];?>">Verwijderen</a></td>
                  </div>
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Sluiten</button>
                        </div>
                      </div>
                    </div>
                  </div>
                </form>

                <div class="post-container">
                    <button class="post-btn btn-outline-success" type="submit" data-bs-toggle="modal" data-bs-target="#modal" >Blog post bewerken</button>
                  </div>
                  <div class="check">
                </div>
              


            </div>


          <?php
          //verander blognaam
          if(isset($_POST["updateNaamButton"])){

                      
            if(empty($_POST['updateNaam'])){

              echo("vul uw nieuwe blognaam in");
            }
            else{

              $blognaam = $_POST['updateNaam'];



              $query = $conn->prepare("UPDATE blogposts SET blognaam=:blognaam WHERE blogid=:blogid");
              $query->bindValue(":blognaam", $blognaam, PDO::PARAM_STR);
              $query->bindValue(":blogid", $blogid, PDO::PARAM_STR);

              if($query->execute() == TRUE){
                
                echo("Blog aangepast");

                $query = $conn->prepare("SELECT * FROM blogposts where blogid=:blogid");
                $query->bindValue(":blogid", $blogid, PDO::PARAM_INT);

                $row = $query->fetch();

                header("Refresh:0");

              }
              else{
                echo"Error: er ging iets mis, probeer het opnieuw";
              }

            }


          
          //verander blogtekst
          if(isset($_POST["updateTekstButton"])){

            
            if(empty($_POST['updateTekst'])){

              echo("vul uw nieuwe blogtekst in");
            }
            else{


              $blogtekst = $_POST['updateTekst'];


              $query = $conn->prepare("SELECT * FROM blogposts WHERE blogid=:blogid");
              $query->bindValue(":blogid", $blogid, PDO::PARAM_STR);


              if($query->execute() == TRUE){      
                
                $row = $query->fetch();


              }



              $query = $conn->prepare("UPDATE blogposts SET blogtekst=:blogtekst WHERE blogid=:blogid");
              $query->bindValue(":blogtekst", $blogtekst, PDO::PARAM_STR);
              $query->bindValue(":blogid", $blogid, PDO::PARAM_STR);

              if($query->execute() == TRUE){
                
               echo("Blog aangepast");

               $query = $conn->prepare("SELECT * FROM blogposts where blogid=:blogid");
               $query->bindValue(":blogid", $blogid, PDO::PARAM_INT);

               header("Refresh:0");

              }
              else{
                echo"Error: er ging iets mis, probeer het opnieuw";
              }

            }

  
            


          }
          

      }



        }else if($query->rowCount() == 1 && $loginid == $blog['userid']){

          //eigeneaar blog

          $query = $conn->prepare("SELECT * FROM blogposts WHERE blogid=:blogid");
          $query->bindValue(":blogid", $blogid, PDO::PARAM_INT);

          if($query->execute() == TRUE){
            
            $row = $query->fetch();


          }

          ?>

            <div class="blogpost">

              <?php  
              
                echo "<h3 style='text-align:center; font-size:70px'>" . $blog['blognaam'] . "</h3><br>"; 

                if($row['foto'] == NULL){

                }else{
                  echo '<img src="upload' . $row['foto'] .'" alt="Foto" style="max-height:500px; text-align:center; display:block; margin:auto;" >' . "<br>";
                }

                

              ?>

              <div class="blogtekst">
                <?php
                  $userid = $blog["userid"];

                  echo "<p style='float:center; text-align:center;'>" . $blog['blogtekst'] . "<br><br></p>";

                  echo "<p style='text-align:center;'>" . "Zoektermen: " . $blog['hastags'] . "<br><br></p>";
        
                  echo "<p style='text-align:center;'>" . "Datum: " . $blog['datum'] . "<br><br></p>";


                  $query = $conn->prepare("SELECT * FROM information WHERE id=:userid");
                  $query->bindValue(":userid", $userid, PDO::PARAM_INT);

                  if($query->execute() == TRUE){
                    
                    $row = $query->fetch();

                    echo "<p style='text-align:center;'>"  . "Auteur: " . $row["gebruikersnaam"] . "</p><br>";
                  }  



                ?>
                <!--bewerk blogpost-->
                <div class="modal fade" id="modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                    <div class="modal-dialog">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="staticBackdropLabel">Bewerk blogpost</h5>
                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form method="post" Type="submit">
                        <div class="modal-body">
                        <div class="mb-3">
                    <label for="exampleFormControlTextarea1" class="form-label">Titel</label>
                    <textarea class="form-control" id="exampleFormControlTextarea1" maxlength="40" name="updateNaam" rows="1"></textarea>
                    <input type="submit" name="updateNaamButton" value="Bewerken" class="btn btn-primary"></input>
                    <br><br>
                    <label for="exampleFormControlTextarea1" class="form-label">Blog Tekst</label>
                    <textarea class="form-control" id="exampleFormControlTextarea1" maxlength="1000" name="updateTekst" rows="8"></textarea>
                    <input type="submit" name="updateTekstButton" value="Bewerken" class="btn btn-primary"></input>
                    <br><br>

                    <td><a href="blogpaginaView.php?blogid=<?php echo $blogid; ?>&deleteid=<?php echo $blog['blogid'];?>">Verwijderen</a></td>
                  </div>
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Sluiten</button>
                        </div>
                      </div>
                    </div>
                  </div>
                </form>

              


                <div class="post-container">
                    <button class="post-btn btn-outline-success" type="submit" data-bs-toggle="modal" data-bs-target="#modal" >Blog post bewerken</button>
                  </div>
                  <div class="check">
                </div>
              


            </div>


          <?php
          //verander blognaam
          if(isset($_POST["updateNaamButton"])){

                      
            if(empty($_POST['updateNaam'])){

              echo("vul uw nieuwe blognaam in");
            }
            else{

              $blognaam = $_POST['updateNaam'];



              $query = $conn->prepare("UPDATE blogposts SET blognaam=:blognaam WHERE blogid=:blogid");
              $query->bindValue(":blognaam", $blognaam, PDO::PARAM_STR);
              $query->bindValue(":blogid", $blogid, PDO::PARAM_STR);

              if($query->execute() == TRUE){
                
                echo("Blog aangepast");

                $query = $conn->prepare("SELECT * FROM blogposts where blogid=:blogid");
                $query->bindValue(":blogid", $blogid, PDO::PARAM_INT);

                $row = $query->fetch();

                

              }
              else{
                echo"Error: er ging iets mis, probeer het opnieuw";
              }

            }





}


          
          //verander blogtekst
          if(isset($_POST["updateTekstButton"])){

            
            if(empty($_POST['updateTekst'])){

              echo("vul uw nieuwe blogtekst in");
            }
            else{


              $blogtekst = $_POST['updateTekst'];


              $query = $conn->prepare("SELECT * FROM blogposts WHERE blogid=:blogid");
              $query->bindValue(":blogid", $blogid, PDO::PARAM_STR);


              if($query->execute() == TRUE){      
                
                $row = $query->fetch();


              }



              $query = $conn->prepare("UPDATE blogposts SET blogtekst=:blogtekst WHERE blogid=:blogid");
              $query->bindValue(":blogtekst", $blogtekst, PDO::PARAM_STR);
              $query->bindValue(":blogid", $blogid, PDO::PARAM_STR);

              if($query->execute() == TRUE){
                
               echo("Blog aangepast");

               $query = $conn->prepare("SELECT * FROM blogposts where blogid=:blogid");
               $query->bindValue(":blogid", $blogid, PDO::PARAM_INT);

               $row = $query->fetch();

               

              }
              else{
                echo"Error: er ging iets mis, probeer het opnieuw";
              }

            }

  
            


          }
          

      }
      else{
          //gewone gebruiker/niet ingelogd
          
          ?>

            <div class="blogpost">

              <?php  

                $blogid = $_GET["blogid"];

                $query = $conn->prepare("SELECT * FROM blogposts where blogid=:blogid");

                $query->bindValue(":blogid", $blogid, PDO::PARAM_INT);

                if($query->execute() == TRUE){
                    
                  $row = $query->fetch();

                }  
              
                echo "<h3 style='text-align:center; font-size:70px'>" . $blog['blognaam'] . "</h3><br>"; 

                if($row['foto'] == NULL){
                }else{
                  echo '<img src="upload' . $row['foto'] .'" alt="Foto" style="max-height:500px; text-align:center; display:block; margin:auto;" >' . "<br>";
                }

              ?>

              <div class="blogtekst">
                <?php
                  $userid = $blog["userid"];

                  echo "<p style='float:center; text-align:center;'>" . $blog['blogtekst'] . "<br><br></p>";

                  echo "<p style='text-align:center;'>" . "Zoektermen: " . $blog['hastags'] . "<br><br></p>";
        
                  echo "<p style='text-align:center;'>" . "Datum: " . $blog['datum'] . "<br><br></p>";

                  $userid = $blog["userid"];


                  $query = $conn->prepare("SELECT * FROM information WHERE id=:userid");
                  $query->bindValue(":userid", $userid, PDO::PARAM_INT);

                  if($query->execute() == TRUE){
                    
                    $row = $query->fetch();

                    echo "<p style='text-align:center;'>"  . "Auteur: " . $row["gebruikersnaam"] . "</p><br>";
                  }  
                ?>

              </div>


            </div>


          <?php
      }

        

    }  


?>