<?php
    class PuzzleDTO
    {
        private $puzzle_ID;
        private $title;
        private $question;
        private $answer;
        private $puzzle_order;
        private $game_ID;
        private $active; 
        private $image;
        
        public function __construct(){
        }

        public function get_id():int{
            return $this->puzzle_ID;
        }

        public function get_title():string{
            return $this->title;
        }

        public function modifiy_puzzle($in_puzzle_ID, $in_title,$in_question,$in_answer,$in_puzzle_order,$in_game_ID,$in_active,$in_image){
            $this->id_file = $in_puzzle_ID;
            $this->name = $in_title;
            $this->question = $in_question;
            $this->answer = $in_answer;
            $this->puzzle_order = $in_puzzle_order;
            $this->game_ID = $in_game_ID;
            $this->active = $in_active;
            $this->image = $in_image;
        }
    }
?>