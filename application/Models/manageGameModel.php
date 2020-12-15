<?php
    require_once(PATH_CORE."/dbModel.php");
    require_once(PATH_DTO."/manageGameDTO.php");

    class ManageGameModel extends dbModel
    {
        const DELETE_PUZZLE_BY_ID_PROC_NAME = "delete_puzzle_by_id";
        const MODIFY_PUZZLE_PROC_NAME = "modify_puzzle";
        const MODIFY_PUZZLE_ORDER = "modify_puzzle_order";

        const ADD_PUZZLE_PROC_NAME = "add_puzzle";
        const GET_ALL_PUZZLE_PROC_NAME = "get_all_puzzle";
        const GET_PUZZLE_BY_ID_PROC_NAME = "get_puzzle_by_id";
        const GET_ALL_FILES_PROC_NAME = "get_all_files";
        const GET_FILE_BY_ID_PROC_NAME = "get_file_by_id";


        public function get_all_puzzles(){
            $pdo = $this->get_pdo_instance();
            $procedure = $pdo->prepare("Call ".self::GET_ALL_PUZZLE_PROC_NAME."()");
            $procedure->execute([
                 
            ]);
            $lesPuzzles = $procedure->fetchAll(PDO::FETCH_CLASS,"manageGameDTO");
            return $lesPuzzles;
        }

        public function get_a_puzzle($id_puzzle){
            $pdo = $this->get_pdo_instance();
            $procedure = $pdo->prepare("Call ".self::GET_PUZZLE_BY_ID_PROC_NAME."(:id_puzzle)");
            $procedure->execute([
                'id_puzzle' => $id_puzzle
           ]);
           $lePuzzle = $procedure->fetchAll(PDO::FETCH_CLASS,"manageGameDTO");
           return $lePuzzle;
        }

        public function delete_a_puzzle($id_puzzle){
            $pdo = $this->get_pdo_instance();
            $procedure = $pdo->prepare("Call ".self::DELETE_PUZZLE_BY_ID_PROC_NAME."(:id_puzzle)");
            $procedure->execute([
                'id_puzzle' => $id_puzzle
           ]);
        }

        public function add_puzzle($title, $question, $answer, $hint, $active, $image){
            $pdo = $this->get_pdo_instance();
            $procedure = $pdo->prepare("Call ".self::ADD_PUZZLE_PROC_NAME.
            "(:inTitle, :inQuestion, :inAnswer, :inHint, :inActive, :inImage)");
            $procedure->execute([
                 'inTitle' => $title,
                 'inQuestion' => $question,
                 'inAnswer' => $answer,
                 'inHint' => $hint,
                 'inActive' => $active,
                 'inImage' => $image
            ]);
        }

        public function modify_puzzle($id_puzzle, $title, $question, $answer, $hint, $active, $image){
            $pdo = $this->get_pdo_instance();
            $procedure = $pdo->prepare("Call ".self::MODIFY_PUZZLE_PROC_NAME."(:inPuzzle_ID, :inTitle, :inQuestion, :inAnswer,:inHint, :inActive, :inImage)");
            $procedure->execute([
                'inPuzzle_ID' => $id_puzzle,
                 'inTitle' => $title,
                 'inQuestion' => $question,
                 'inAnswer' => $answer,
                 'inHint' => $hint,
                 'inActive' => $active,
                 'inImage' => $image
            ]);
        }

        public function modify_puzzle_order($puzzlesOrder){
            foreach($puzzlesOrder as $puzzleOrder){
                $pdo = $this->get_pdo_instance();
                $procedure = $pdo->prepare("Call ".self::MODIFY_PUZZLE_ORDER.
                "(:id_puzzle, :new_order)");
                $procedure->execute([
                    'id_puzzle' => $puzzleOrder['puzzle_ID'],
                    'new_order' => $puzzleOrder['puzzle_order']
                ]);
            
            };
        }

        public function get_all_files(){
            $pdo = $this->get_pdo_instance();
            $procedure = $pdo->prepare("Call ".self::GET_ALL_FILES_PROC_NAME."()");
            $procedure->execute([
                 
            ]);
            $les_files = $procedure->fetchAll();
            return $les_files;
        }

        public function get_a_file($id_file){
            $pdo = $this->get_pdo_instance();
            $procedure = $pdo->prepare("Call ".self::GET_FILE_BY_ID_PROC_NAME."(:in_id_file)");
            $procedure->execute([
                'in_id_file' => $id_file
           ]);
           $le_file = $procedure->fetchAll();
           return $le_file;
        }
        

    }
  


//je nutilise pas le DTO en tant que tel on va juste otute shooter les info une a unbe
?>