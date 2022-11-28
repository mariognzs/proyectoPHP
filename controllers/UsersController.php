<?php 
    require_once 'models/User.php';

    class UsersController{
       
        /**
         * 
         */
        public static function index(){
            if(isset($_SESSION['identity']) && isset($_SESSION['admin'])){
                $user = new User();
                echo $GLOBALS["twig"]->render(
                    'users/index.twig', 
                    [
                        'users' => $user->findAllRol(),
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
        public static function create(){
            if(isset($_SESSION['identity']) && isset($_SESSION['admin'])){
                echo $GLOBALS["twig"]->render(
                    'users/create.twig',
                    [
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
            if(isset($_SESSION['identity']) && isset($_SESSION['admin'])){
                $user = new User();
                $user->setId($_GET['id']);
                echo $GLOBALS["twig"]->render(
                    'users/show.twig', 
                    [
                        'user' => $user->findIdRol(),
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
            if(isset($_SESSION['identity']) && isset($_SESSION['admin'])){
                $user = new User();
                $user->setId($_GET['id']);
                echo $GLOBALS["twig"]->render(
                    'users/edit.twig', 
                    [
                        'user' => $user->findIdRol(),
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
            if(isset($_SESSION['identity']) && isset($_SESSION['admin'])){
                $user = new User();
                $user->setNombre($_POST['nombre']);
                $user->setApellidos($_POST['apellidos']);
                $user->setEmail($_POST['email']);
                $user->setRol($_POST['rol']);
                if(isset($_POST['password'])){
                    $user->setPassword(password_hash($_POST['password'], PASSWORD_BCRYPT, ['cont' => 4]));
                }
                $user->save();
                header('Location: '.URL.'?controller=users&action=index');
            }else{
                header('Location: '.URL.'?controller=auth&action=login');
            }
        }

        /**
         * 
         */
        public static function update(){
            if(isset($_SESSION['identity'])){
                $user = new User();
                $user->setId($_POST['id']);
                $user->setNombre($_POST['nombre']);
                $user->setApellidos($_POST['apellidos']);
                $user->setEmail($_POST['email']);
                $user->setRol($_POST['rol']);
                if(isset($_POST['password'])){
                    $user->setPassword(password_hash($_POST['password'], PASSWORD_BCRYPT, ['cont' => 4]));
                }
                $user->update();
                header('Location: '.URL.'?controller=users&action=index');
            }else{
                header('Location: '.URL.'?controller=auth&action=login');
            }
        }
        /**
         * 
         */
        public static function delete(){
            if(isset($_SESSION['identity'])){
                $user = new User();
                $user->setId($_GET['id']);
                $user->delete();
                header('Location: '.URL.'?controller=users&action=index');
            }else{
                header('Location: '.URL.'?controller=auth&action=login');
            }
        }
    }
?>