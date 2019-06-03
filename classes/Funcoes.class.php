<?php

define("TITULO", 'Gerenciador de dados de pacientes');
define("ROOT", 'ControlePacientes');

class Funcoes {

    /**
     * 
     * @param type $senha
     * @return type
     */
    public function encript_senha($senha) {
        return md5($senha);
    }

    /**
     * 
     * @param type $param
     * @param type $id
     * @return string|int
     */
    public function listarSexo($param, $id = '') {

        $arrayDados = array(
            0 => 'Selecione...',
            1 => 'Feminino',
            2 => 'Masculino',
            3 => 'Não identificado'
        );
        switch ($param) {
            case '1':
                return $arrayDados[$id];
                break;

            case '2':
                return $arrayDados;
                break;

            default:
                return 0;
                break;
        }
    }

    /**
     * 
     * @param type $param 1 retorna string, 2 retorna array
     * @param type $id se o primeiro parametro receber 1, este é obrigatório
     * @return int
     */
    public function tipoUsuario($param, $id = "") {

        $arrayDados = array(
            "Selecione...",
            "Admin",
            "Paciente"
        );
        switch ($param) {
            case '1':
                return $arrayDados[$id];
                break;

            case '2':
                return $arrayDados;
                break;

            default:
                return 0;
                break;
        }
    }

    /**
     * 
     * @param type $vlr
     * 1 :utf8_decode
     * 2 :utf8_encode
     * 3 :htmlentities($vlr, ENT_QUOTES, "ISO-8859-1")
     * @param type $tipo
     * @return type
     */
    public function tratarCaracter($vlr, $tipo) {
        switch ($tipo) {
            case 1: $rst = utf8_decode($vlr);
                break;
            case 2: $rst = utf8_encode($vlr);
                break;
            case 3: $rst = htmlentities($vlr, ENT_QUOTES, "ISO-8859-1");
                break;
        }
        return $rst;
    }

    public function dataAtual($tipo) {
        switch ($tipo) {
            case 1: $rst = date("Y-m-d");
                break;
            case 2: $rst = date("Y-m-d H:i:s");
                break;
            case 3: $rst = date("d/m/Y");
                break;
        }
        return $rst;
    }

    public function base64($vlr, $tipo) {
        switch ($tipo) {
            case 1: $rst = base64_encode($vlr);
                break;
            case 2: $rst = base64_decode($vlr);
                break;
        }
        return $rst;
    }

    /**
     * Funcao responsavel por verificar se esta logado, caso contrario retorna para a pagina de login
     * @return type
     */
    public function isLogado() {

        if (!isset($_SESSION['logado']) || $_SESSION['logado'] == false) {
            header('location: /ControlePacientes/login.php');
        }
        return ($_SESSION['logado']);
    }

    /**
     * 
     * @return type
     */
    public function isAdmin() {
        return ($_SESSION['tipoUsuario'] == 1 ? TRUE : FALSE);
    }

}

?>