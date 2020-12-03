<?php
    require_once(PATH_SERVICE."/authenticationService.php");
    require_once(PATH_CORE."/controller.php");
    require_once(PATH_MODELS."/teamModel.php");

    class InscriptionController extends Controller{
        
        const INSCRIPTION_TITLE = "Inscription";
        private $team_model;
        public function __construct(){
            $this->team_model = new TeamModel();
        }

        public function show(){
            $view = new View("inscriptionView.php");
            $data = array();
            $content = $view->render($data);
            echo $this->render_template_with_content(self::INSCRIPTION_TITLE, $content);
        }

        public function signIn(){
            var_dump($_POST);
            $email = $_POST['email']; 
            $name = $_POST['username'];
            $password = $_POST['password']; 

            $isValid =  $this->team_model->add_team($email, $name, $password);
            echo ($isValid);
        }
    }
?>