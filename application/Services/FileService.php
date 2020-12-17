<?php
    require_once(PATH_DTO."/fileDTO.php");
    require_once(PATH_MODELS."/fileModel.php");
    require_once(PATH_CONTROLLERS."/fileController.php");
    require_once(PATH_MODELS."/manageGameModel.php");

    
    class FileService{
        private static $FileService= null;
        private $manageGame;

        public function __construct(){
            $this->manageGame = new ManageGameModel();
        } 

        public static function get_instance(){
            if(is_null(self::$FileService)){
                self::$FileService = new FileService();
            } 
            return self::$FileService;
        }

        public function add_file()
        {
            $uploadfile = PATH_FILES . "/" . basename($_FILES['file']['name']);
            echo '<pre>';
            if (move_uploaded_file($_FILES['file']['tmp_name'], $uploadfile)) 
            {
                echo "File is valid, and was successfully uploaded.\n";
                header("location:/manageGame/show");
            } else 
            {
                echo "Possible file upload attack!\n";
            }
        }

        public static function IsExtensionOk($uploadfile)
        {
            $is_extension_ok = false;
            $extension = pathinfo($uploadfile, PATHINFO_EXTENSION);
            if($extension == "jpg")
            {
                $is_extension_ok = true;
            }
            return $is_extension_ok;
        }
        
        public static function IsNotEmpty($uploadfile)
        {
            $is_not_empty = false;
            $extension = pathinfo($uploadfile, PATHINFO_EXTENSION);
            if($extension != "")
            {
                $fileName = pathinfo($uploadfile,PATHINFO_FILENAME);
                if ($fileName != "") {
                    $is_not_empty = true;
                }
            }
            return $is_not_empty;
        }

        public static function IsFileSizeOk($file_size)
        {
            $is_file_size_ok = false;
            if($file_size <= 2097152)
            {
                $is_file_size_ok = true;
            }
            return $is_file_size_ok;
        }

        public static function IsFileAlreadyExist($filename)
        {
            $is_file_already_exist = false;
            $data = FileService::get_instance()->retreive_file_list();
            for($i = 0; $i < count($data); $i++)
            {
                if($data[$i]->get_name() == $filename)
                {
                    $is_file_already_exist = true;
                }
            }
            return $is_file_already_exist;
        }

        public function retreive_file_list(){
            $files = array_diff(scandir(PATH_FILES), array('..', '.'));
            $array_File_DTO = array();
            $fakeID =1;
            foreach($files as $file){
                $new_file = new FileDTO();
                $new_file->set_from_post($fakeID, $file);
                array_push($array_File_DTO, $new_file);
                $fakeID++;
            }
            return $array_File_DTO;
        }

        public function retreive_file($file_name)
        {
            $file = PATH_FILES."/".$file_name;

            if (file_exists($file)) {
                header('Content-Description: File Transfer');
                header('Content-Type: application/octet-stream');
                header('Content-Disposition: attachment; filename="'.basename($file).'"');
                header('Expires: 0');
                header('Cache-Control: must-revalidate');
                header('Pragma: public');
                header('Content-Length: ' . filesize($file));
                readfile($file);
            };               
        }

        public function retreive_image($id_file)
        {
            $image = $this->manageGame->get_a_file($id_file);
            if($image != null)
            {
                $name = PATH_FILES.'/'.$image["name"];
                $fp = fopen($name, 'rb');
                header("Content-Type: image/jpeg");
                header("Content-Length: " . filesize($name));
                fpassthru($fp);
                exit;
            }  
        }

        public function get_upload_file_name()
        {
            $file_name = basename($_FILES['file']['name']);
            return $file_name;
        }
        public function get_upload_file_size()
        {
            $file_size = $_FILES['file']['size'];
            return $file_size;
        }
        private function validate(){
            //fileUploadAttack
        }
    }

?>