<?php 
    require_once 'models/Producto.php';
    require_once 'models/Categoria.php';

    class ProductosController{
       
        /**
         * 
         */
        public static function index(){
            if(isset($_SESSION['identity']) && isset($_SESSION['admin'])){
                $producto = new Producto();
                //$categoria = new Categoria();
                echo $GLOBALS["twig"]->render('productos/index.twig', 
                    [
                        // 'imagen' => $producto->findImagen(),
                        'productos' => $producto->findCategotiasAll(),
                        //'categorias' => $categoria->findAll(),
                        'identity' => $_SESSION['identity'],
                        'URL' => URL
                    ]
                );
            }else{
                //echo $_SESSION['admin'];
                header('Location: '.URL.'?controller=auth&action=login');
            }
        }

        /**
         * 
         */
        public static function create(){
            if(isset($_SESSION['identity'])){
                $categoria = new Categoria();
                echo $GLOBALS["twig"]->render(
                    'productos/create.twig',
                    [
                       // 'categorias' => $categoria->findAll(),
                        'identity' => $_SESSION['identity'],
                        'URL' => URL
                    ]
                );
            }else{
                header('Location: '.URL.'?controller=auth&action=login');
            }
        }

        /**
         * 
         */
        public static function show(){
            if(isset($_SESSION['identity'])){
                $producto = new Producto();
                //$categoria = new Categoria();
                $producto->setId($_GET['id']);
                echo $GLOBALS["twig"]->render(
                    'productos/show.twig', 
                    [
                        'producto' => $producto->findCategotiasId(),
                        //'categorias' => $categoria->findAll(),
                        'identity' => $_SESSION['identity'],
                        'URL' => URL
                    ]
                );
            }else{
                header('Location: '.URL.'?controller=auth&action=login');
            }
        }

        /**
         * 
         */
        public static function edit(){
            if(isset($_SESSION['identity'])){
                $producto = new Producto();
                //$categoria = new Categoria();
                $producto->setId($_GET['id']);
                echo $GLOBALS["twig"]->render(
                    'productos/edit.twig', 
                    [
                        'producto' => $producto->findCategotiasId(),
                        //'categorias' => $categoria->findAll(),
                        'identity' => $_SESSION['identity'],
                        'URL' => URL
                    ]
                );
            }else{
                header('Location: '.URL.'?controller=auth&action=login');
            }
        }

        /**
         * 
         */
        public static function save(){
            if(isset($_SESSION['identity'])){
                $producto = new Producto();
                $producto->setCategoria($_POST['categoria']);
                $producto->setNombre($_POST['nombre']);
                $producto->setDescripcion($_POST['descripcion']);
                $producto->setPrecio(str_replace(",",".",$_POST['precio']));
                $producto->setStock($_POST['stock']);

                        if (isset($_FILES['image']['name'])) {
                            $tipoArchivo = $_FILES['image']['type'];
                            $permitido=array("image/png","image/jpeg");
                            
                            if( in_array($tipoArchivo,$permitido) ==false ){
                                die("Archivo no permitido");
                            }
                            $nombreArchivo = $_FILES['image']['name'];
                            $tamanoArchivo = $_FILES['image']['size'];
                            $imagenSubida = fopen($_FILES['image']['tmp_name'], 'r');
                            $binariosImagen = fread($imagenSubida, $tamanoArchivo);

                            $producto->setNombreImagen($nombreArchivo);
                            $producto->setImagen($binariosImagen);
                            $producto->setTipo($tipoArchivo);
                            $producto->setTamaño($tamanoArchivo);


                }

                $producto->save();
                header('Location: '.URL.'?controller=productos&action=index');
            }else{
                header('Location: '.URL.'?controller=auth&action=login');
            }
        }

        /**
         * 
         */
        public static function update(){
            if(isset($_SESSION['identity'])){
                $producto = new Producto();
                $producto->setId($_POST['id']);
                $producto->setCategoria($_POST['categoria']);
                $producto->setNombre($_POST['nombre']);
                $producto->setDescripcion($_POST['descripcion']);
                $producto->setPrecio(str_replace(",",".",$_POST['precio']));
                $producto->setStock($_POST['stock']);
                $producto->setIdImagen($_POST['id_imagenes']);

                //$producto->setCategoria($_POST['categoria']);
                $producto->update();
                header('Location: '.URL.'?controller=productos&action=index');
            }else{
                header('Location: '.URL.'?controller=auth&action=login');
            }
        }
        /**
         * 
         */
        public static function delete(){
            if(isset($_SESSION['identity'])){
                $producto = new Producto();
                $producto->setId($_GET['id']);
                $producto->delete();
                header('Location: '.URL.'?controller=productos&action=index');
            }else{
                header('Location: '.URL.'?controller=auth&action=login');
            }
        }
    }
?>