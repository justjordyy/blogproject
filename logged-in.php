<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>
    <link rel="stylesheet" type="text/css" href="./css/mainpage.css">
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
          <span class="navbar-brand"><img src="./img/brand.png"width="40" height="40" class="prof-pic"> Placeholder Name</span>
        </div>
      </nav>

      <div class="post-container">
        <button class="post-btn btn-outline-success" type="submit" data-bs-toggle="modal" data-bs-target="#modal" >Create Post</button>
      </div>
      <div class="check">
      </div>

      <div class="modal fade" id="modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Maak een blogpost</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form method="post">
      <div class="modal-body">
      <div class="mb-3">
  <label for="exampleFormControlTextarea1" class="form-label">Titel</label>
  <textarea class="form-control" id="exampleFormControlTextarea1" rows="1"></textarea>
  <label for="exampleFormControlTextarea1" class="form-label">beschrijving</label>
  <textarea class="form-control" id="exampleFormControlTextarea1" rows="8"></textarea>
  <label for="exampleFormControlTextarea1" class="form-label">keywords</label>
  <textarea class="form-control" id="exampleFormControlTextarea1" rows="1"></textarea>
  <div class="input-group">
  <input type="file" class="form-control" id="inputGroupFile04" aria-describedby="inputGroupFileAddon04" aria-label="Upload">
</div>
</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Understood</button>
      </div>
    </div>
  </div>
</div>
</form>
</body>
</html>