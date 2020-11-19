<?php
    require_once(PATH_DTO."/teamDTO.php");
    class TeamParser {

        public Static function parse_post_form()
        {
            if(isset($_POST["TeamID"])){
                //Error validation
            }
            if(isset($_POST["Name"])){
               //Error validation
            }
            if(isset($_POST["CurrentPuzzleID"])){
               //Error validation
            }
            if(isset($_POST["GameID"])){
               //Error validation
            }
            if(isset($_POST["Email"])){
               //Error validation
            }
            if(isset($_POST["Password"])){
               //Error validation
            }
            if(isset($_POST["GameMaster"])){
               //Error validation
            }
            if(isset($_POST["LastAnswerSent"])){
               //Error validation
            }
            $teamDTO = new TeamDTO();
            $teamDTO->set_form_post($_POST);
            return $teamDTO;
        }
  
    }

?>