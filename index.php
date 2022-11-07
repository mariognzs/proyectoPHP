<?php

require_once 'vendor/autoload.php';

$loader = new \Twig\Loader\FilesystemLoader('templates');
$twig = new \Twig\Environment($loader);

//echo $twig->render('plantilla.twig');

echo $twig->render('users/index.twig',
[
    'mensaje' => 'MENSAJE',
    'alumno' => 'DANIEL',
    'dia' => ['lunes','martes']
]
);


?>  