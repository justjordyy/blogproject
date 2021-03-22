<?php
  session_start();

  $servername = "localhost";
  $username = "root";
  $password = "";
  $dbname = "testdatabase";
  
  $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
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
    <title>BlogBay</title>
</head>
<body>

        <div class="modal fade" id="modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="staticBackdropLabel">Maak een blogpost</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form method="post" enctype="multipart/form-data" Type="submit">
        <div class="modal-body">
        <div class="mb-3">
    <label for="exampleFormControlTextarea1" class="form-label">Titel</label>
    <textarea class="form-control" id="exampleFormControlTextarea1" maxlength="40" name="blognaam" rows="1"></textarea>
    <label for="exampleFormControlTextarea1" class="form-label">Beschrijving</label>
    <textarea class="form-control" id="exampleFormControlTextarea1" maxlength="1000" name="blogtekst" rows="8"></textarea>
    <label for="exampleFormControlTextarea1" maxlength="20" class="form-label">Hastags</label>
    <textarea class="form-control" id="exampleFormControlTextarea1" name="hastags" rows="1"></textarea>
    <div class="input-group">
      <input type="file" class="form-control" id="imageUpload" name="imageUpload" aria-describedby="inputGroupFileAddon04" aria-label="Upload">
  </div>
  </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Sluiten</button>
          <input type="submit" id="blogpostmaken" name="blogpostmaken" value="Aanmaken" class="btn btn-primary"></input>
        </div>
      </div>
    </div>
  </div>
</form>

<?php



$servername = "localhost";
$username = "root";
$password = "";
$dbname = "testdatabase";
  

$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);


 $loginid = $_SESSION['loginid'];


  if(!isset($_SESSION['loginid'])){
    header('Location: index.php');
  }


  $query = $conn->prepare("SELECT gebruikersnaam FROM information WHERE id=:loginid");

  $query->bindValue(":loginid", $loginid, PDO::PARAM_INT);



      if($query->execute() == TRUE){

        $row = $query->fetch();


        if($row != NULL){

          $gebruikersnaam = $row['gebruikersnaam'];


        }



      }


?>

<div class="loader">loading....</div> <!-- Website loader -->
    <!-- Navigatie bar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
      <div class="container-fluid">
        <a class="navbar-brand" id="brandcolor" href="#">
          <img src="./img/logo1.png"width="40" height="40" class="d-inline-block align-top">
          BlogBay</a>
          <form method="post" type="submit" class="d-flex">
            <input class="form-control me-2" type="search" name="zoekTermen" placeholder="zoeken" aria-label="Search">
            <form method="post" type="submit">
              <div class="zoeken-button">
                <input type="submit" id="zoeken" name="zoeken" class="post-btn" value="zoeken" >
              </div>
            </form>
          </form>
          <span></span>

        </div>

        <?php echo "<a style='padding-right:10px' href=\"eigenProfielPagina.php\"><font color=\"#fffff\" size=\"5\"> $gebruikersnaam </font></a>"; ?>
      </nav>

      <div class="post-container">
        <button class="post-btn btn-outline-success" type="submit" data-bs-toggle="modal" data-bs-target="#modal" >Blog post maken</button>
      </div>
      <div class="check">
      </div>
      <br>
</div>
<br><br>

<?php
  //blog maken

  error_reporting(0);

  if(isset($_POST["blogpostmaken"])){



    $blognaam = htmlspecialchars($_POST['blognaam']);
    $blogtekst = htmlspecialchars($_POST['blogtekst']);
    $hastags = htmlspecialchars($_POST['hastags']);

    
    if($blognaam == NULL){


      header("Location: logged-in.php");

      echo("voer een blognaam in!");

      
      die;
    }

    if($blogtekst == NULL){

      
      header("Location: logged-in.php");
      echo("voer uw tekst in!");
      

      die;
    }

    if($hastags == NULL){

      
      header("Location: logged-in.php");

      echo("voer hastags in!");
      die;
    }

    $useridinfo = $loginid;

    //bewerk foto die geupload is

    $target_dir = "upload";
    $target_file = $target_dir . basename($_FILES["imageUpload"]["name"]);
    $uploadOk = 1;
    $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);

    if (move_uploaded_file($_FILES["imageUpload"]["tmp_name"], $target_file)) {
        echo "The file ". basename( $_FILES["imageUpload"]["name"]). " has been uploaded.";

        $image = basename( $_FILES["imageUpload"]["name"],".jpg"); // sla de bestandsnaam op
        
    }


    $image=basename( $_FILES["imageUpload"]["name"],".jpg"); // sla de bestandsnaam op


    //datum van blogpost
    $datum = date('Y-m-d G:i:s');

    //maak blogpost          
    $query = $conn->prepare("INSERT INTO blogposts(userid, blognaam, blogtekst, foto, hastags, datum) VALUES (:userid, :blognaam, :blogtekst, '$image', :hastags, :datum)");

    $query->bindValue(":userid", $useridinfo, PDO::PARAM_INT);
    $query->bindValue(":blognaam", $blognaam, PDO::PARAM_STR);
    $query->bindValue(":blogtekst", $blogtekst, PDO::PARAM_STR);
    $query->bindValue(":hastags", $hastags, PDO::PARAM_STR);
    $query->bindValue(":datum", $datum, PDO::PARAM_STR);
    
    if($query->execute() == TRUE){

      $query = $conn->prepare("SELECT * FROM blogposts ORDER BY datum DESC");  
    }

  }
  
  //blogzoeken functie
  include "blogZoeken.php";

  //blog feed functie
  include "blogFeed.php";


?>














</body>



</html>
