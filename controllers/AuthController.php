<?php 

    class AuthController{
        /**
         * Funcion que redirige a la vista del login
         */
        public function login(){
            echo $GLOBALS['twig']->render('auth/login.twig');
        }

        /**
         * Funcion que redirige a la vista del home
         */
        public function home(){
            if(isset($_SESSION['identity'])){
                echo $GLOBALS['twig']->render('home.twig');
            }else{
                header('Location: http://localhost/DEWS_VS/?controller=auth&action=login');
            }
        }

        /**
         * Funcion que cierra la sesion siempre y cuando encuentre un $_SESSION['identity]
         */
        public function logout(){
            if(isset($_SESSION['identity'])){
                unset($_SESSION['identity']);
            }
            header('Location: http://localhost/DEWS_VS/?controller=auth&action=login');
        }

        public function doLogin(){
            /**
             * Recojo email y password de mi formulario de login
             * - Verificar si el email y el password coinciden con el de mi base de datos
             * - Debo tener en cuenta que mi password está encriptado. ¿Metodo?
             * - Utilizo el modelo User para lanzar el metodo que comprueba si he introducido los datos correctamente.
             * 
             */

            $user = new User();
            $user->setEmail($_POST['email']);
            $user->setPassword($_POST['password']);
            $user_ok = $user->login(); // objeto usuario si correcto o false si no correcto

            /**
             * Almaceno en $user_ok el resultado de mi metodo login()
             * 
             * Compruebo si $user_ok es un objeto (este es caso true)
             * entonces almaceno el objeto $user_ok en mi $_SESSION con el
             * nombre 'identity'
             */

             if($user_ok && is_object($user_ok)){
                $_SESSION['identity'] = $user_ok;
                header('Location: http://localhost/DEWS_VS/?controller=auth&action=home');
             }else{
                header('Location: http://localhost/DEWS_VS/?controller=auth&action=login');
             }
        }
    }
?>