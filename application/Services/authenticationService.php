<?php
    require_once(PATH_MODELS."/teamModel.php");

    if(session_status() == PHP_SESSION_NONE)
    {
        session_start();
    }
    
    class AuthenticationService
    {
       
        private static $AuthenticationService = null;
        private $team_model;

        public function __construct()
        {
            $this->team_model = new TeamModel();
        }

        public static function get_instance()
        {
            if(is_null(self::$AuthenticationService))
            {
                self::$AuthenticationService = new AuthenticationService();
            }
            return self::$AuthenticationService;
        }

        public function verifyLogin($email, $password)
        {   
            if ($this->attempt_login($password, $email)) 
            {
                $_SESSION["login"] = true;
                $_SESSION["current_user"] = $email;
                $_SESSION["login_time_stamp"] = time();
            }
            else 
            {
                $_SESSION["login"] = false;
                $_SESSION["current_user"] = null;
            }
            echo(json_encode($_SESSION["login"]));
        }
        
        public static function logoff()
        {
            $_SESSION["login"] = false;
            $_SESSION = array();
            if (ini_get("session.use_cookies")) 
            {
                $params = session_get_cookie_params();
                setcookie(session_name(), '', time() - 42000, $params["path"], $params["domain"], $params["secure"], $params["httponly"]);
            }
            session_destroy();
        }

        public static function hash_password($password)
        {
            return password_hash($password, PASSWORD_DEFAULT);
        }

        public function get_current_team()
        {
            return $_SESSION["team_info"];
        }

        public function is_logged_in()
        {
            if(isset($_SESSION["login"]))
            {
                return $_SESSION["login"];
            }
        }

        public function attempt_login($password, $email)
        {
            $isValid = false;
            if($this->team_model->get_credentials_from_email($email) != null && $password != null)
            {
                $isValid = password_verify($password, $this->team_model->get_credentials_from_email($email)["password"]);
            }
            return $isValid;
        }
    }
?>