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

    /**
     * 
     * @param type $val
     * @param type $mask
     * @ref http://blog.clares.com.br/php-mascara-cnpj-cpf-data-e-qualquer-outra-coisa/
     * @return type
     */
    public function mascara($val, $mask) {
        $maskared = '';
        $k = 0;
        for ($i = 0; $i <= strlen($mask) - 1; $i++) {
            if ($mask[$i] == '#') {
                if (isset($val[$k])) {
                    $maskared .= $val[$k++];
                }
            } else {
                if (isset($mask[$i])) {
                    $maskared .= $mask[$i];
                }
            }
        }
        return $maskared;
    }

    /**
     * 
     * @param type $var
     * @return type
     */
    public function limparMascara($var) {
        $crt = array('.', '-');
        $response = str_replace($crt, '', $var);
        return $response;
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

    /**
     * 
     * @param type $data
     *
     * @param type $format
     * <br>
     * 1: return dd/mm/YYYY
     * <br>
     * 2: return YYYY-mm-dd
     * <br>
     *  @return string
     */
    public function convertData($data, $format) {
        switch ($format) {
            case 1:
                $data = explode('-', $data);
                $data = $data[2] . '/' . $data[1] . '/' . $data[0];

                break;
            case 2:
                $data = explode('/', $data);
                $data = $data[2] . '-' . $data[1] . '-' . $data[0];

                break;
        }
        return $data;
    }

    /**
     * 
     * @param type $vlr
     * @param type $tipo 
     * <br> 1: base64_encode
     * <br> 2: base64_decode
     * @return type
     */
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
