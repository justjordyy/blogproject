<?php
  session_start();
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


  $query = $conn->prepare("SELECT gebruikersnaam FROM information WHERE id='$loginid'");



      if($query->execute() == TRUE){

        $row = $query->fetch();


        if($row != NULL){

          $gebruikersnaam = $row['gebruikersnaam'];


        }



      }


?>


<?php
  //blogsysteem

  error_reporting(E_ALL);

  $servername = "localhost";
  $username = "root";
  $password = "";
  $dbname = "testdatabase";


  $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
  
  

  if(isset($_POST["blogpostmaken"])){


    $blognaam = htmlspecialchars($_POST['blognaam']);
    $blogtekst = htmlspecialchars($_POST['blogtekst']);
    $hastags = htmlspecialchars($_POST['hastags']);  

    
    if($blognaam == NULL){

      echo("voer een blognaam in!");

    }

    if($blogtekst == NULL){

      echo("voer uw tekst in!");

    }

    if($hastags == NULL){

      echo("voer hastags in!");


    }

    $query = $conn->execute("SELECT id FROM userdata WHERE gebruikersnaam='$username'");

    $useridinfo = $row['id'];

    $query = $conn->prepare("INSERT INTO blogposts(userid, blognaam, tekst, hastags) VALUES (:userid, :blognaam, :blogtekst, :hastags)");

    $query->bindValue(":userid", $useridinfo, PDO::PARAM_INT);
    $query->bindValue(":blognaam", $blognaam, PDO::PARAM_STR);
    $query->bindValue(":blogtekst", $blogtekst, PDO::PARAM_STR);
    $query->bindValue(":hastags", $hastags, PDO::PARAM_STR);


    if($query->execute() == TRUE){

      echo("blogpost gemaakt <br>");



    }
    else{
      echo"Error: er ging iets mis, probeer het opnieuw 2 <br>";
    }
    
  }

  


?>

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
          <span class="navbar-brand"><img src="./img/brand.png"width="40" height="40" class="prof-pic"></span>

        </div>

        <?php echo "<a href=\"profielPagina.php\"><font color=\"#fffff\" size=\"5\"> $gebruikersnaam </font></a>"; ?>
      </nav>

      <div class="post-container">
        <button class="post-btn btn-outline-success" type="submit" data-bs-toggle="modal" data-bs-target="#modal" >Create Post</button>
      </div>
      <div class="check">
      </div>
      <br>
      <form method="POST" type="submit">
        <input type="text" name="blognaam" maxlength="50">Blognaam</input>
        <br><br>
        <input type="text" name="blogtekst" maxlength="400">blog tekst</input>
        <br><br>
        <input type="text" name="hastags" maxlength="30">hastags</input>
        <br><br>
        <input class="form-control" type="file" id="formFile"></input>
        <br><br>
        <input type="submit" id="blogpostmaken" name="blogpostmaken"></input>
      </form>
      



</body>



</html>
