<?php
    /**
     * El API de Twig me obliga a colocar estas lineas para utilizar el motor de plantillas
     */ 

     /**
      * require_once -> igual que require pero comprueba antes si ya esta incluido para no incluirlo otra vez
      * require -> si no encuentra, da excepcion
      * include -> si no encuentra, aparece warning y continua ejecucion
      */
  
    // Carga el fichero autoload.php
    require_once 'config/Parameters.php';
    require_once 'vendor/autoload.php';
    include 'controllers/UsersController.php';
    include 'controllers/AuthController.php';
    include 'controllers/IndexController.php';
    include 'controllers/ErrorController.php';
    include 'controllers/ProductosController.php';
    include 'controllers/CategoriasController.php';
    include 'controllers/CarritoController.php';
    include 'controllers/PedidosController.php';
    // include 'controllers/PerfilController.php';
    
    session_start();
    
    // Ubicacion de mis plantillas de Twig
    $loader = new \Twig\Loader\FilesystemLoader('templates');
    $twig = new \Twig\Environment($loader);
    /**
     * $GLOBALS almacena variables para estar accesibles en todo mi documento.
     * Esto lo utilizamos desde los controladores para llamar a las vistas
     */

    /**
     * CONTROLADOR FRONTAL
     * Se encarga de cargar un fichero, una accion u otra funcion que llegue por URL.
     * 
     * Pasos:
     * 1. Comprobar el controller por URL
     * 2. Transformar el controller al formato que utilizamos.
     * 3. Comprobar si existe una clase con ese nombre de controller.
     * 4. Una vez tenemos controller nos centramos en la accion.
     * 5. Comprobamos la accion por URL.
     * 6. Si la accion existe dentro del controlador, la realizamos.
     * 7. Si no existe la accion, error.
     */

    /**
     * Primero compruebo que controlador voy a cargar por URL
     */
     /**
      * Tengo que comprobar si $controller tiene algo
      */
      if(isset($_GET['controller'])){
        $controller = ucfirst($_GET['controller']).'Controller'; // UsersController

        /**
         * Una vez he recogido el controlador por URL y lo tengo trasnformado a mi formato
         * Comprobar que existe una clase con ese nombre.
         */
        if(class_exists($controller)){
          /**
           * Creo un objeto de la clase $controller y procedo a comprobar el metodo de la URL
           */
          $controller_object = new $controller();
          if(isset($_GET['action'])){
            /**
             * Recoger la accion de mi controlador y guardarla en una variable
             */
            $action = $_GET['action'];
            $controller_object->$action();
        }
        }else{
          /**
           * Error de que no en cuentra la clase o no existe.
           * Lanzar el error 404
           * CAMBIAR CABECERA
           */
          ErrorController::_404();
        }
      }else{
        //Mi accion por defecto el lanzar mi index.twig como página de caida
        // IndexController::index();

        /**
         * Si no existe un controller en mi URL, recojo el controller por defecto
         * Si no existe un action en mi URL, recojo el action por defecto
         */
        $controller_default = controller_default;
        $action_default = action_default;
        $controller = new $controller_default();
        $controller::$action_default();

        /**
         * Si no existe el parametro controller en la URL tengo que hacer algo.
         * Enviar un error
         * Redirigir a alguna vista.
         * 
         * ¿Numero de error que deberia enviar? ¿3XX? ¿4XX? 
         * 
         * ¿Enviar a un controlador por defecto?
         */
      }
?>