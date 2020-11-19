<?php
    class FileDTO
    {
        private $id_file;
        private $name;
        
        public function __construct(){
        }

        public function get_id():int{
            return $this->id_file;
        }

        public function get_name():string{
            return $this->name;
        }

        public function set_from_post($id, $new_name){
            $this->id_file = $id;
            $this->name = $new_name;
        }
    }
?>