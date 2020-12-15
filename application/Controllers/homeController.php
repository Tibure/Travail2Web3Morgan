<?php

    require_once(PATH_CORE."/controller.php");
    require_once(PATH_MODELS."/teamModel.php");

    class HomeController extends Controller{
        
        const HOME_TITLE = "Accueil";
 
        public function __construct(){
            
        }

        public function show(){
            $view = new View("homeView.php");
            $data = array();
            
            $content = $view->render($data);
            echo $this->render_template_with_content(self::HOME_TITLE, $content);
        }

        public function launchGame()
        {
            $teamModel = new TeamModel();
            $userValues = $teamModel->get_credentials_from_email($_SESSION["current_user"]);
            if($userValues["game_master"] == 0)
            {
                $message = "Vous n'avez pas l'autorisation de lancer une partie";
                $view = new View("errorView.php");
                $data = array("message"=>$message);
                $content = $view->render($data);
                echo $this->render_template_with_content("Une erreur est survenue", $content);
            }
        }
    }
?>