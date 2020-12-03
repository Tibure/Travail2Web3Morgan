<?php
    require_once(PATH_CORE."/dbModel.php");
    require_once(PATH_DTO."/manageGameDTO.php");

    class ManageGameModel extends dbModel
    {
        const DELETE_PUZZLE_BY_ID_PROC_NAME = "delete_puzzle_by_id";
        const MODIFY_PUZZLE_PROC_NAME = "modify_puzzle";
        const ADD_PUZZLE_PROC_NAME = "add_puzzle";
        const GET_ALL_PUZZLE_PROC_NAME = "get_all_puzzle";
        const GET_PUZZLE_BY_ID_PROC_NAME = "get_puzzle_by_id";

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

        public function add_puzzle($title, $question, $answer, $puzzle_order, $game_ID, $active, $image){
            $pdo = $this->get_pdo_instance();
            $procedure = $pdo->prepare("Call ".self::ADD_PUZZLE_PROC_NAME.
            "(:title, :question, :answer, :puzzle_order, :game_ID, :active, :image)");
            $procedure->execute([
                 'title' => $title,
                 'question' => $question,
                 'answer' => $answer,
                 'puzzle_order' => $puzzle_order,
                 'game_ID' => $game_ID,
                 'active' => $active,
                 'image' => $image
            ]);
        }

        public function modify_puzzle($id_puzzle, $title, $question, $answer, $puzzle_order, $game_ID, $active, $image){
            $pdo = $this->get_pdo_instance();
            $procedure = $pdo->prepare("Call ".self::MODIFY_PUZZLE_PROC_NAME.
            "(:id_puzzle, :title, :question, :answer, :puzzle_order, :game_ID, :active, :image)");
            $procedure->execute([
                'id_puzzle' => $id_puzzle,
                 'title' => $title,
                 'question' => $question,
                 'answer' => $answer,
                 'puzzle_order' => $puzzle_order,
                 'game_ID' => $game_ID,
                 'active' => $active,
                 'image' => $image
            ]);
        }
    }


//je nutilise pas le DTO en tant que tel on va juste otute shooter les info une a unbe
?>