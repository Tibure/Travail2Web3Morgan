<?php
    require_once(PATH_DTO."/teamDTO.php");
    require_once(PATH_CORE."/controller.php");
    require_once(PATH_MODELS."/teamModel.php");
    require_once(PATH_PARSER."/teamParser.php");
    require_once(PATH_SERVICE."/authenticationService.php");

    class TeamController extends Controller{

        private  $team_model;
        
        public function __construct(){
            $this->team_model = new TeamModel();
        }
    }
?>