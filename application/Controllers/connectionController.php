<?php
    require_once(PATH_SERVICE."/authenticationService.php");
    require_once(PATH_CORE."/controller.php");
    require_once(PATH_MODELS."/teamModel.php");

    class ConnectionController extends Controller{
        
        const CONNECTION_TITLE = "Connexion";
 
        public function __construct(){
            $team_model = new TeamModel();
        }

        public function show(){
            $view = new View("connectionView.php");
            $data = array();
            
            $content = $view->render($data);
            echo $this->render_template_with_content(self::CONNECTION_TITLE, $content);
        }

        public function verifyLogin(){
            $email = $_POST['email']; 
            $password = $_POST['password']; 

            $isValid = AuthenticationService::get_instance()->verifyLogin($email, $password);
            echo ($isValid);
        }
    }
?>