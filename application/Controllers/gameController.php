<?php

    require_once(PATH_CORE."/controller.php");
    
    class GameController extends Controller{
        
        const GAME_TITLE = "Énigme";
 
        public function __construct(){
            
        }

        public function show(){
            $view = new View("gameView.php");
            $data = array();
            
            $content = $view->render($data);
            echo $this->render_template_with_content(self::GAME_TITLE, $content);
        }
    }
?>