<?php

    require_once(PATH_CORE."/controller.php");

    class ErrorController extends Controller{
        
        const ERROR_TITLE = "Une erreur est survenue";
 
        public function __construct(){
            
        }

        public function show(){
            $view = new View("errorView.php");
            $data = array();
            
            $content = $view->render($data);
            echo $this->render_template_with_content(self::ERROR_TITLE, $content);
        }
    }
?>