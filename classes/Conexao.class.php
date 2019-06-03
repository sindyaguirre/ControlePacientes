<?php
/* Define o limite de tempo da sessão em 60 minutos */
session_cache_expire(60);

// Inicia a sessão
session_start();


/**
 * Description of Conexa
 *
 * @author Sindy Antunes Aguirre
 * @email sindy_antunes@hotmail.com github https://github.com/sindyaguirre
 */

// Variável que verifica se o usuário está logado
if (!isset($_SESSION['logado'])) {
    $_SESSION['logado'] = false;
}

class Conexao {

    private $usuario;
    private $senha;
    private $banco;
    private $servidor;
    private static $pdo;

    public function __construct() {
        $this->servidor = "localhost";
        $this->banco = "controlePacientes";
        $this->usuario = "root";
        $this->senha = "";
    }

    public function conectar() {
        try {
            if (is_null(self::$pdo)) {
                self::$pdo = new PDO("mysql:host=" . $this->servidor .
                        ";dbname=" . $this->banco, $this->usuario, $this->senha);
                return self::$pdo;
            }
        } catch (Exception $exc) {
            return $ex->getMessage();
        }
    }

}
