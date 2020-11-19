<?php
    require_once(PATH_APPLICATION_ROOT."/request.php");

    class Dispatcher{

        private $request;

        public function dispatch(){
            //! regarder si il a une variable de session pour empêcher de l'emener a conneciton si il en a une
            $this->request = new Request();
            $controller = $this->load_controller();
            $params = $this->request->get_params();
            if(!isset($params)){
                $params = array();
            }
            call_user_func_array([$controller, $this->request->get_action()], $params);
           
        }

        public function load_controller(){
            $controller_name = $this->request->get_controller_name() . "Controller";
            $controller_full_path = PATH_CONTROLLERS . '/' . $controller_name . '.php';
            require($controller_full_path);
            $controller = new $controller_name();
            return $controller;
        }

        
    }
?>