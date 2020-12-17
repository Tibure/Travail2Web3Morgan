<?php
    require_once(PATH_CORE."/dbModel.php");
    require_once(PATH_DTO."/manageGameDTO.php");

    class GameModel extends dbModel
    {
        const GET_GAME_START_TIME_PROC_NAME = "get_game_start_time";
        const START_GAME_PROC_NAME = "start_game";
        const GET_PUZZLE_INFO_PROC_NAME = "get_puzzle_info";
        const GET_ANSWER_FROM_EMAIL_PROC_NAME = "get_answer_from_email";
        const CHANGE_PUZZLE_PROC_NAME = "change_puzzle";
        const GET_ALL_HINTS_AVAILABLE = "get_all_hints_available";

        public function get_game_start_time()
        {
            try
            {
                $pdo = $this->get_pdo_instance();
                $procedure = $pdo->query("Call ".self::GET_GAME_START_TIME_PROC_NAME."()");
                $start_time = $procedure->fetch();
                return $start_time;
            }
            catch(Exception $e)
            {
            }
        }

        public function start_game()
        {
            try
            {
                $pdo = $this->get_pdo_instance();
                $pdo->query("CALL ".self::START_GAME_PROC_NAME."(NOW())");
            }
            catch(Exception $e)
            {
            } 
        }

        public function get_puzzle_info()
        {
            try
            {
                $current_user_email = "";
                $pdo = $this->get_pdo_instance();
                if($_SESSION["login"] == true)
                {
                    $current_user_email = $_SESSION["current_user"];
                }
                $procedure = $pdo->prepare("CALL ".self::GET_PUZZLE_INFO_PROC_NAME."(:in_email)");
                $procedure->execute([
                    'in_email' => $current_user_email
                ]);
                $puzzle_info = $procedure->fetch();
                return $puzzle_info;
            }
            catch(Exception $e)
            {
            } 
        }

        public function verify_answer($answer)
        {
            try
            {
                $current_user_email = "";
                $pdo = $this->get_pdo_instance();
                if($_SESSION["login"] === true)
                {
                    $current_user_email = $_SESSION["current_user"];
                }
                $procedure = $pdo->prepare("CALL ".self::GET_ANSWER_FROM_EMAIL_PROC_NAME."(:in_email)");
                $procedure->execute([
                    'in_email' => $current_user_email
                ]);
                $response = $procedure->fetch();
                if($response["answer"] == $answer)
                {
                    return true;
                }
                else
                {
                    return false;
                }
            }
            catch(Exception $e)
            {
            } 
        }

        public function change_puzzle()
        {
            try
            {
                $current_user_email = "";
                $pdo = $this->get_pdo_instance();
                if($_SESSION["login"] === true)
                {
                    $current_user_email = $_SESSION["current_user"];
                }
                $procedure = $pdo->prepare("CALL ".self::CHANGE_PUZZLE_PROC_NAME."(:in_email)");
                $procedure->execute([
                    'in_email' => $current_user_email
                ]);
            }
            catch(Exception $e)
            {
            } 
        }

        public function get_all_hints_available($current_level){
            try{
                $pdo = $this->get_pdo_instance();
                $statementHandle = $pdo->prepare("CALL ".self::GET_ALL_HINTS_AVAILABLE."(:current_level)");
                $statementHandle->execute(["current_level"=>$current_level]);
                $hints_available = $statementHandle->fetchAll();
                return $hints_available;
            }catch(PDOException $e){

            }
        }
    }
?>