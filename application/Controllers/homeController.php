<?php

    require_once(PATH_CORE."/controller.php");
    require_once(PATH_MODELS."/teamModel.php");
    require_once(PATH_CONTROLLERS."/gameController.php");

    class HomeController extends Controller{
        
        const HOME_TITLE = "Accueil";
        private $gameController;

        public function __construct(){
            $this->gameController = new GameController();
        }

        public function show(){
            $view = new View("homeView.php");
            $data = array();
            $content = $view->render($data);
            echo $this->render_template_with_content(self::HOME_TITLE, $content);
        }

        public function is_game_started()
        {
            $is_game_started = $this->gameController->is_game_started();
            echo(json_encode($is_game_started));
        }
    }
?>