<?php

    require_once(PATH_CORE."/controller.php");
    require_once(PATH_MODELS."/manageGameModel.php");

    class ManageGameController extends Controller{
        
        const MANAGEGAME_TITLE = "Modification des énigmes";
        private $manageGame;
 
        public function __construct(){
            
            $this->manageGame = new ManageGameModel();
        }

        public function show($message = ""){
            $view = new View("manageGameView.php");
            $data = array("message"=>$message);
            $content = $view->render($data);
            echo $this->render_template_with_content(self::MANAGEGAME_TITLE, $content);
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
            $file = $this->manageGame->get_a_files($id_file);
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
            $puzzleActive = $_POST['puzzleActive'] === "on" ? 1 : 0;
            var_dump($_POST);
           //MANQUE PUZZLE ORDER
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
            $puzzleActive = $_POST['puzzleActive'] === "on" ? 1: 0;
            $puzzleId = $_POST['puzzleID'];
            // MANQUE PUZZLE ORDER

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
            try{
                $puzzlesOrder = $_POST['puzzlesOrder'];
                $this->manageGame->modify_puzzle_order($puzzlesOrder);
                echo(json_encode(true));
            }catch(Exception $e){
                var_dump($e);
            }
            
        }

    }
?>