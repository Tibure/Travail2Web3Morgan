<?php
    class ManageGameDTO
    {
        public $puzzle_ID;
        public $title;
        public $question;
        public $answer;
        public $hint;
        public $puzzle_order;
        public $game_ID;
        public $active; 
        public $image;

        public function get_id():int{
            return $this->puzzle_ID;
        }

        public function get_title():string{
            return $this->title;
        }

        public function modifiy_puzzle($in_puzzle_ID, $in_title,$in_question,$in_answer,$in_hint,$in_puzzle_order,$in_game_ID,$in_active,$in_image){
            $this->id_file = $in_puzzle_ID;
            $this->name = $in_title;
            $this->question = $in_question;
            $this->answer = $in_answer;
            $this->hint = $in_hint;
            $this->puzzle_order = $in_puzzle_order;
            $this->game_ID = $in_game_ID;
            $this->active = $in_active;
            $this->image = $in_image;
        }
    }
?>