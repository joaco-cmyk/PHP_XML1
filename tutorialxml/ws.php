<?php
require_once __DIR__ . '/com/clsUser.php';
require_once __DIR__ . '/com/utils/clsServerParams.php';

$sp= new clsServerParams();
$user= new clsUser();

switch ($action) {
    case 'register':
        $user->setDni($sp->get('dni'));
        $user->setName($sp->get('name'));
        $user->setLast_name($sp->get('lastname'));
        $user->setPassword($sp->get('password'));
        $user->setAge($sp->get('age'));
        $user->Register();
        break;
    case 'login':
        $user->setDni($sp->get('dni'));
        $user->setPassword($sp->get('password'));
        $user->Login();
    break;

    default:
        # code...
        break;
}






?>