<?php

class CarritoController
{


    public static function index()
    {
        if (isset($_SESSION['identity']) && !isset($_SESSION['admin'])) {
            // var_dump($_SESSION['carrito']);
            // exit();
            if(isset($_SESSION['carrito'][$_SESSION['identity']->id]) != null){

                echo $GLOBALS['twig']->render(
                    'carrito/index.twig',
                    [
                        'carrito' => $_SESSION['carrito'][$_SESSION['identity']->id],
                        'identity' => $_SESSION['identity'],
                        'URL' => URL
                    ]
                );

            }else{
                echo $GLOBALS['twig']->render(
                    'carrito/index.twig',
                    [
                        'vacio' => "El carrito esta vacio",
                        'identity' => $_SESSION['identity'],
                        'URL' => URL
                    ]
                );
            }
           
        }
    }

    /**
     * Funcion es la que agrega un elemento a mi $_SESSION['carrito']
     */

    public static function agregar()
    {
        if (isset($_SESSION['identity']) && !isset($_SESSION['admin'])) {
            /**
             * Primero recojo el id del producto que selecciono
             */
            $id = $_GET['id'];

            /**
             * Recojo el precio del producto seleccionado
             * Ir a la base de datos, ver que producto he seleccionado(id)
             * Recoger el precio del objeto retornado
             */
            $producto = new Producto();
            $producto->setId($id);
            $product = $producto->findById();

            /**
             * Ahora tengo el producto_id, precio
             * Me falta la cantidad (ponemos 1 por poner algo)
             */

            /**

             * Comprueba si existe el elemento en el carrito

             */

            $contador = 0;

            foreach ($_SESSION['carrito'][$_SESSION['identity']->id] as $indice => $elemento) {

                if ($elemento['producto_id'] == $product->id) {

                    $_SESSION['carrito'][$_SESSION['identity']->id][$indice]['cantidad']++;

                    $contador++;
                }
            }



            /**

             * Si no existe, introduce uno nuevo

             */

            if (!isset($contador) || $contador == 0) {

                $_SESSION['carrito'][$_SESSION['identity']->id][] = array(

                    "producto_id" => $product->id,

                    "producto" => $product->nombre,

                    "precio" => $product->precio,

                    "cantidad" => 1

                );
            }


            /**
             * Mi $_SESSION['carrito] contiene un array con los valores seleccionados
             */
            // $_SESSION['carrito'][$_SESSION['identity']->id][] = array(
            //     "producto_id" => $id,
            //     "precio" => $precio,
            //     "cantidad" => $cantidad
            // );

            header('Location: ' . URL . '?controller=carrito&action=index');
        } else {
            header('Location: ' . URL . '?controller=auth&action=login');
        }
    }

    public static function deleteAll()
    {
        if (isset($_SESSION['identity']) && !isset($_SESSION['admin'])) {
            if (isset($_SESSION['carrito'][$_SESSION['identity']->id])) {
                unset($_SESSION['carrito'][$_SESSION['identity']->id]);

            }
        }
        header('Location: ' . URL . '?controller=carrito&action=index');
    }

    public static function update()
    {
        if (isset($_SESSION['identity']) && isset($_SESSION['carrito'][$_SESSION['identity']->id]) && !isset($_SESSION['admin'])) {
        }
        header('Location: ' . URL . '?controller=carrito&action=index');
    }
}
