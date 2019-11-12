<?php

require_once 'classes/Funcoes.class.php';
require_once 'classes/Usuario.class.php';


$func = new Funcoes();
$func->isLogado();

include './listarPessoas.php';

if ($func->isAdmin())
{
    include './listarUsuarios.php';
}