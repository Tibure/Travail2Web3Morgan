<?php
    require_once(PATH_SERVICE."/authenticationService.php");
    require_once(PATH_CORE."/controller.php");

    class ConnectionController extends Controller{
        
        const CONNECTION_TITLE = "Connexion";
 
        public function __construct(){
            
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

            $isValid = AuthenticationService::get_instance()->login($email, $password);
            echo ($isValid);
        }
    }
?>