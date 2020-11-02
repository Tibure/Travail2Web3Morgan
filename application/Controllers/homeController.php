<?php

    require_once(PATH_CORE."/controller.php");

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
    }
?>