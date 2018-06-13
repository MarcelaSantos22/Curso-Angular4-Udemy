<?php
require_once 'vendor/autoload.php';


$app = new \Slim\Slim();

// Conexion a la BD
$db = new mysqli('localhost','root','root','curso_angular4');

if($db->connect_error){
    die("error de conexion");
}

if($db->set_charset("UTF8") == false){
    die("no se pudo codificar a utf8");
}

// Configuracion de cabeceras
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Allow: GET, POST, OPTIONS, PUT, DELETE");
$method = $_SERVER['REQUEST_METHOD'];
if($method == "OPTIONS") {
    die();
}

// get(): Para crear nuevas rutas
// use(): permite usar dentro de function variables que hay por fuera
$app -> get('/pruebas',function() use($app, $db){ 
    echo 'Hola mundo desde Slim PHP ';
    var_dump($db);

});

// Metodo para guardar los productos
$app -> post('/productos', function() use($app, $db){ 
    $json = $app->request->post('json'); // Se envia una variable json por post
    $data = json_decode($json, true);
    
    if (!isset($data['nombre'])) {
            $data['nombre']= null;
        }
    if (!isset($data['imagen'])) {
        $data['imagen']= null;
    }
    if (!isset($data['description'])) {
        $data['description']= null;
    }
    if (!isset($data['precio'])) {
        $data['precio']= null;
    }

    $query = "INSERT INTO productos VALUES(NULL,".
               "'{$data['nombre']}',".
               "'{$data['description']}',".
               "'{$data['precio']}',".
               "'{$data['imagen']}'".
               ");";

    $insert = $db->query($query);

    $result = array(
            'status'    =>  'error',
            'code'      =>  404,
            'message'   =>  'Producto NO se ha creado correctamente'
    );

    if ($insert) {
        $result = array(
            'status'    =>  'success',
            'code'      =>  200,
            'message'   =>  'Producto creado correctamente'
        );
    };

    echo json_encode($result);

    var_dump($query);
});

// Metodo para listar todos los productos
$app -> get('/productos', function() use($db, $app){
    $sql = 'SELECT * FROM productos ORDER BY id DESC;';
    $query = $db->query($sql);

    //var_dump($query->fetch_all()); // Para devolver un array con todos los productos de la tabla

    $productos = array();
    while ($producto = $query->fetch_assoc()) {
        $productos[] = $producto;
    }

   $result = array(
            'status'    =>  'success',
            'code'      =>  200,
            'data'   =>  $productos
        );

        echo json_encode($result);
});

// Metodo para devolver un producto
$app -> get('/producto/:id', function($id) use($db, $app){
    $sql = 'SELECT * FROM productos WHERE id = '.$id;
    $query = $db -> query($sql);
    $result = array(
            'status'    =>  'error',
            'code'      =>  404,
            'message'   =>  'Producto no disponible'
        );

    if ($query -> num_rows == 1) {
        $producto = $query -> fetch_assoc();
        $result = array(
            'status'    =>  'success',
            'code'      =>  200,
            'data'      =>  $producto
        );
    }

    echo json_encode($result);
});

// Metodo para eliminar un producto
$app -> get('/delete-producto/:id', function($id) use($db, $app){
    $sql = 'DELETE FROM productos WHERE id = '.$id;
    $query = $db -> query($sql);

    if ($query) {
        $result = array(
            'status'    =>  'success',
            'code'      =>  200,
            'message'   =>  'El producto se ha eliminado correctamente'
        );
    }else{
         $result = array(
            'status'    =>  'error',
            'code'      =>  404,
            'message'   =>  'El producto NO se ha eliminado!!'
        );
    }

    echo json_encode($result);
});

// Metodo para actualizar un producto
$app -> post('/update-producto/:id', function($id) use($app, $db){ 
    $json = $app->request->post('json');
    $data = json_decode($json,true);

    $sql = "UPDATE productos SET ".
            "nombre = '{$data['nombre']}',".
            "description = '{$data['description']}',";

    if (isset($data['imagen'])) {
       $sql .= "imagen = '{$data['imagen']}',"; // .= es para concatenar la sentencia
    }

    $sql .= "precio = '{$data['precio']}' WHERE id = {$id}";
    $query = $db->query($sql);

   if ($query) {
        $result = array(
            'status'    =>  'success',
            'code'      =>  200,
            'message'   =>  'El producto se ha actualizado correctamente'
        );
    }else{
         $result = array(
            'status'    =>  'error',
            'code'      =>  404,
            'message'   =>  'El producto NO se ha actualizado!!'
        );
    }

    echo json_encode($result);
});

// Metodo para subir una imagen a un producto
$app -> post('/upload-file', function() use($de, $app){
    $result = array(
            'status'    =>  'error',
            'code'      =>  404,
            'message'   =>  'El archivo NO se pudo subir!!'
        );

        if (isset($_FILES['uploads'])) {
           $piramideUploader = new PiramideUploader();

           $upload = $piramideUploader -> upload('image','uploads','uploads',array('image/jpeg','image/png', 'image/gif'));
           $file = $piramideUploader -> getInfoFile();
           $file_name = $file['complete_name'];

           if (isset($upload) && $upload['uploaded']=== false) {
              $result = array(
                'status'    =>  'error',
                'code'      =>  404,
                'message'   =>  'El archivo NO se pudo subir!!'
                );
           }else {
               $result = array(
                    'status'    =>  'success',
                    'code'      =>  200,
                    'message'   =>  'El archivo se ha subido correctamente',
                    'filename'  => $file_name
                );
           }
        };

        echo json_encode($result);
});

// run(): Para correr Slim
$app -> run();