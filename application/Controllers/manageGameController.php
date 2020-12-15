<?php

    require_once(PATH_CORE."/controller.php");
    require_once(PATH_MODELS."/manageGameModel.php");
    require_once(PATH_MODELS."/teamModel.php");

    class ManageGameController extends Controller{
        
        const MANAGEGAME_TITLE = "Modification des énigmes";
        private $manageGame;
 
        public function __construct(){
            
            $this->manageGame = new ManageGameModel();
        }

        public function show($message = "")
        {
            $teamModel = new TeamModel();
            $userValues = $teamModel->get_credentials_from_email($_SESSION["current_user"]);
            if($userValues["game_master"] == 0)
            {
                $message = "Vous n'avez pas l'autorisation de naviguer sur cette page";
                $view = new View("errorView.php");
                $title = "Une erreur est survenue";
            }
            else
            {
                $view = new View("manageGameView.php");
                $title = self::MANAGEGAME_TITLE;
            }
            $data = array("message"=>$message);
            $content = $view->render($data);
            echo $this->render_template_with_content($title, $content);
        }


        public function get_all_puzzle(){
            $puzzles = $this->manageGame->get_all_puzzles();
            echo(json_encode($puzzles)) ;
            //s$this->manageGame->get_all_puzzles();
        }

        public function get_puzzle($id_puzzle){
            $puzzle = $this->manageGame->get_a_puzzle($id_puzzle);
            echo(json_encode($puzzle)) ;
        }

        public function get_all_files(){
            $files = $this->manageGame->get_all_files();
            echo(json_encode($files)) ;
            //s$this->manageGame->get_all_puzzles();
        }

        public function get_file($id_file){
            $file = $this->manageGame->get_a_file($id_file);
            echo(json_encode($file)) ;
        }
        
        public function show_image(){
            /* $file_name = $_POST['name'];
            $file = FileService::get_instance()->retreive_file($file_name);
            echo(json_encode($file)); */
        }

        public function add_puzzle(){
            $puzzle_name = $_POST['puzzleName'];
            $selectImage = $_POST['selectImage'];
            $puzzleQuestion = $_POST['puzzleQuestion'];
            $puzzleHint = $_POST['puzzleHint'];
            $puzzleAnswer = $_POST['puzzleAnswer'];
            $puzzleActive = isset($_POST['puzzleActive']) ? 1: 0;
            try{
                $this->manageGame->add_puzzle($puzzle_name, $puzzleQuestion, $puzzleAnswer, $puzzleHint, $puzzleActive, $selectImage);
                $message = "Enigme ajouté!";
                $this->show($message);
            }catch(Exception $e){
                echo($e);
            }
            
        }
        public function save_puzzle(){
            $puzzle_name = $_POST['puzzleName'];
            $selectImage = $_POST['selectImage'];
            $puzzleQuestion = $_POST['puzzleQuestion'];
            $puzzleHint = $_POST['puzzleHint'];
            $puzzleAnswer = $_POST['puzzleAnswer'];
            $puzzleActive = isset($_POST['puzzleActive']) ? 1: 0;
            $puzzleId = $_POST['puzzleID'];
            try{
                $this->manageGame->modify_puzzle($puzzleId, $puzzle_name, $puzzleQuestion, $puzzleAnswer, $puzzleHint, $puzzleActive, $selectImage);
                $message = "Enigme modifié!";
                $this->show($message);
            }catch(Exception $e){
                echo($e);
            }
        }

        public function delete_puzzle(){
            $puzzleId = $_POST['puzzleID'];
            try{
                $this->manageGame->delete_a_puzzle($puzzleId);
                $message = "Enigme supprimé!";
                $this->show($message);
            }catch(Exception $e){
                echo($e);
            }
            
        }

        public function modify_puzzle_order(){
            $puzzle = $_POST['puzzle'];
            $this->manageGame->modify_puzzle_order($puzzle);
        }

    }
?>