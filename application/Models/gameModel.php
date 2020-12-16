

<?php
    require_once(PATH_CORE."/dbModel.php");
    require_once(PATH_DTO."/manageGameDTO.php");

    class GameModel extends dbModel
    {
        const GET_GAME_START_TIME = "get_game_start_time";
        const START_GAME = "start_game";

        public function get_game_start_time()
        {
            try
            {
                $pdo = $this->get_pdo_instance();
                $procedure = $pdo->query("Call ".self::GET_GAME_START_TIME."()");
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
                $procedure = $pdo->query("Call ".self::START_GAME."(NOW())");
            }
            catch(Exception $e)
            {
            } 
        }
    }
?>