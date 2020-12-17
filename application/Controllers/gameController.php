<?php

    require_once(PATH_CORE."/controller.php");
    require_once(PATH_MODELS."/gameModel.php");
    require_once(PATH_MODELS."/teamModel.php");
    require_once(PATH_SERVICE."/FileService.php");
    
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
            echo $this->render_template_with_content(self::GAME_TITLE, $content);
        }

        public function start_game()
        {
            $this->gameModel->start_game();
            header('Location:/home/show');
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

        public function fill_puzzle_info(){
            $puzzle_info = $this->gameModel->get_puzzle_info();
            echo(json_encode($puzzle_info));
        }

        public function verify_answer(){
            $answer = $_POST["answer"];
            $is_answer_good = $this->gameModel->verify_answer($answer);
            echo(json_encode($is_answer_good));
        }

        public function change_puzzle(){
            $this->gameModel->change_puzzle();
            $teams = $this->teamModel->get_current_level_of_teams();
            if($teams)
            header('Location:/game/show');
        }

        public function retrieveFile($id_file){
            FileService::get_instance()->retreive_image($id_file);
        }

        public function get_all_hints_available(){
            $current_user_email = $_SESSION["current_user"];
            $current_level = $this->teamModel->get_current_level_of_one_team($current_user_email)["current_puzzle_order"];
            $availableHints = $this->gameModel->get_all_hints_available($current_level);
            echo(json_encode($availableHints));
        }
    }
?>