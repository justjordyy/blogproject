<?php
  //blog laten zien


    $query = $conn->prepare("SELECT * FROM blogposts ORDER BY datum DESC");


    if($query->execute() == TRUE){

      if($query->rowCount()>0){

        ?>
          <h4>Blog Feed</h4>
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
                    <?php
                    $tekst = substr($row["blogtekst"], 0, 100);
                    echo $tekst . "...";
                    ?>
                    <?php
                      echo "<a href='blogpaginaView.php?blogid=" . $row["blogid"] . "'>" . "Lees verder" . "</a><br><br>";
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
    <?php        
        }



    }
    else{
      echo("geen blogposts beschikbaar");
    }

  }

?>