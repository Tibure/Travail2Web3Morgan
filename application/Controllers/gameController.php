<?php

    require_once(PATH_CORE."/controller.php");
    require_once(PATH_MODELS."/gameModel.php");
    require_once(PATH_MODELS."/teamModel.php");
    
    class GameController extends Controller{
        
        const GAME_TITLE = "Énigme";
        const HOME_TITLE = "Accueil";
        private $gameModel;
        private $teamModel;

        public function __construct(){
            $this->gameModel = new GameModel();
            $this->teamModel = new TeamModel();
        }

        public function show()
        {
            $view = new View("gameView.php");
            $data = array();
            $content = $view->render($data);
        }

        public function start_game()
        {
            $this->gameModel->start_game();
        }

        public function is_game_started()
        {
            $is_game_started = true;
            $start_time = $this->gameModel->get_game_start_time()["start_time"];
            if((time() - $start_time) > 3600)
            {
                $is_game_started = false;
            }
            echo(json_encode($is_game_started));
        }

        public function get_current_level_of_teams()
        {
            $teams = $this->teamModel->get_current_level_of_teams();
            echo(json_encode($teams));
        }

        public function get_number_puzzle_active()
        {
            $number = $this->teamModel->get_number_puzzle_active();
            echo(json_encode($number));
        }

        public function get_time_left(){
            $time = $this->gameModel->get_game_start_time()["start_time"];
            $time_left =3600 - (time() - $time);
            echo(json_encode($time_left));
        }
    }
?>