<?php
    require_once(PATH_DTO."/teamDTO.php");
    require_once(PATH_CORE."/controller.php");
    require_once(PATH_MODELS."/teamModel.php");
    require_once(PATH_PARSER."/teamParser.php");
    class UserController extends Controller{

        private  $team_model;
        
        public function __construct(){
            $this->team_model = new UserModel();
        }

       
        public function show(){
            if(func_num_args() >0){
                $id_user = func_get_arg(0);
            }
            
            if(isset($id_user) && !empty(trim($id_user))){
                $this->show_one_team($id_user);
            }else{
                $this->show_all_teams();
            }
        }

        public function addTeam(){
            if ($_SERVER['REQUEST_METHOD'] === 'GET') {
                $this->show_add_team();
            }
            else if($_SERVER['REQUEST_METHOD'] === 'POST')
            {
                $user_to_add_DTO = UserParser::parse_post_form();
                $this->add_team($user_to_add_DTO);
                header('Location: /user/show');
            }
            
        }

        private function add_user($user_to_add_DTO){
            $this->user_model->add_user($user_to_add_DTO);
        }
    }
?>