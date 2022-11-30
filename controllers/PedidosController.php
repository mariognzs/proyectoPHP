<?php 
    require_once 'models/Pedido.php';
    require_once 'models/Pedidos_has_productos.php';

    class PedidosController{
       
        public static function index(){
            if(isset($_SESSION['identity']) && isset($_SESSION['admin']) ){ 
                 $pedido = new Pedido();
                // var_dump($pedido->findAll());
                // exit();
                echo $GLOBALS['twig']->render('pedidos/index.twig', 
                    [
                        'pedidos' => $pedido->findProductAll(),
                        'identity' => $_SESSION['identity'],
                        'URL' => URL
                    ]
                );
            }else{
                echo "NO VA";
            }
        }

        public static function show(){
            if(isset($_SESSION['identity']) && isset($_SESSION['admin'])){
               
                echo $GLOBALS['twig']->render('pedidos/show.twig', 
                    [
                        'identity' => $_SESSION['identity'],
                        'URL' => URL
                    ]
                );
            }
        }


        public static function save(){
            $pedido = new Pedido();
            $pedido->setUsuario($_SESSION['identity']->id);

            foreach($_SESSION['carrito'][$_SESSION['identity']->id] as $indice => $elemento){

            $pedido->setId($_SESSION['carrito'][$_SESSION['identity']->id][$indice]['producto_id']);
            $pedido->setUnidades($_SESSION['carrito'][$_SESSION['identity']->id][$indice]['cantidad']);
            $pedido->setPrecioPedido($_SESSION['carrito'][$_SESSION['identity']->id][$indice]['precio']);

            $pedido_id = $pedido->save();

            }

            CarritoController::deleteAll();

            // $_SESSION['carrito'][$_SESSION['identity']->id][];

        }

        /**
         * Funcion que crea un pedido nuevo con los elementos del carrito
         */
        public static function savee(){
            if(isset($_SESSION['carrito'][$_SESSION['identity']->id]) && isset($_SESSION['identity']) && !isset($_SESSION['admin'])){
                /**
                 * 1. Crear un nuevo pedido
                 * 2. Recojo el id del pedido que acabo de crear para usarlo en mi tabla pedidos_has_productos
                 * 3. Insertar todos los elementos del carrito en la tabla pedidos_has_producto. 
                 * El unico elemento que me faltaba para realizar este punto 3 es el id del pedido, que lo tengo con la insercion anterior.
                 * 4. Eliminar elementos del carrito
                 */

                 // Paso 1 y paso 2
                $pedido = new Pedido();
                $pedido->setUsuario($_SESSION['identity']->id);
                


                $pedido_id = $pedido->save();

                // Paso 3
                foreach($_SESSION['carrito'][$_SESSION['identity']->id] as $indice => $elemento){
                    /**
                     * Creo tantas inserciones como sean necesarias en pedidos_has_productos con el producto_id del pedido anterior
                     */
                    // $pedidos_has_productos = new Pedidos_has_productos();
                    // $pedidos_has_productos->setPedido($pedido_id);
                    // $pedidos_has_productos->setProducto($_SESSION['carrito'][$_SESSION['identity']->id][$indice]['producto_id']);
                    // $pedidos_has_productos->setUnidades($_SESSION['carrito'][$_SESSION['identity']->id][$indice]['cantidad']);
                    // $pedidos_has_productos->setPrecio($_SESSION['carrito'][$_SESSION['identity']->id][$indice]['precio']);
                    // $pedidos_has_productos->save();

                    /**
                     * Reduzco la cantidad de los productos seleccionados
                     */
                    $producto = new Producto();
                    $pedido = new Pedido();
                    $pedido->setUsuario($_SESSION['identity']->id);
                    $pedido->setId($_SESSION['carrito'][$_SESSION['identity']->id][$indice]['producto_id']);
                    $pedido->setUnidades($_SESSION['carrito'][$_SESSION['identity']->id][$indice]['unidades']);
                    $pedido->setPrecioPedido($_SESSION['carrito'][$_SESSION['identity']->id][$indice]['precioPedido']);
                    $producto->setId($_SESSION['carrito'][$_SESSION['identity']->id][$indice]['producto_id']);
                    $producto->setStock($_SESSION['carrito'][$_SESSION['identity']->id][$indice]['cantidad']);
                    $producto->updateByCantidad();
                }
                

                // Paso 4: eliminar los productos del carrito y redireccionar al carrito ya vacio
                CarritoController::deleteAll();
            }else{
                header('Location: '.URL.'?controller=auth&action=login');
            }
        }

        
        /**
         * 
         */


        public static function delete(){
            if(isset($_SESSION['identity']) && isset($_SESSION['admin'])){
                $pedido = new Pedido();
                $pedido->setId($_GET['id']);
                // var_dump($_GET['id']);
                // exit();
                $pedido->delete();
                header('Location: '.URL.'?controller=pedidos&action=index');
            }else{
                header('Location: '.URL.'?controller=auth&action=login');
            }
        }
    }
?>