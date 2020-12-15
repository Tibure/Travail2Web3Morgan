<?php

    require_once(PATH_CORE."/controller.php");
    require_once(PATH_MODELS."/manageGameModel.php");

    class ManageGameController extends Controller{
        
        const MANAGEGAME_TITLE = "Modification des énigmes";
        private $manageGame;
 
        public function __construct(){
            
            $this->manageGame = new ManageGameModel();
        }

        public function show(){
            $view = new View("manageGameView.php");
            $data = array();
            
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
            $file_name = $_POST['name'];
            $file = FileService::retreive_file($file_name);
            echo(json_encode($file));
        }
    }
?>