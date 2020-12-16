<?php
    require_once(PATH_SERVICE."/authenticationService.php");
    require_once(PATH_CORE."/controller.php");
    require_once(PATH_MODELS."/teamModel.php");
    require_once(PATH_SERVICE."/fileService.php");

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
            $email = $_POST['email']; 
            $name = $_POST['username'];
            $password = $_POST['password'];
            $confirm_password = $_POST['confirm_password'];
            $response = array("isValid" => false);
            if($password == "" || $confirm_password != $password)
            {
                $response = array("isValid" => false);
            }
            else
            {
                $isValid = $this->team_model->add_team($email, $name, $password);
                if($isValid == true)
                {
                    $response = array("isValid" => true);
                }
                else if(is_array($isValid) && count($isValid)>2)
                {
                    if(strpos($isValid[2], "Email") !== false)
                    {
                        $response = array("errorMessage" => "Email is already chosen", "inputID" => "email", "isValid" => false);
                    }
                    else
                    {
                        $response = array("errorMessage" => "name is already chosen", "inputID" => "username", "isValid" => false);
                    }
                }
            }
        echo(json_encode($response));
    }
}
?>