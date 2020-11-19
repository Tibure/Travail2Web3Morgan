<?php
    
    require_once(PATH_CORE."/controller.php");
    require_once(PATH_DTO."/fileDTO.php");
    require_once(PATH_MODELS."/fileModel.php");
    require_once(PATH_SERVICE."/fileService.php");

    class FileController extends Controller{

        const SHOW_FILES_PAGE_TITLE = "Liste des fichiers";
        const ADD_FILE_PAGE_TITLE = "Liste des fichiers";
        const NO_USER_FOUND_USER_PAGE_TITLE = "Aucun usager trouvé";
        private $file_model;
        
        public function __construct(){
            $this->file_model = new FileModel();
        }

        public function show(){
            $this->show_all_files();  
        }

        public function addFile(){
            if ($_SERVER['REQUEST_METHOD'] === 'GET') {
                $this->show_add_file();
            }else if($_SERVER['REQUEST_METHOD'] === 'POST'){
                $this->add_file();
            }  
        }

        public function download($file_id)
        {
            $fileDTO = $this->file_model->get_file($file_id);
            FileService::get_instance()->retreive_file($fileDTO->get_name());
            
        }

        private function show_all_files()
        {
            $view = new View("filesView.php");
            $files = $this->file_model->get_all_files();
            $data = array("files"=>$files);
            $content = $view->render($data);
            echo $this->render_template_with_content(self::ADD_FILE_PAGE_TITLE, $content);
        }

        private function show_add_file()
        {
            $view = new View("addFileView.php");
            $data = array();
            $content = $view->render($data);
            echo $this->render_template_with_content(self::ADD_FILE_PAGE_TITLE, $content);
        }

        private function add_file()
        {
           try
           {
                $filename = FileService::get_instance()->get_upload_file_name();
                $uploadfile = PATH_FILES . "/" . $filename;
                $file_size = FileService::get_instance()->get_upload_file_size();
                var_dump($file_size);
                //$is_file_size_ok = FileService::IsFileSizeOk($file_size);
                $is_file_already_exist = FileService::IsFileAlreadyExist($filename);
                $is_extension_ok = FileService::IsExtensionOk($uploadfile);
                if($is_file_size_ok && $is_file_already_exist == false && $is_extension_ok)
                {
                    $this->file_model->add_file($filename);
                    FileService::get_instance()->add_file();
                }
                else
                {
                    throw new Exception();
                }
           }   
           catch(Exception $e)
           {
                if($is_file_size_ok == false)
                {
                    echo $this->render_error("File Size Error", "Le fichier dépasse la taille maximum");
                }
                else if($is_file_already_exist == true)
                {
                    echo $this->render_error("File Already Exist", "Le fichier existe déjà");
                }
                else if($is_extension_ok == false)
                {
                    echo $this->render_error("File Extention Error", "L'extension n'est pas permise");
                }
           }
        }
    }
?>