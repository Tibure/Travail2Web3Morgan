<?php
    require_once(PATH_CORE."/dbModel.php");
    require_once(PATH_DTO."/fileDTO.php");
    //require_once(PATH_EXCEPTION."/fileNotFoundException.php");
    require_once(PATH_EXCEPTION."/fileInsertionException.php");

    class FileModel extends dbModel
    {
        const GET_ALL_FILES_PROC_NAME = "get_all_files";
        const GET_FILE_BY_ID_PROC_NAME = "get_file_by_id";
        const ADD_FILE_PROC_NAME = "add_file";

        public function get_all_files(){
            $pdo = $this->get_pdo_instance();
            $statementHandle = $pdo->query("CALL ".self::GET_ALL_FILES_PROC_NAME."()");
            $files = $statementHandle->fetchAll(PDO::FETCH_CLASS, 'FileDTO');
            if($files === false){
                throw new Exception("Une erreur est survenue lors de la récupération de la liste des fichiers.");
            }
            return $files;
        }

        public function get_file(int $id_file){
            $pdo = $this->get_pdo_instance();
            $statementHandle = $pdo->prepare("CALL ".self::GET_FILE_BY_ID_PROC_NAME."(:id_file)");
            $statementHandle->execute(["id_file"=>$id_file]);
            $statementHandle->setFetchMode(PDO::FETCH_CLASS, 'FileDTO');
            $file = $statementHandle->fetch();
            if($file === false){
                throw new FileNotFoundException('Ce fichier est introuvable.');
            }
            return $file;
        }

        public function add_file($filename){

            $pdo = $this->get_pdo_instance();
            $statementHandle = $pdo ->prepare("CALL ".self::ADD_FILE_PROC_NAME."(:name)");

            try{
                print($filename);
                $statementHandle->execute(["name"=>$filename]);
            }catch(PDOException $e){
                throw new FileInsertionException('Une erreur est survenu durant l\'insertion.');
            }
        }

    }
?>