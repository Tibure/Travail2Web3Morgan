<?php
    class TeamDTO
    {
        private $team_ID;
        private $name;
        private $current_puzzle_ID;
        private $game_ID;
        private $email;
        private $password;
        private $game_master;
        private $last_answer_sent;

        public function __construct(){
        }

        public function set_form_post($post_array){
            foreach ($post_array as $key => $value){
                $this->$key = $value;
            }
        }

        public function get_id(){
            return $this->team_ID;
        }

        public function get_name(){
            return $this->$name;
        }

        public function get_current_puzzle_id(){
            return $this->$current_puzzle_ID;
        }

        public function get_game_id(){
            return $this->$game_ID;
        }

        public function get_email(){
            return $this->$email;
        }

        public function get_password(){
            return $this->$password;
        }
        
        public function get_game_master(){
            return $this->$game_master;
        }
        
        public function get_last_answer_sent(){
            return $this->$last_answer_sent;
        }
    }
?>