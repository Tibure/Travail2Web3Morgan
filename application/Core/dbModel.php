<?php
    class dbModel {
        static private $PDOInstance;
        private $host ='127.0.0.1';
        private $db = 'db_travail2';
        private $db_user = 'root';
        private $db_password = '';
        private $charset = 'utf8mb4';
        private $options = [
            PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_EMULATE_PREPARES=> false
        ];
        public function __construct(){
            if(is_null(self::$PDOInstance)){
                $dsn ="mysql:host=$this->host;dbname=$this->db;charset=$this->charset";
                try{
                    self::$PDOInstance = new PDO($dsn, $this->db_user, $this->db_password, $this->options);
                }catch (PDOException $e) {
                    throw new PDOException($e->getMessage(), (int)$e->getCode());
                }
            } 
        } 

        protected function get_pdo_instance(){
            return self::$PDOInstance;  
        }
    }   

    
?>