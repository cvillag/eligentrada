<?php 
$data = array();

if(isset($_REQUEST['files']))
{  
    $error = false;

    $uploaddir = './uploads/';
    foreach($_FILES as $file)
    {
        $extension = pathinfo($file['name'],PATHINFO_EXTENSION);
        $filename = $uploaddir.sha1(basename($file['name']).rand(0, 1000000)).".".$extension;

        if($extension != "jpg" && $extension != "png" && $extension != "jpeg"){
            $data = array('error' => 'Solo se permiten archivos jpg, jpeg y png.');
        }else if ($file["size"] > 500000){
            $data = array('error' => 'Tamaño de archivo demasiado grande, máximo 500kB');
        }else if (getimagesize($file['tmp_name']) == false){
            $data = array('error' => 'Solo se permite la subida de imágenes');
        }else if (!move_uploaded_file($file['tmp_name'], $filename)){
            $data = array('error' => 'There was an error uploading your files');
        }else {
            $data = array('filename' => $filename);
        }
    }
}

echo json_encode($data);
?>