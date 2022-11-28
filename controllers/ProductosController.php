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
                // if(isset($_POST["image"])){
                //     $check = getimagesize($_FILES["image"]["tmp_name"]);
                //     if($check !== false){
                //         $image = $_FILES['image']['tmp_name'];
                //         $imgContenido = addslashes(file_get_contents($image));
                //         $producto->setImage($imgContenido);
                //     }
                // }
                //$producto->setCategoria($_POST['categoria']);

                if (isset($_FILES['img'])) {
                    $nombreImg = $_FILES['img']['name'];
                    $ruta      = $_FILES['img']['tmp_name'];
                    $destino   = "/blog/" . $nombreImg;
                    
                    // if (move_uploaded_file($ruta, $destino)){
                    //     $sql = "INSERT INTO 'bd'(nombre,ruta) VALUES ('$nombreImg','$destino')";
                    //     $res = mysqli_query($cn, $sql);
                    //     if ($res) {
                    //         echo '<script type="text/javascript"> alert("Agregado Correctamente"); window.location="index.php";</script>';
                    //     } else {
                    //         die("Error" . mysqli_error($cn));
                    //     }
                    // }
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