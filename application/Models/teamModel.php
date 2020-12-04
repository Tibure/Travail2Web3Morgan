<?php
    require_once(PATH_CORE."/dbModel.php");
    require_once(PATH_DTO."/teamDTO.php");
    require_once(PATH_PARSER."/teamParser.php");
    require_once(PATH_EXCEPTION."/noTeamFoundException.php");
    require_once(PATH_EXCEPTION."/insertTeamException.php");
    require_once(PATH_SERVICE."/authenticationService.php");

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
            $pdo = $this->get_pdo_instance();
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
            $pdo = $this->get_pdo_instance();
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
            $pdo = $this->get_pdo_instance();
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
            try{
                $pdo = $this->get_pdo_instance();
                $statementHandle = $pdo->prepare("CALL ".self::GET_TEAM_CREDENTIALS_FROM_PROC_NAME."(:in_email)");
                $statementHandle->execute(["in_email"=>$email]);
                $team = $statementHandle->fetch(PDO::FETCH_ASSOC);
                return $team;
            }
            catch(PDOException $e){
                throw new NoteamFoundException();
            }
            
        }

        public function attempt_login($password, $email){
            $success = false;
            //! le mot de passe sera en hash
            if (get_credentials_from_email($email)->get_password() == $password) {
                $success = true;
            }
            return $success;
        }

        public function add_team($email, $name, $password){
            try{
                $passwordHash = password_hash($password, PASSWORD_DEFAULT);
                $pdo = $this->get_pdo_instance();
                $statementHandle = $pdo->prepare("CALL ".self::ADD_TEAM."(:in_email, :in_name, :in_password, :in_game_master)");
                $statementHandle->execute([
                    "in_email"=>$email, "in_name"=>$name, "in_password"=>$passwordHash, "in_game_master"=>0
                ]);
                return true;
            }
            catch(PDOException $e){
                return $e->errorInfo;
            }
            catch(Exception $e){
                return $e->errorInfo;
            }
        }
    }
?>