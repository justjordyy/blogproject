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

  $conn = new PDO('mysql:host=localhost;dbname=test', 'hoofdadmin', 'hoofdadmin123');

  $username = $_SESSION['loginid'];




  if(!isset($_SESSION['loginid'])){
    //LET OP hij redirect nog naar de copy pagina. 
    header('Location: index copy.php');
  }


  $query = $conn->prepare("SELECT * FROM userdata WHERE gebruikersnaam='$username'");



      if($query->execute() == TRUE){

        $row = $query->fetch();


        if($row != NULL){
          
          $username = $row['gebruikersnaam'];
          

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

        <?php echo "<a href=\"profielPagina.php\"><font color=\"#fffff\" size=\"5\"> $username </font></a>"; ?>
      </nav>

      <div class="post-container">
        <button class="post-btn btn-outline-success" type="submit">Create Post</button>
      </div>
      <div class="check">
      </div>
</body>



</html>
