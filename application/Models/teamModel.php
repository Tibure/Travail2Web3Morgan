<?php
    require_once(PATH_CORE."/dbModel.php");
    require_once(PATH_DTO."/teamDTO.php");
    require_once(PATH_PARSER."/teamParser.php");
    require_once(PATH_EXCEPTION."/noTeamFoundException.php");
    require_once(PATH_EXCEPTION."/insertTeamException.php");

    class TeamModel extends dbModel
    {
        const GET_ALL_TEAMS_PROC_NAME = "get_all_teams";
        const GET_TEAM_BY_ID_PROC_NAME = "get_team_by_id";
        const GET_TEAM_CREDENTIALS_FROM_PROC_NAME = "get_team_credentials_from_email";
        const GET_GAME_MASTER = "get_game_master";
        const ADD_TEAM = "add_team";

        public function get_all_teams():array{  
            /*
            $result = $this->mysqli->query("CALL ".self::GET_ALL_TEAMS_PROC_NAME."()");

            $teams = array();
            while ($row = $result->fetch_assoc()) {
                array_push($teams, TeamParser::parse_sql_row($row));
            }
            return $teams;*/
            $pdo = $this->GetPDOInstance();
            $statementHandle = $pdo->query("CALL ".self::GET_ALL_TEAMS_PROC_NAME."()");
            $teams = $statementHandle->fetchAll(PDO::FETCH_CLASS, 'TeamDTO');
            if($teams === false)
            {
                throw new NoteamFoundException();
            }
            return $teams;
        }

        public function get_team(int $team_id)
        {
            $pdo = $this->GetPDOInstance();
            $statementHandle = $pdo->query("CALL ".self::GET_TEAM_BY_ID_PROC_NAME."($team_id)");
            $team = $statementHandle->fetchAll(PDO::FETCH_CLASS, 'TeamDTO');
            if($team === false)
            {
                throw new NoteamFoundException();
            }
            return $team;
        }

        
        public function get_game_master()//il y a seulement un game master
        {
            $pdo = $this->GetPDOInstance();
            $statementHandle = $pdo->query("CALL ".self::GET_GAME_MASTER);
            $gameMaster = $statementHandle->fetchAll(PDO::FETCH_CLASS, 'TeamDTO');
            if($gameMaster === false)
            {
                throw new NoteamFoundException();
            }
            return $gameMaster;
        }

        public function get_credentials_from_email($email)
        {
            $pdo = $this->GetPDOInstance();
            $statementHandle = $pdo->prepare("CALL ".self::GET_team_CREDENTIALS_FROM_PROC_NAME."(:email)");
            $statementHandle->execute(["email"=>$email]);
            $team = $statementHandle->fetch(PDO::FETCH_ASSOC);
            if($team === false)
            {
                throw new NoteamFoundException();
            }
            return $team;
        }

        public function attempt_login($password, $email){
            $success = false;
            //! le mot de passe sera en hash
            var_dump($password, $email);
            if (get_credentials_from_email($email)->get_password() == $password) {
                $success = true;
            }
            return $success;
        }

        public function add_team(){
            if($_SERVER['REQUEST_METHOD'] === 'POST')
            {
                $team_to_add_DTO = TeamParser::parse_post_from();
                $this->team_user($team_to_add_DTO);
                header('Location: /connexion/addTeam');
            }

        }
    }
?>