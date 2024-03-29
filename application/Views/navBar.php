<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand" href="/">Escape Room 774</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
    aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item active">
        <a class="nav-link" href="/">Accueil<span class="sr-only">(current)</span></a>
      </li>
      <?php
      echo('<script type="text/javascript" src="\public\js\navBar.js"></script>');
    require_once(PATH_MODELS."/teamModel.php");
    require_once(PATH_CONTROLLERS."/gameController.php");
    try {
          if(isset($_SESSION["login"]))
          {
            if($_SESSION["login"] == true)
            {
              $teamModel = new TeamModel();
              $userValues = $teamModel->get_credentials_from_email($_SESSION["current_user"]);
              if($userValues["game_master"])
              {
                echo("<li class=\"nav-item\"><a class=\"nav-link\" href=\"/game/start_game\">Démarrer une partie<span class=\"sr-only\">(current)</span></a></li>");
                echo("<li class=\"nav-item\"><a class=\"nav-link\" href=\"/manageGame/show\">Gestion des énigmes<span class=\"sr-only\">(current)</span></a></li>");
              }
              echo("<li class=\"nav-item\" id=\"join_game\"></li>");
              echo("</ul><ul class=\"navbar-nav justify-content-end\"> 
              <li class=\"nav-item nav-link\" style=\"color:green\" id=\"time_left\"><span>1:00:00</span></li>
              <li class=\"nav-item\"><a class=\"nav-link\" href=\"/connection/disconnect\">Deconnexion<span class=\"sr-only\">(current)</span></a></li>
              <li class=\"nav-item justify-content-end\"><a class=\"nav-link disabled\" href=\"\">­<span>Connecté: ".$userValues["name"]."</span></a></li>");
            }
          }
          else
          {
            echo("<li class=\"nav-item\">
              <a class=\"nav-link\" href=\"/connection/show\">Se connecter<span class=\"sr-only\">(current)</span></a>
            </li>");
            echo("<li class=\"nav-item\">
              <a class=\"nav-link\" href=\"/inscription/show\">S'inscrire<span class=\"sr-only\">(current)</span></a>
            </li>");
          }
          }
          catch(Exception $e)
          {
          }
      ?>
      </ul­>
  </div>
</nav>