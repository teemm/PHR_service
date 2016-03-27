<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
//menu
require 'base.php';
class FileManager extends Base {
    var $id = 0;
    var $rootname = 'uploads';

    // black list of folders should not be deleted
    var $folder_black_list = array();

    public function __construct() {
        parent::__construct();
        parent::block_unauthorized();

        $root = FCPATH.'assets';
        $this->folder_black_list[$root.'/'.$this->rootname] = true;
        $this->folder_black_list[$root.'/uploads/homepage'] = true;
        $this->folder_black_list[$root.'/uploads/news'] = true;
        $this->folder_black_list[$root.'/uploads/contents'] = true;
        $this->folder_black_list[$root.'/uploads/gallery'] = true;
    }

    // Get all files and directories in root folder
    public function get_files() {
        $dir = FCPATH.'assets/uploads';
        $result = $this->getChildren($dir, '');

        // Set up root for use
        $result['name'] = $this->rootname;
        $result['expanded'] = true;
        $result['isroot'] = true;
        $result['iconCls'] = 'root';
        
        //var_dump($result);

        $this->output->set_content_type('application/json')->set_output(json_encode(array('success' => true, 'children' => $result)));
        //$this->output->set_content_type('application/json')->set_output(json_encode(array('success' => true, 'children' => $dir)));
    }


    // Add new directory
    public function add_dir() {
        try{
            $path = $this->input->post('path');
            $name = $this->input->post('name');

            $root = FCPATH.'assets/uploads';
            $path = realpath($path);

            // useless parameters
            if ($path && $name) {
                // user tries to add directory outside of a root folder
                if (strpos($path, $root) === false)
                    throw new Exception("თქვენ არ გაქვთ ამის უფლება", 1);

                // there are illegal symbols in name
                if (strpbrk($name, "\\/?%*:|\"<>"))
                  throw new Exception("სახელი არ შეიძლება შეიცავდეს შემდეგ სიმბოლოებს: \\/?%*:|\"<>", 1);

                $newPath = $path.'/'.$name;
                // check if there is file on this path and if it's directory
                if (file_exists($newPath) && is_dir($newPath)) {
                    throw new Exception("ამ სახელით ფოლდერი უკვე არსებობს", 1);
                } else {
                    if (!mkdir($newPath)) {
                        throw new Exception("შეცდომა ფოლდერის დამატებისას", 1);
                    }
                }
            } else {
                throw new Exception("არასწორი პარამეტრების გამო ფოლდერის დამატება ვერ მოხერხდა", 1);
            }
            
            $this->output->set_content_type('application/json')->set_output(json_encode(array('success' => true )));
        } catch (Exception $ex) {
            $this->output->set_content_type('application/json')->set_output(json_encode(array('msg' => $ex->getMessage(), 'success' => false)));
        }
    }

    
    // upload file or several files on passed path place
    public function upload_files() {
        try{
            $path = $this->input->post('path');

            // not null path parameter
            if ($path) {
                $path = realpath($path);

                // incorrect path
                if (!$path)
                    throw new Exception("გადმოცემული მშობელი ფოლდერი არ არსებობს", 1);

                $root = FCPATH.'assets/uploads';
                // outside of a root folder
                if (strpos($path, $root) === false)
                    throw new Exception("თქვენ არ გაქვთ ამის უფლება", 1);

                $uploadPath = str_replace(FCPATH, '', $path);
            
                $config['upload_path'] = $uploadPath;
                $config['allowed_types'] = 'gif|jpg|png|pdf';
                $config['overwrite'] = false;
                
                $file_data = $_FILES['files'];
                
                $this->load->library('upload', $config);
                if ($this->upload->do_multi_upload('files')) {
                    $this->output->set_content_type('application/json')->set_output(json_encode(array('success' => true )));
                } else {
                    throw new Exception($this->System_Message_model->get_system_error_msg(SYSTEM_MESSAGE_TYPE_FILE_UPLOAD_ERROR));
                }
            } else {
                throw new Exception("მეთოდს არ გადმოეცა მშობელი ფოლდერის მდებარეობა", 1);
            }
        } catch (Exception $ex) {
            $this->output->set_content_type('application/json')->set_output(json_encode(array('msg' => $ex->getMessage(), 'success' => false)));
        }
    }

    
    // delete folder and all files inside
    public function delete_folder() {
        try{
            $path = $this->input->post('path');

            // check if path is passed
            if ($path) {
                $path = realpath($path);

                // incorrect path
                if (!$path)
                    throw new Exception("გადმოცემულ მისამართზე ფაილი არ არსებობს", 1);

                $root = FCPATH.'assets/uploads';
                // outside of a root folder
                if (strpos($path, $root) === false)
                    throw new Exception("თქვენ არ გაქვთ ამის უფლება", 1);

                // folder is in black list
                if (array_key_exists($path, $this->folder_black_list))
                    throw new Exception("ამ ფოლდერის წაშლა არ შეიძლება", 1);

                // there is no folder with same name and path
                if (file_exists($path) && is_dir($path)) {
                    // remove folder recursively
                    if (!$this->removeDir($path)) {
                        throw new Exception($this->System_Message_model->get_system_error_msg(SYSTEM_MESSAGE_TYPE_FILE_NOT_FOUND));
                    }
                } else {
                    throw new Exception($this->System_Message_model->get_system_error_msg(SYSTEM_MESSAGE_TYPE_FILE_NOT_FOUND));
                }
                
                $this->output->set_content_type('application/json')->set_output(json_encode(array('success' => true )));
            } else {
                throw new Exception("მეთოდს არ გადმოეცა ფოლდერის მდებარეობა", 1);
            }
        } catch (Exception $ex) {
            $this->output->set_content_type('application/json')->set_output(json_encode(array('msg' => $ex->getMessage(), 'success' => false)));
        }
    }



    public function delete_file() {
        try{
            $path = $this->input->post('path');

            // check if path is passed
            if ($path) {
                $path = realpath($path);

                // incorrect path
                if (!$path)
                    throw new Exception("გადმოცემულ მისამართზე ფაილი არ არსებობს", 1);

                $root = FCPATH.'assets/uploads';
                // outside of a root folder
                if (strpos($path, $root) === false)
                    throw new Exception("თქვენ არ გაქვთ ამის უფლება", 1);

                // file exists and isn't directory
                if (file_exists($path) && !is_dir($path)) {
                    if (!unlink($path)) {
                        throw new Exception($this->System_Message_model->get_system_error_msg(SYSTEM_MESSAGE_TYPE_FILE_NOT_FOUND));
                    }
                } else {
                    throw new Exception($this->System_Message_model->get_system_error_msg(SYSTEM_MESSAGE_TYPE_FILE_NOT_FOUND));
                }
            } else {
                throw new Exception("მეთოდს არ გადმოეცა ფაილის მდებარეობა", 1);
            }
            
            $this->output->set_content_type('application/json')->set_output(json_encode(array('success' => true )));
        } catch (Exception $ex) {
            $this->output->set_content_type('application/json')->set_output(json_encode(array('msg' => $ex->getMessage(), 'success' => false)));
        }
    }


    // view selected file
    public function view_file() {
        $path = $this->input->post('path');

        if ($path) {
            $path = realpath($path);
            $result = str_replace(FCPATH, base_url(), $path);
            $result = str_replace('/', '\\', $result);

            $this->output->set_content_type('application/json')->set_output(json_encode(array('success' => true, 'url' => $result)));
        } else {
            $this->output->set_content_type('application/json')->set_output(json_encode(array('msg' => 'დაფიქსირდა შეცდომა', 'success' => false)));
        }
        
    }



    /*         PRIVATE FUNCTIONS
    <---------------------------------------->
    <---------------------------------------->
    <---------------------------------------->
    <---------------------------------------->
    <---------------------------------------->
    */

    // we can return these variables with nodes too
    // 'checked' => false,
    // 'cls' => classname,
    // 'iconCls' => icon class,
    // 'icon' => icon,
    private function getChildren($parent, $name) {
        $path = $parent.'/'.$name;
        $id = $this->id++;

        if (!is_dir($path)) {
            $info = pathinfo($path);
            $icon = '';

            if (isset($info['extension'])) {
                $ext = $info['extension'];

                if (file_exists(FCPATH.'/assets/images/icons/file/'.$ext.'.png')) {
                    $icon = '/assets/images/icons/file/'.$ext.'.png';
                } else {
                    $icon = '/assets/images/icons/file/blank.png';
                }
                
            }

            return [
                'id' => $id,
                'path' => realpath($path),
                'isdir' => false,
                'isroot' => false,
                'icon' => $icon,
                'cls' => 'tree-item',
                'iconCls' => 'tree-icon',
                'name' => $name,
                'leaf' => true
            ];
        }

        $scan = scandir($path);
        $children = array();

        foreach ($scan as $child) {
            if ($child == '.' || $child == '..') continue;
            array_push($children, $this->getChildren($path, $child));
        }

        return [
            'id' => $id,
            'path' => realpath($path),
            'isdir' => true,
            'isroot' => false,
            'cls' => 'tree-item',
            'iconCls' => 'tree-icon',
            'name' => $name,
            'expanded' => false,
            'children' => $children
        ];

    }


    // Function removes all files in directory
    private function removeDir($path) {
        if (is_dir($path) === true) {
            $files = array_diff(scandir($path), array('.', '..'));
            foreach ($files as $file) {
                $this->removeDir(realpath($path) . '/' . $file);
            }
            return rmdir($path);
        } else if (is_file($path) === true) {
            return unlink($path);
        }

        return false;
    }
    
}