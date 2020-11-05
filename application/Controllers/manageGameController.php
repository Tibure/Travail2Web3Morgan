<?php

    require_once(PATH_CORE."/controller.php");

    class ManageGameController extends Controller{
        
        const MANAGEGAME_TITLE = "Modification des énigmes";
 
        public function __construct(){
            
        }

        public function show(){
            $view = new View("manageGameView.php");
            $data = array();
            
            $content = $view->render($data);
            echo $this->render_template_with_content(self::MANAGEGAME_TITLE, $content);
        }
    }
?>